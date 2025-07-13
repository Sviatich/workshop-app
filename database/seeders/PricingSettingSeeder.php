<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PricingSetting;

class PricingSettingSeeder extends Seeder
{
    public function run(): void
    {
        PricingSetting::updateOrCreate(
            ['key' => 'base_price'],
            ['value' => 10]
        );
    }
}
