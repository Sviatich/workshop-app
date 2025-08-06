<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Construction;
use App\Models\CartonColor;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {
        $data = $request->validated();
        $order = Order::create([
            'uuid' => Str::uuid(),
            'payer_type' => $data['payer_type'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'inn' => $data['payer_type'] === 'company' ? $data['inn'] : null,
            'delivery_method_id' => $data['delivery_method_id'],
            'delivery_price' => 0,
            'delivery_address' => $data['delivery_address'],
            'total_price' => array_sum(array_column($data['cart'], 'total_price')),
            'status' => 'new'
        ]);

        foreach ($data['cart'] as $item) {
            // Получаем читаемые названия из БД
            $constructionName = Construction::where('code', $item['construction'])->value('name') ?? $item['construction'];
            $colorName = CartonColor::where('code', $item['color'])->value('name') ?? $item['color'];

            // Добавляем в конфиг JSON
            $item['construction_name'] = $constructionName;
            $item['color_name'] = $colorName;

            OrderItem::create([
                'order_id' => $order->id,
                'config_json' => $item,
                'price_per_unit' => $item['price_per_unit'],
                'total_price' => $item['total_price'],
                'weight' => $item['weight'],
                'volume' => $item['volume']
            ]);
        }

        return response()->json(['uuid' => $order->uuid]);
    }

    public function show($uuid)
    {
        $order = Order::where('uuid', $uuid)->with('items')->firstOrFail();
        return view('order', compact('order'));
    }
}
