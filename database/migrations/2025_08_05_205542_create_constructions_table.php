<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('constructions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // fefco_0427
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('animation')->nullable();
            $table->string('bigpicture')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('constructions');
    }
};
