<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('option_pricings', function (Blueprint $table) {
            $table->id();
            $table->string('option_key');      // например, 'quantity'
            $table->string('option_value');    // например, '100'
            $table->decimal('price_modifier', 8, 2);  // например, 2.5
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('option_pricings');
    }
};
