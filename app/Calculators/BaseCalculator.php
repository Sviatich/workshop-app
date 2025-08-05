<?php

namespace App\Calculators;

use App\Models\CartonColor;

abstract class BaseCalculator implements BoxCalculatorInterface
{
    protected float $thickness = 0.0015; // 1.5 мм
    // protected float $minArea = 0.8; // м² Требование Алексея, которое пока что не метчится с нашими же размерами.
    protected float $minArea = 4.0; // м²
    protected float $workCost = 1500; // ₽ / тираж
    protected float $markup = 1.5; // наценка
    protected float $weightPerM2 = 0.7; // кг

    protected function getCartonPrice(string $colorCode): float
    {
        return CartonColor::where('code', $colorCode)->value('price_per_m2') ?? 0;
    }

    protected function applyMarkup(float $value): float
    {
        return $value * $this->markup;
    }
}
