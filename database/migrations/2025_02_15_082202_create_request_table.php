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
        Schema::create('request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('client_profile')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('service')->cascadeOnDelete();
            $table->string('description', 255);
            $table->string('height', 50);
            $table->string('width', 50);
            $table->string('unit', 50);
            $table->date('deadline')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->string('status', 50)->default('pending');
            $table->timestamps();
        });

        Schema::create('request_image', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('request')->cascadeOnDelete();
            $table->foreignId('attachment_id')->constrained('attachment')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request');
        Schema::dropIfExists('request_image');
    }
};
