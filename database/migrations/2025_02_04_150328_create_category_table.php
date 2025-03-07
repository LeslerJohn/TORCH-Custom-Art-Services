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
        Schema::create('category', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name', 50);
            $table->timestamps();
        });

        Schema::create('category_tag', function (Blueprint $table) {
            $table->foreignUlid('category_id')->constrained('category')->cascadeOnDelete();
            $table->foreignUlid('tag_id')->constrained('tag')->cascadeOnDelete();
            $table->primary(['category_id', 'tag_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_tag');
        Schema::dropIfExists('category');
    }
};
