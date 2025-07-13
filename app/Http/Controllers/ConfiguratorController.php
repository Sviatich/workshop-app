<?php

namespace App\Http\Controllers;

use App\Models\BoxType;
use App\Services\PriceCalculatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfiguratorController extends Controller
{
    public function index()
    {
        $boxTypes = BoxType::all();

        return view('configurator.index', compact('boxTypes'));
    }
    public function calculate(Request $request, PriceCalculatorService $service)
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

        $data = $validator->validated();

        return response()->json($service->calculate($data));
    }
}
