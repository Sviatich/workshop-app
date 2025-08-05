<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateRequest;
use App\Calculators\Fefco0427Calculator;
use App\Calculators\Fefco0426Calculator;
use App\Calculators\Fefco0201Calculator;
use App\Calculators\Fefco0300Calculator;
use App\Helpers\SizeMatcher;

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

        if (isset($result['error'])) {
            return response()->json($result, 422);
        }

        // Проверяем размеры
        $exactMatch = SizeMatcher::isExactMatch(
            $data['construction'],
            (int) $data['length'],
            (int) $data['width'],
            (int) $data['height']
        );

        // Если нестандарт — добавляем надбавку 5000 ₽
        if (!$exactMatch) {
            $result['price_per_unit'] = round($result['price_per_unit'] + (5000 / $data['tirage']), 2);
            $result['total_price'] = round($result['total_price'] + 5000, 2);
        }

        // Находим ближайшие размеры
        $nearestSizes = SizeMatcher::findNearest(
            $data['construction'],
            (int) $data['length'],
            (int) $data['width'],
            (int) $data['height']
        );

        // Добавляем в ответ
        $result['exact_match'] = $exactMatch;
        $result['nearest_sizes'] = $nearestSizes;

        return response()->json($result);
    }
}
