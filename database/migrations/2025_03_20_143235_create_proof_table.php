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
        Schema::create('proof_of_delivery', function (Blueprint $table) {
            $table->foreignUlid('delivery_id')->constrained('delivery')->cascadeOnDelete();
            $table->foreignUlid('attachment_id')->constrained('attachment')->cascadeOnDelete();
            $table->primary(['delivery_id', 'attachment_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proof');
    }
};
