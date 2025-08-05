<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('construction_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('construction_id')->constrained()->onDelete('cascade');
            $table->integer('length'); // мм
            $table->integer('width');  // мм
            $table->integer('height'); // мм
            $table->boolean('stock')->default(true); // в наличии или нет
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('construction_sizes');
    }
};
