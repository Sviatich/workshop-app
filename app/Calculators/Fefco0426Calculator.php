<?php

namespace App\Calculators;

class Fefco0426Calculator extends BaseCalculator
{
    public function calculate(array $data): array
    {
        $L = $data['length'];
        $W = $data['width'];
        $H = $data['height'];
        $tirage = $data['tirage'];
        $color = $data['color'];

        $Lsheet = 2 * $H + $L + 50;
        $Wsheet = 4 * $H + 2 * $W + 60;
        $S = ($Lsheet * $Wsheet) / 1_000_000;

        if ($S <= 0 || $S > $this->minArea) {
            return ['error' => 'Недопустимые размеры (площадь больше 4.0 м²)'];
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
            // Flat-pack parcel geometry for shipping
            'parcel_length_mm'       => (int) ceil($Lsheet),
            'parcel_width_mm'        => (int) ceil($Wsheet),
            'parcel_unit_height_mm'  => $this->thickness * 1000, // 1.5 mm per unit
            'parcel_total_height_mm' => $this->thickness * 1000 * $tirage,
        ];
    }
}
