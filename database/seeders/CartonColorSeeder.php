<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CartonColor;

class CartonColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['code' => 'brown', 'name' => 'Бурый', 'price_per_m2' => 50],
            ['code' => 'white_in', 'name' => 'Белый/Бурый', 'price_per_m2' => 60],
            ['code' => 'white', 'name' => 'Белый', 'price_per_m2' => 150],
            ['code' => 'black', 'name' => 'Черный', 'price_per_m2' => 60],
        ];

        foreach ($colors as $color) {
            CartonColor::create($color);
        }
    }
}
