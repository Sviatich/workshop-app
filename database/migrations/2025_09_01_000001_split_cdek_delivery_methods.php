<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Ensure two separate SDEK methods exist
        $now = now();
        $rows = [
            ['code' => 'cdek_pvz', 'name' => 'СДЭК ПВЗ', 'description' => 'Доставка до пункта выдачи CDEK', 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'cdek_courier', 'name' => 'Курьер СДЭК', 'description' => 'Курьерская доставка CDEK до двери', 'active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        foreach ($rows as $row) {
            $exists = DB::table('delivery_methods')->where('code', $row['code'])->exists();
            if (!$exists) DB::table('delivery_methods')->insert($row);
        }

        // Optionally deactivate legacy 'cdek' if exists
        DB::table('delivery_methods')->where('code', 'cdek')->update(['active' => false]);
    }

    public function down(): void
    {
        DB::table('delivery_methods')->whereIn('code', ['cdek_pvz', 'cdek_courier'])->delete();
        // Reactivate legacy if present
        DB::table('delivery_methods')->where('code', 'cdek')->update(['active' => true]);
    }
};

