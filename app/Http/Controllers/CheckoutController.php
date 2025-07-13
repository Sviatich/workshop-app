<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\BoxType;
use App\Models\OrderItem;
use App\Services\PriceCalculatorService;

class CheckoutController extends Controller
{
    public function form(Request $request, PriceCalculatorService $service)
    {
        $validated = $request->validate([
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'box_type_id' => 'required|exists:box_types,id',
            'cardboard_thickness' => 'required',
            'cardboard_color' => 'required',
            'cardboard_strength' => 'required',
            'quantity' => 'required|numeric',
            'print_type' => 'nullable|in:none,print,sticker,wrapper',
            'print_size' => 'nullable|in:small,medium,large',
            'need_logo_design' => 'nullable|boolean',
        ]);

        $result = $service->calculate($validated);

        return view('checkout.form', [
            'data' => $validated,
            'boxType' => BoxType::find($validated['box_type_id']),
            'pricePerBox' => $result['price_per_box'],
            'totalPrice' => $result['total_price'],
            'volume' => $result['volume'],
            'weight' => $result['weight'],
        ]);
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'delivery_method' => 'required|in:pickup,cdek,pek,own',
            'delivery_address' => 'required|string',
            'customer_type' => 'required|in:person,business',
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'customer_inn' => 'nullable|string',
        ]);
    
        $cart = session('checkout_cart', []);
    
        if (empty($cart)) {
            return redirect()->route('checkout.show')->with('error', 'Корзина пуста');
        }
    
        $uuid = (string) Str::uuid();
    
        $totalPrice = array_sum(array_column($cart, 'total_price'));
        $totalWeight = array_sum(array_column($cart, 'weight'));
        $totalVolume = array_sum(array_column($cart, 'volume'));
    
        $order = Order::create([
            'uuid' => $uuid,
            'status' => 'new',
            'price_per_box' => null,
            'total_price' => $totalPrice,
            'volume' => $totalVolume,
            'weight' => $totalWeight,
            'delivery_method' => $validated['delivery_method'],
            'delivery_address' => $validated['delivery_address'],
            'customer_type' => $validated['customer_type'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'customer_inn' => $validated['customer_inn'],
        ]);
    
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'length' => $item['length'],
                'width' => $item['width'],
                'height' => $item['height'],
                'box_type_id' => $item['box_type_id'],
                'cardboard_thickness' => $item['thickness'],
                'cardboard_color' => $item['color'],
                'cardboard_strength' => $item['strength'],
                'quantity' => $item['quantity'],
                'print_type' => $item['print_type'] ?? null,
                'print_size' => $item['print_size'] ?? null,
                'need_logo_design' => isset($item['need_logo_design']) ? true : false,
                'design_file' => $item['design_file'] ?? null,
                'price_per_box' => $item['price_per_box'],
                'total_price' => $item['total_price'],
                'volume' => $item['volume'],
                'weight' => $item['weight'],
            ]);
        }
    
        session()->forget('checkout_cart');
    
        return redirect()->route('order.show', $uuid);
    }


    public function showForm()
    {
        $cart = session('checkout_cart', []);
    
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Корзина пуста.');
        }
    
        return view('checkout.form', [
            'cart' => $cart,
            'total' => array_sum(array_column($cart, 'total_price')),
        ]);
    }

    public function storeData(Request $request, PriceCalculatorService $service)
    {
        $validated = $request->validate([
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'box_type_id' => 'required|exists:box_types,id',
            'thickness' => 'required',
            'color' => 'required',
            'strength' => 'required',
            'quantity' => 'required|numeric',
            'print_type' => 'nullable|in:none,print,sticker,wrapper',
            'print_size' => 'nullable|in:small,medium,large',
            'need_logo_design' => 'nullable|boolean',
            'design_file' => 'nullable|file|max:10240',
        ]);

        $result = $service->calculate($validated);

        $validated = array_merge($validated, $result);

        // загрузка файла
        if ($request->hasFile('design_file')) {
            $path = $request->file('design_file')->store('designs/temp', 'public');
            $validated['design_file'] = $path;
        }

        // добавление в сессию как в массив
        $cart = session('checkout_cart', []);
        $cart[] = $validated;
        session(['checkout_cart' => $cart]);

        return response()->noContent();
    }

}
