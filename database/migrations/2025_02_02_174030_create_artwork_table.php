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
        Schema::create('artwork', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('artist_id')->constrained('artist_profile')->cascadeOnDelete();
            $table->foreignUlid('category_id')->constrained('category')->cascadeOnDelete();
            $table->string('title', 255);
            $table->text('description');
            $table->integer('width');
            $table->integer('height');
            $table->string('unit', 255);
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(1);
            $table->boolean('is_showcase')->default(false);
            $table->string('status', 50)->default('sale'); // 'sale', 'sold', 'draft'
            $table->timestamps();
        });

        Schema::create('artwork_image', function (Blueprint $table) {
            $table->foreignUlid('artwork_id')->constrained('artwork')->cascadeOnDelete();
            $table->foreignUlid('attachment_id')->constrained('attachment')->cascadeOnDelete();
            $table->primary(['artwork_id', 'attachment_id']);
            $table->timestamps();
        });

        Schema::create('artwork_tag', function (Blueprint $table) {
            $table->foreignUlid('artwork_id')->constrained('artwork')->cascadeOnDelete();
            $table->foreignUlid('tag_id')->constrained('tag')->cascadeOnDelete();
            $table->primary(['artwork_id', 'tag_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artwork_tag');
        Schema::dropIfExists('artwork_image');
        Schema::dropIfExists('artwork');
    }
};
