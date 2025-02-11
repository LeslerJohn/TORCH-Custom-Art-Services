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
            $table->id();
            $table->foreignId('artist_id')->constrained('artist_profile')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('category')->cascadeOnDelete();
            $table->string('title', 255);
            $table->text('description');
            $table->string('medium', 50);
            $table->string('dimension', 50);
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(1);
            $table->boolean('is_showcase')->default(false);
            $table->string('status', 50)->default('sale'); // 'sale', 'sold', 'draft'
            $table->timestamps();
        });

        Schema::create('artwork_image', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artwork_id')->constrained('artwork')->cascadeOnDelete();
            $table->foreignId('attachment_id')->constrained('attachment')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('artwork_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artwork_id')->constrained('artwork')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tag')->cascadeOnDelete();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artwork');
    }
};
