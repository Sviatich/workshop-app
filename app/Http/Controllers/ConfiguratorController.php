<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateRequest;
use App\Calculators\Fefco0427Calculator;
use App\Calculators\Fefco0426Calculator;
use App\Calculators\Fefco0201Calculator;
use App\Calculators\Fefco0300Calculator;

class ConfiguratorController extends Controller
{
    public function calculate(CalculateRequest $request)
    {
        $data = $request->validated();

        $calculators = [
            'fefco_0427' => Fefco0427Calculator::class,
            'fefco_0426' => Fefco0426Calculator::class,
            'fefco_0201' => Fefco0201Calculator::class,
            'fefco_0300' => Fefco0300Calculator::class,
        ];

        $calcClass = $calculators[$data['construction']] ?? null;

        if (!$calcClass) {
            return response()->json(['error' => 'Неизвестная конструкция'], 400);
        }

        $calculator = new $calcClass();
        $result = $calculator->calculate($data);

        return response()->json($result);
    }
}
