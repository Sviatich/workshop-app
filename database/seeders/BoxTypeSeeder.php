<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BoxType;

class BoxTypeSeeder extends Seeder
{
    public function run(): void
    {
        BoxType::insert([
            ['name' => 'Самосборная 0427', 'slug' => 'self-assembly-0427'],
            ['name' => 'Ласточкин хвост', 'slug' => 'dovetail'],
            ['name' => 'Крышка-дно', 'slug' => 'lid-bottom'],
            ['name' => 'Коробка чемодан', 'slug' => 'suitcase'],
            ['name' => 'Транспортировочный короб', 'slug' => 'transport'],
        ]);
    }
}
