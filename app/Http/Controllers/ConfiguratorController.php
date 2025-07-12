<?php

namespace App\Http\Controllers;

use App\Models\BoxType;
use App\Models\OptionPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfiguratorController extends Controller
{
    public function index()
    {
        $boxTypes = BoxType::all();

        return view('configurator.index', compact('boxTypes'));
    }
    public function calculate(Request $request)
    {
        // 1. Валидация
        $validator = Validator::make($request->all(), [
            'length' => 'required|numeric|min:1',
            'width' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'quantity' => 'required|numeric|min:1',
            'thickness' => 'required',
            'color' => 'required',
            'strength' => 'required',
            'box_type_id' => 'required|exists:box_types,id',
            'print_type' => 'nullable|in:none,print,sticker,wrapper',
            'print_size' => 'nullable|in:small,medium,large',
            'need_logo_design' => 'nullable|boolean',
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'error' => 'Некорректные данные',
                'details' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // 2. Расчёт базовой стоимости
        $basePrice = 10; // можешь потом вынести в config или в БД

        // 3. Применяем модификаторы
        $modifiers = collect([
            ['key' => 'quantity', 'value' => $data['quantity']],
            ['key' => 'thickness', 'value' => $data['thickness']],
            ['key' => 'color', 'value' => $data['color']],
            ['key' => 'strength', 'value' => $data['strength']],
        ]);

        foreach ($modifiers as $mod) {
            $modVal = OptionPricing::where('option_key', $mod['key'])
                ->where('option_value', $mod['value'])
                ->value('price_modifier');

            $basePrice += $modVal ?? 0;
        }

        // Фиксированная надбавка за разработку логотипа
        if (!empty($data['need_logo_design'])) {
            $basePrice += 2000 / $data['quantity']; // распределяем на одну коробку
        }

        // Надбавка за оформление
        if (!empty($data['print_type']) && $data['print_type'] !== 'none') {
            $type = $data['print_type'];
            $size = $data['print_size'] ?? 'medium';
        
            // Простая надбавка — можно потом в БД
            $mod = match ($size) {
                'small' => 3,
                'medium' => 5,
                'large' => 8,
                default => 5
            };
        
            $basePrice += $mod;
        }


        // 4. Расчёт веса и объёма (простая модель)
        $volume = (($data['length'] / 1_000) * ($data['width'] / 1_000) * ($data['height'] / 1_000)); // м³
        $weight = round($volume * 0.7, 2); // ~плотность картона, поправь при необходимости

        // 5. Финальный расчёт
        $pricePerBox = round($basePrice, 2);
        $totalPrice = round($pricePerBox * $data['quantity'], 2);

        return response()->json([
            'price_per_box' => $pricePerBox,
            'total_price' => $totalPrice,
            'volume' => round($volume, 4),
            'weight' => $weight,
        ]);
    }
}
