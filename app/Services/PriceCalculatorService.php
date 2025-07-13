<?php

namespace App\Services;

use App\Models\OptionPricing;
use App\Models\PricingSetting;

class PriceCalculatorService
{
    public function calculate(array $data): array
    {
        // Map aliases
        $mapped = [
            'length' => $data['length'] ?? null,
            'width' => $data['width'] ?? null,
            'height' => $data['height'] ?? null,
            'quantity' => $data['quantity'] ?? null,
            'thickness' => $data['thickness'] ?? $data['cardboard_thickness'] ?? null,
            'color' => $data['color'] ?? $data['cardboard_color'] ?? null,
            'strength' => $data['strength'] ?? $data['cardboard_strength'] ?? null,
            'print_type' => $data['print_type'] ?? null,
            'print_size' => $data['print_size'] ?? null,
            'need_logo_design' => $data['need_logo_design'] ?? null,
        ];

        $basePrice = (float) PricingSetting::where('key', 'base_price')->value('value');
        if ($basePrice === 0.0) {
            $basePrice = 10.0; // default fallback
        }

        $modifiers = [
            ['key' => 'quantity', 'value' => $mapped['quantity']],
            ['key' => 'thickness', 'value' => $mapped['thickness']],
            ['key' => 'color', 'value' => $mapped['color']],
            ['key' => 'strength', 'value' => $mapped['strength']],
        ];

        foreach ($modifiers as $mod) {
            $modVal = OptionPricing::where('option_key', $mod['key'])
                ->where('option_value', $mod['value'])
                ->value('price_modifier');

            $basePrice += $modVal ?? 0;
        }

        if (!empty($mapped['need_logo_design'])) {
            $basePrice += 2000 / $mapped['quantity'];
        }

        if (!empty($mapped['print_type']) && $mapped['print_type'] !== 'none') {
            $size = $mapped['print_size'] ?? 'medium';
            $basePrice += match ($size) {
                'small' => 3,
                'medium' => 5,
                'large' => 8,
                default => 5,
            };
        }

        $volume = (($mapped['length'] / 1000) * ($mapped['width'] / 1000) * ($mapped['height'] / 1000));
        $weight = round($volume * 0.7, 2);

        $pricePerBox = round($basePrice, 2);
        $totalPrice = round($pricePerBox * $mapped['quantity'], 2);

        return [
            'price_per_box' => $pricePerBox,
            'total_price' => $totalPrice,
            'volume' => round($volume, 4),
            'weight' => $weight,
        ];
    }
}
