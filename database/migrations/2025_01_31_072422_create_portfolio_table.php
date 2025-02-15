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
        Schema::create('portfolio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained('artist_profile')->cascadeOnDelete();
            $table->foreignId('portfolio_id')->constrained('attachment')->cascadeOnDelete();
            $table->string('link')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        Schema::create('artist_agreement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained('artist_profile')->cascadeOnDelete();
            $table->foreignId('attachment_id')->constrained('attachment')->cascadeOnDelete();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio');
    }
};
