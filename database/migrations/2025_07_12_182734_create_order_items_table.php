<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
    
            // Поля из конфигуратора
            $table->integer('length');
            $table->integer('width');
            $table->integer('height');
            $table->unsignedBigInteger('box_type_id');
            $table->string('cardboard_thickness');
            $table->string('cardboard_color');
            $table->string('cardboard_strength');
            $table->integer('quantity');
            $table->string('print_type')->nullable();
            $table->string('print_size')->nullable();
            $table->boolean('need_logo_design')->nullable();
            $table->string('design_file')->nullable();
    
            $table->decimal('price_per_box', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->decimal('volume', 10, 4)->nullable();
            $table->decimal('weight', 10, 2)->nullable();
    
            $table->timestamps();
        });
    }
    
    
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
