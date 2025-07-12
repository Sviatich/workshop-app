<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Размеры
            $table->integer('length');
            $table->integer('width');
            $table->integer('height');

            // Характеристики
            $table->foreignId('box_type_id')->constrained('box_types')->cascadeOnDelete();
            $table->enum('cardboard_thickness', [1.5, 3.0]);
            $table->enum('cardboard_color', ['brown', 'white']);
            $table->enum('cardboard_strength', ['econom', 'business']);
            $table->integer('quantity');

            // Оформление
            $table->enum('print_type', ['none', 'print', 'sticker', 'wrapper'])->default('none');
            $table->string('print_size')->nullable();
            $table->boolean('need_logo_design')->default(false);
            $table->string('design_file')->nullable();

            // Доставка
            $table->enum('delivery_method', ['pickup', 'cdek', 'pek', 'own'])->default('pickup');
            $table->string('delivery_address');
            $table->decimal('weight', 8, 2);
            $table->decimal('volume', 8, 2);

            // Клиент
            $table->enum('customer_type', ['person', 'business']);
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('customer_inn')->nullable();

            // Цены
            $table->decimal('price_per_box', 10, 2);
            $table->decimal('total_price', 10, 2);

            // Статус и UUID
            $table->string('uuid')->unique();
            $table->enum('status', ['new', 'paid', 'shipped', 'deleted'])->default('new');

            $table->timestamps();
        });
    }


    
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

