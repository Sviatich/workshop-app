<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryMethod;

class DeliveryMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            ['code' => 'pickup', 'name' => 'Самовывоз', 'description' => 'Забрать из точки выдачи'],
            ['code' => 'cdek_courier', 'name' => 'СДЭК до двери', 'description' => 'Доставка курьером до двери'],
            ['code' => 'cdek_pvz', 'name' => 'СДЭК до ПВЗ', 'description' => 'Доставка в пункт выдачи заказов'],
        ];

        foreach ($methods as $method) {
            DeliveryMethod::create($method);
        }
    }
}
