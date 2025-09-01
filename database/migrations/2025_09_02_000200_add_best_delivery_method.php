<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $exists = DB::table('delivery_methods')->where('code', 'best')->exists();
        if (!$exists) {
            DB::table('delivery_methods')->insert([
                'code' => 'best',
                'name' => 'Подобрать оптимальную доставку',
                'description' => 'Оператор свяжется с вами, согласует способ доставки и назовёт окончательную сумму с учётом стоимости доставки',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('delivery_methods')->where('code', 'best')->delete();
    }
};

