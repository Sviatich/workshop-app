<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\BoxType;

class CheckoutController extends Controller
{
    public function form(Request $request)
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

        // Пример расчёта
        $basePrice = 10;
        $pricePerBox = $basePrice;
        $totalPrice = $pricePerBox * $validated['quantity'];
        $volume = ($validated['length'] * $validated['width'] * $validated['height']) / 1_000_000;
        $weight = round($volume * 0.7, 2);

        return view('checkout.form', [
            'data' => $validated,
            'boxType' => BoxType::find($validated['box_type_id']),
            'pricePerBox' => $pricePerBox,
            'totalPrice' => $totalPrice,
            'volume' => $volume,
            'weight' => $weight,
        ]);
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'length' => 'required',
            'width' => 'required',
            'height' => 'required',
            'box_type_id' => 'required',
            'thickness' => 'required',
            'color' => 'required',
            'strength' => 'required',
            'quantity' => 'required',
            'print_type' => 'nullable',
            'print_size' => 'nullable',
            'need_logo_design' => 'nullable',
            'delivery_method' => 'required|in:pickup,cdek,pek,own',
            'delivery_address' => 'required|string',
            'customer_type' => 'required|in:person,business',
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'customer_phone' => 'required',
            'customer_inn' => 'nullable',
            'design_file' => 'nullable|string|max:255',
        ]);

        $uuid = (string) Str::uuid();

        if ($request->hasFile('design_file')) {
            $data['design_file'] = $request->file('design_file')->store("designs/{$uuid}", 'public');
        }

        $data['uuid'] = $uuid;
        $data['status'] = 'new';
        $data['price_per_box'] = 10;
        $data['total_price'] = 10 * $data['quantity'];
        $data['volume'] = ($data['length'] * $data['width'] * $data['height']) / 1_000_000;
        $data['weight'] = round($data['volume'] * 0.7, 2);

        $order = Order::create($data);

        return redirect()->route('order.show', $uuid);
    }

    public function showForm(Request $request)
    {
        $data = session('checkout_data');

        if (!$data) {
            return redirect()->route('home')->with('error', 'Сначала рассчитайте заказ.');
        }

        return view('checkout.form', [
            'data' => $data,
            'boxType' => \App\Models\BoxType::find($data['box_type_id']),
            'pricePerBox' => $data['price_per_box'],
            'totalPrice' => $data['total_price'],
            'volume' => $data['volume'],
            'weight' => $data['weight'],
        ]);
    }

    public function storeData(Request $request)
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

        if ($request->hasFile('design_file')) {
            $file = $request->file('design_file');
            $path = $file->store("designs/temp", 'public');
            
            // важно: сохраняем путь как строку, а не объект или массив
            $validated['design_file'] = $path;
        } else {
            $validated['design_file'] = null; // на всякий случай явно обнуляем
        }

        session(['checkout_data' => $validated]);

        return response()->noContent(); // 204
    }

}
