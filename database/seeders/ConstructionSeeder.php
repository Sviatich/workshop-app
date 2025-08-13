<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Construction;

class ConstructionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['code' => 'fefco_0427', 'name' => 'Самосборная коробка (FEFCO 0427)'],
            ['code' => 'fefco_0426', 'name' => 'Коробка для пиццы (FEFCO 0426)'],
            ['code' => 'fefco_0201', 'name' => 'Транспортировочный короб (FEFCO 0201)'],
            ['code' => 'fefco_0215', 'name' => 'Ласточкин хвост (FEFCO 0215)'],
        ];

        foreach ($data as $item) {
            Construction::create($item);
        }
    }
}
