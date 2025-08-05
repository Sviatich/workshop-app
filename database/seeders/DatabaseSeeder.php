<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ConstructionSeeder::class,
            CartonColorSeeder::class,
            DeliveryMethodSeeder::class,
        ]);
    }
}
