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
        Schema::create('client_liked', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('client_profile')->cascadeOnDelete();
            $table->foreignId('artwork_id')->constrained('artwork')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_liked');
    }
};
