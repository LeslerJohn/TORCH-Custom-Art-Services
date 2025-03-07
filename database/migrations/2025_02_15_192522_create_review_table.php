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
        Schema::create('order_review', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('order_id')->constrained('order')->cascadeOnDelete();
            $table->string('comment', 255);
            $table->integer('rating');
            $table->timestamps();
        });

        Schema::create('commission_review', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('commission_id')->constrained('commission')->cascadeOnDelete();
            $table->string('comment', 255);
            $table->integer('rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_review');
        Schema::dropIfExists('commission_review');
    }
};
