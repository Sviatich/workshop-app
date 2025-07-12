<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Сначала удаляем внешний ключ
            $table->dropForeign(['box_type_id']);
        });
    
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'length',
                'width',
                'height',
                'box_type_id',
                'cardboard_thickness',
                'cardboard_color',
                'cardboard_strength',
                'quantity',
                'print_type',
                'print_size',
                'need_logo_design',
                'design_file',
                'price_per_box',
            ]);
        });
    } 

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('length');
            $table->integer('width');
            $table->integer('height');
            $table->foreignId('box_type_id')->constrained('box_types')->cascadeOnDelete();
            $table->enum('cardboard_thickness', [1.5, 3.0]);
            $table->enum('cardboard_color', ['brown', 'white']);
            $table->enum('cardboard_strength', ['econom', 'business']);
            $table->integer('quantity');
            $table->enum('print_type', ['none', 'print', 'sticker', 'wrapper'])->default('none');
            $table->string('print_size')->nullable();
            $table->boolean('need_logo_design')->default(false);
            $table->string('design_file')->nullable();
            $table->decimal('price_per_box', 10, 2);
        });
    }
};
