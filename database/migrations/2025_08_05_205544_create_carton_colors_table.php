<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carton_colors', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // brown, white_in, white
            $table->string('name');
            $table->decimal('price_per_m2', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carton_colors');
    }
};
