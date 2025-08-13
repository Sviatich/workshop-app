<?php

namespace App\Calculators;

class Fefco0215Calculator extends BaseCalculator
{
    public function calculate(array $data): array
    {
        $L = $data['length'];
        $W = $data['width'];
        $H = $data['height'];
        $tirage = $data['tirage'];
        $color = $data['color'];

        $Lsheet = $L + 2 * $H + 30 + 35;
        $Wsheet = 2 * $W + $H + 30 + 30;
        $S = ($Lsheet * $Wsheet) / 1_000_000;

        if ($S <= 0 || $S > $this->minArea) {
            return ['error' => 'Недопустимые размеры (площадь больше 0.8 м²)'];
        }

        $cartonPrice = $this->getCartonPrice($color);
        $pricePerUnit = $this->applyMarkup(($S * $cartonPrice) + ($this->workCost / $tirage));
        $totalPrice = $pricePerUnit * $tirage;
        $weight = $tirage * $S * $this->weightPerM2;
        $volume = $S * $this->thickness * $tirage;

        return [
            'price_per_unit' => round($pricePerUnit, 2),
            'total_price'    => round($totalPrice, 2),
            'weight'         => round($weight, 3),
            'volume'         => round($volume, 3),
        ];
    }
}
