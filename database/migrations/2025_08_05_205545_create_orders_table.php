<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->enum('payer_type', ['individual', 'company']);
            $table->string('email');
            $table->string('phone');
            $table->string('inn')->nullable();
            $table->foreignId('delivery_method_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('delivery_price', 10, 2)->default(0);
            $table->text('delivery_address')->nullable();
            $table->decimal('total_price', 10, 2)->default(0);
            $table->enum('status', ['new', 'in_progress', 'done', 'canceled'])->default('new');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
