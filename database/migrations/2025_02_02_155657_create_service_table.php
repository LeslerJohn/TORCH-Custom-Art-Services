<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('artist_id')->references('id')->on('artist_profile')->cascadeOnDelete();
            $table->foreignUlid('category_id')->references('id')->on('category')->cascadeOnDelete();
            $table->decimal('price_rate', 10, 2);
            $table->decimal('rush_price_rate', 10, 2);
            $table->string('normal_timeframe', 255);
            $table->string('rush_timeframe', 255);
            $table->string('status', 50)->default('open');
            $table->timestamps();
        });

        Schema::create('service_image', function (Blueprint $table) {
            $table->foreignUlid('service_id')->references('id')->on('service')->cascadeOnDelete();
            $table->foreignUlid('attachment_id')->references('id')->on('attachment')->cascadeOnDelete();
            $table->primary(['service_id', 'attachment_id']);
            $table->timestamps();
        });

        Schema::create('service_tag', function (Blueprint $table) {
            $table->foreignUlid('service_id')->references('id')->on('service')->cascadeOnDelete();
            $table->foreignUlid('tag_id')->references('id')->on('tag')->cascadeOnDelete();
            $table->primary(['service_id', 'tag_id']);
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
