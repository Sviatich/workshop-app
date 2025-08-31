<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryMethod;

class DeliveryMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            ['code' => 'pickup', 'name' => 'Самовывоз', 'description' => 'Забрать со склада нашей компании'],
            ['code' => 'cdek_courier', 'name' => 'СДЭК', 'description' => 'Доставка курьерской компанией СДЭК'],
            ['code' => 'cdek_pvz', 'name' => 'ПЭК', 'description' => 'Бесплатно доставим до ближайшего пункта приема заказов'],
        ];

        foreach ($methods as $method) {
            DeliveryMethod::create($method);
        }
    }
}
