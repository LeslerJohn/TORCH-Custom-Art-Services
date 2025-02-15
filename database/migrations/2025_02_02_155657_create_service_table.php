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
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained('artist_profile')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('category')->cascadeOnDelete();
            $table->decimal('price_rate', 10, 2);
            $table->decimal('rush_price_rate', 10, 2);
            $table->string('normal_timeframe', 255);
            $table->string('rush_timeframe', 255);
            $table->string('status', 50)->default('open');
            $table->timestamps();
        });

        Schema::create('service_image', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('service')->cascadeOnDelete();
            $table->foreignId('attachment_id')->constrained('attachment')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('service_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('service')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tag')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service');
        Schema::dropIfExists('service_image');
        Schema::dropIfExists('service_tag');
    }
};
