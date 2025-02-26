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
        Schema::create('tag', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('artist_tag', function (Blueprint $table) {
            $table->foreignUlid('artist_id')->constrained('artist_profile')->onDelete('cascade');
            $table->foreignUlid('tag_id')->constrained('tag')->onDelete('cascade');
            $table->primary(['artist_id', 'tag_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag');
        Schema::dropIfExists('artist_tag');
    }
};
