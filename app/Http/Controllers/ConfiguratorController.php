<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateRequest;
use App\Calculators\Fefco0427Calculator;
use App\Calculators\Fefco0426Calculator;
use App\Calculators\Fefco0201Calculator;
use App\Calculators\Fefco0215Calculator;
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
            'fefco_0215' => Fefco0215Calculator::class,
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

        // Если включена полноцветная печать — расчёт не выполняем
        if (!empty($data['fullprint']['enabled'])) {
            return response()->json([
                'error' => false,
                'manager_approval_required' => true,
            ]);
        }

        // +10 ₽ за логотип, если он есть
        if (!empty($data['has_logo'])) {
            $result['price_per_unit'] = round($result['price_per_unit'] + 10, 2);
            $result['total_price'] = round($result['price_per_unit'] * $data['tirage'], 2);
        }

        // Проверка точного совпадения
        $exactMatch = SizeMatcher::isExactMatch(
            $data['construction'],
            (int) $data['length'],
            (int) $data['width'],
            (int) $data['height']
        );

        if ($exactMatch) {
            $result['exact_match'] = true;
            $result['nearest_sizes'] = [];
        } else {
            // Добавляем надбавку за нестандарт
            $result['price_per_unit'] = round($result['price_per_unit'] + (5000 / $data['tirage']), 2);
            $result['total_price'] = round($result['total_price'] + 5000, 2);

            $result['exact_match'] = false;
            $result['nearest_sizes'] = SizeMatcher::findNearest(
                $data['construction'],
                (int) $data['length'],
                (int) $data['width'],
                (int) $data['height']
            );
        }

        return response()->json($result);
    }

}
