<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Construction;
use App\Models\CartonColor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {
        $cart = $request->input('cart');

        $order = Order::create([
            'uuid' => Str::uuid(),
            'payer_type' => $request->payer_type,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'inn' => $request->payer_type === 'company' ? $request->inn : null,
            'delivery_method_id' => $request->delivery_method_id,
            'delivery_price' => (float) ($request->input('delivery_price', 0)),
            'delivery_address' => $request->delivery_address,
            'total_price' => array_sum(array_column($cart, 'total_price')),
            'status' => 'new'
        ]);

        foreach ($cart as $index => $item) {
            // Получаем читаемые названия конструкции и цвета
            $constructionName = Construction::where('code', $item['construction'])->value('name') ?? $item['construction'];
            $colorName = CartonColor::where('code', $item['color'])->value('name') ?? $item['color'];
            $item['construction_name'] = $constructionName;
            $item['color_name'] = $colorName;

            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'config_json' => $item,
                'price_per_unit' => $item['price_per_unit'],
                'total_price' => $item['total_price'],
                'weight' => $item['weight'],
                'volume' => $item['volume'],
            ]);

            // Копирование логотипа, если указан путь
            if (!empty($item['logo']['file_path'])) {
                $this->copyTmpFileToOrder($item['logo']['file_path'], $order->uuid, $orderItem->id, 'logo');
            }

            // Копирование макета (печати), если указан путь
            if (!empty($item['fullprint']['file_path'])) {
                $this->copyTmpFileToOrder($item['fullprint']['file_path'], $order->uuid, $orderItem->id, 'print');
            }
        }

        return response()->json(['uuid' => $order->uuid]);
    }

    private function copyTmpFileToOrder(string $tmpPath, string $uuid, int $orderItemId, string $type)
    {
        $tmpPath = ltrim($tmpPath, '/'); // убираем начальный слэш
        $relativePath = str_replace('storage/', '', $tmpPath); // получаем относительный путь в public disk

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
