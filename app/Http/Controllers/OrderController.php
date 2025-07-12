<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'length' => 'required|numeric|min:1',
            'width' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'box_type_id' => 'required|exists:box_types,id',
            'cardboard_thickness' => 'required',
            'cardboard_color' => 'required',
            'cardboard_strength' => 'required',
            'quantity' => 'required|numeric|min:1',
            'print_type' => 'nullable|in:none,print,sticker,wrapper',
            'print_size' => 'nullable|in:small,medium,large',
            'need_logo_design' => 'nullable|boolean',
            'design_file' => 'nullable|file|max:10240',
            'delivery_method' => 'required|in:pickup,cdek,pek,own',
            'delivery_address' => 'required|string|max:255',
            'customer_type' => 'required|in:person,business',
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'customer_inn' => 'nullable|string',
        ]);

        $uuid = (string) Str::uuid();

        if ($request->hasFile('design_file')) {
            $file = $request->file('design_file');
            $path = $file->store("designs/{$uuid}", 'public');
            $data['design_file'] = $path;
        }

        // (можно здесь вставить расчёт как в calculate())

        $pricePerBox = 15;
        $totalPrice = $pricePerBox * $data['quantity'];
        $volume = ($data['length'] * $data['width'] * $data['height']) / 1_000_000;
        $weight = round($volume * 0.7, 2);

        $data['price_per_box'] = $pricePerBox;
        $data['total_price'] = $totalPrice;
        $data['volume'] = $volume;
        $data['weight'] = $weight;
        $data['uuid'] = $uuid;
        $data['status'] = 'new';

        $order = Order::create($data);

        return redirect()->route('order.show', $uuid);
    }

    public function show($uuid)
    {
        $order = Order::where('uuid', $uuid)->with('items')->firstOrFail();
        return view('order.show', compact('order'));
    }

}
