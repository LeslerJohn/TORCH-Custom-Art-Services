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
        Schema::create('extension', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignId('commission_id')->constrained('commission')->cascadeOnDelete();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reason');
            $table->foreignId('artist_id')->constrained('artist_profile')->cascadeOnDelete();
            $table->foreignId('attachment_id')->nullable()->constrained('attachment')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extension');
    }
};
