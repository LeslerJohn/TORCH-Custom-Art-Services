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
        Schema::create('cart', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('client_id')->constrained('client_profile')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('cart_item', function (Blueprint $table) {
            $table->foreignUlid('cart_id')->constrained('cart')->cascadeOnDelete();
            $table->foreignUlid('artwork_id')->constrained('artwork')->cascadeOnDelete();
            $table->primary(['cart_id', 'artwork_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
        Schema::dropIfExists('cart_item');
    }
};
