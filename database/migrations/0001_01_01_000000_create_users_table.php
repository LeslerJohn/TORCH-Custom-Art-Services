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
        Schema::create('users', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->enum('role', ['client', 'artist', 'admin'])->default('client');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->foreignUlid('profile_image_id')->nullable()->constrained('attachment');
            $table->foreignUlid('cover_image_id')->nullable()->constrained('attachment');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('client_profile', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->float('rating')->nullable();
            $table->boolean('is_suspended')->default(false);
            $table->timestamps();

            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('artist_profile', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->softDeletes();
            $table->string('location');
            $table->string('gender');
            $table->string('username');
            $table->date('birthdate');
            $table->string('bio');
            $table->enum('status', ['pending', 'semi-verified', 'fully-verified', 'unverified'])->default('pending');
            $table->boolean('is_suspended')->default(false);
            $table->float('rating')->default(0);
            $table->boolean('available')->default(true);
            $table->timestamps();

            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignUlid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('client_profile');
        Schema::dropIfExists('artist_profile');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
