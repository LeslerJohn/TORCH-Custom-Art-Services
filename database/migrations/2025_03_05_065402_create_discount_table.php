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
        Schema::create('discount', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('artwork_id')->constrained('artwork')->cascadeOnDelete();
            $table->enum('type', ['off_product', 'off_order'])->default('off_product');
            $table->integer('value');
            $table->enum('value_type', ['percentage', 'fixed']);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount');
    }
};
