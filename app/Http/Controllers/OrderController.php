<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Construction;
use App\Models\CartonColor;
use App\Calculators\Fefco0427Calculator;
use App\Calculators\Fefco0426Calculator;
use App\Calculators\Fefco0201Calculator;
use App\Calculators\Fefco0215Calculator;
use App\Helpers\SizeMatcher;
use Illuminate\Support\Str;
use App\Services\Bitrix24Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderNotification;

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {
        $data = $request->validated();
        $cart = $data['cart'] ?? [];

        $order = Order::create([
            'uuid' => Str::uuid(),
            'payer_type' => $request->payer_type,
            'full_name' => $request->full_name,
            'company_name' => $request->payer_type === 'company' ? ($request->company_name ?? null) : null,
            'email' => $request->email,
            'phone' => $request->phone,
            'inn' => $request->payer_type === 'company' ? $request->inn : null,
            'delivery_method_id' => $request->delivery_method_id,
            'delivery_price' => (float) ($request->input('delivery_price', 0)),
            'delivery_address' => $request->delivery_address,
            // Пересчитаем после сохранения позиций
            'total_price' => 0,
            'status' => 'new'
        ]);

        $calculators = [
            'fefco_0427' => Fefco0427Calculator::class,
            'fefco_0426' => Fefco0426Calculator::class,
            'fefco_0201' => Fefco0201Calculator::class,
            'fefco_0215' => Fefco0215Calculator::class,
        ];

        $orderTotal = 0.0;

        foreach ($cart as $index => $item) {
            // Расширим отображаемые названия на стороне сервера
            $constructionName = Construction::where('code', $item['construction'])->value('name') ?? $item['construction'];
            $colorName = CartonColor::where('code', $item['color'])->value('name') ?? $item['color'];
            $item['construction_name'] = $constructionName;
            $item['color_name'] = $colorName;

            // Серверный пересчет параметров позиции
            $calcClass = $calculators[$item['construction']] ?? null;
            if (!$calcClass) {
                return response()->json(['message' => 'Unsupported construction type'], 422);
            }

            $calculator = new $calcClass();
            $base = $calculator->calculate([
                'construction' => $item['construction'],
                'length' => (int) $item['length'],
                'width' => (int) $item['width'],
                'height' => (int) ($item['height'] ?? 0),
                'tirage' => (int) $item['tirage'],
                'color' => (string) $item['color'],
            ]);

            if (isset($base['error'])) {
                return response()->json($base, 422);
            }

            $pricePerUnit = (float) $base['price_per_unit'];
            $totalPrice = (float) $base['total_price'];
            $weight = (float) $base['weight'];
            $volume = (float) $base['volume'];

            $hasLogo = !empty($item['logo']['enabled']);
            $hasFullPrint = !empty($item['fullprint']['enabled']);

            if ($hasFullPrint) {
                $pricePerUnit = 0.0;
                $totalPrice = 0.0;
            } else {
                if ($hasLogo) {
                    $pricePerUnit = round($pricePerUnit + 10, 2);
                    $totalPrice = round($pricePerUnit * (int) $item['tirage'], 2);
                }

                $exactMatch = SizeMatcher::isExactMatch(
                    $item['construction'],
                    (int) $item['length'],
                    (int) $item['width'],
                    (int) $item['height']
                );

                if (!$exactMatch) {
                    $pricePerUnit = round($pricePerUnit + (5000 / max(1, (int) $item['tirage'])), 2);
                    $totalPrice = round($totalPrice + 5000, 2);
                }
            }

            $orderTotal += $totalPrice;

            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'config_json' => $item,
                'price_per_unit' => $pricePerUnit,
                'total_price' => $totalPrice,
                'weight' => $weight,
                'volume' => $volume,
            ]);

            // Перенесем временные файлы в постоянное хранилище заказа
            if (!empty($item['logo']['file_path'])) {
                $this->copyTmpFileToOrder($item['logo']['file_path'], $order->uuid, $orderItem->id, 'logo');
            }

            if (!empty($item['fullprint']['file_path'])) {
                $this->copyTmpFileToOrder($item['fullprint']['file_path'], $order->uuid, $orderItem->id, 'print');
            }
        }

        // Итог заказа с учетом доставки
        $order->update([
            'total_price' => round($orderTotal + (float) $order->delivery_price, 2),
        ]);

        // Send to Bitrix24 CRM (non-blocking: errors are logged)
        try {
            app(Bitrix24Service::class)->createDealFromOrderV2($order);
        } catch (\Throwable $e) {
            // Safety net: don't fail order flow because of CRM
            \Log::warning('Bitrix24 integration error', ['message' => $e->getMessage()]);
        }

        // Email notifications: customer + internal copy
        try {
            $subject = 'Новый заказ ' . (string) $order->uuid . ' принят';
            $heading = 'Ваш заказ принят в обработку';
            $text = 'Спасибо за заказ! Мы свяжемся с вами при необходимости.';
            Mail::to((string) $order->email)
                ->bcc('workshop@mp.market')
                ->send(new OrderNotification($order, $subject, $heading, $text));
        } catch (\Throwable $e) {
            \Log::warning('Order email sending failed', ['order_id' => $order->id, 'message' => $e->getMessage()]);
        }

        return response()->json(['uuid' => $order->uuid]);
    }

    private function copyTmpFileToOrder(string $tmpPath, string $uuid, int $orderItemId, string $type)
    {
        $tmpPath = ltrim($tmpPath, '/'); // нормализуем ведущие слеши
        $relativePath = str_replace('storage/', '', $tmpPath); // путь внутри public disk

        if (!Storage::disk('public')->exists($relativePath)) {
            return;
        }

        $filename = basename($relativePath);
        $newPath = "order_files/{$uuid}/" . $filename;

        Storage::disk('public')->copy($relativePath, $newPath);

        \App\Models\OrderFile::create([
            'order_item_id' => $orderItemId,
            'file_path' => $newPath,
            'file_type' => $type,
        ]);
    }

    public function show($uuid)
    {
        $order = Order::where('uuid', $uuid)->with(['items.files'])->firstOrFail();
        return view('order', compact('order'));
    }
}
