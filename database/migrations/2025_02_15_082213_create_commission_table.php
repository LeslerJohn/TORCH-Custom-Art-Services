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
        Schema::create('commission', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('request_id')->constrained('request')->cascadeOnDelete();
            $table->foreignUlid('delivery_id')->constrained('delivery')->cascadeOnDelete();
            $table->date('deadline')->nullable();
            $table->boolean('is_extended')->default(false);
            $table->date('extended_deadline')->nullable()->default(null);
            $table->enum('status', ['pending', 'ready', 'wip', 'done', 'completed', 'returned', 'hold'])->default('pending');
            $table->timestamps();
        });

        Schema::create('draft', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('commission_id')->constrained('commission')->cascadeOnDelete();
            $table->string('description', 255);
            $table->foreignUlid('attachment_id')->constrained('attachment')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draft');
        Schema::dropIfExists('commission');
    }
};
