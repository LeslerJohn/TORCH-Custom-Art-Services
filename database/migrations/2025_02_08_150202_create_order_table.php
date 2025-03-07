<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('client_id')->constrained('client_profile')->cascadeOnDelete();
            $table->decimal('total', 10, 2);
            $table->foreignUlid('delivery_id')->constrained('delivery')->cascadeOnDelete();
            $table->enum('status', ['pending', 'accepted', 'in-transit', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });

        Schema::create('order_item', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('order_id')->constrained('order')->cascadeOnDelete();
            $table->foreignUlid('artwork_id')->constrained('artwork')->cascadeOnDelete();
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        Schema::create('delivery', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->date('expected_delivery')->nullable();
            $table->foreignUlid('address_id')->constrained('address')->cascadeOnDelete();
            $table->enum('status', ['pending', 'in-transit', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });

        Schema::create('address', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('client_id')->constrained('client_profile')->cascadeOnDelete();
            $table->string('street');
            $table->string('barangay');
            $table->string('house_number');
            $table->string('zip_code')->default('7000');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
        Schema::dropIfExists('order_item');
        Schema::dropIfExists('delivery');
        Schema::dropIfExists('address');
    }
};
