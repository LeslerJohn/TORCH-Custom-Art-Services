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
        Schema::create('payments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('client_id')->constrained('client_profile')->cascadeOnDelete();
            $table->foreignUlid('commission_id')->nullable()->constrained('commission')->cascadeOnDelete();
            $table->foreignUlid('order_id')->nullable()->constrained('order')->cascadeOnDelete();
            $table->foreignUlid('request_id')->nullable()->constrained('request')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['GCash', 'PayMaya', 'Bank Transfer', 'Credit Card'])->default('GCash');
            $table->string('transaction_id', 255);
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->timestamps();
        });

        Schema::create('refunds', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->foreignUlid('commission_id')->nullable()->constrained('commission')->cascadeOnDelete();
            $table->foreignUlid('order_id')->nullable()->constrained('order')->cascadeOnDelete();
            $table->foreignUlid('request_id')->nullable()->constrained('request')->cascadeOnDelete();
            $table->foreignUlid('client_id')->constrained('client_profile')->cascadeOnDelete();
            $table->foreignUlid('artist_id')->constrained('artist_profile')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->text('reason');
            $table->foreignUlid('attachment_id')->nullable()->constrained('attachment')->cascadeOnDelete();
            $table->enum('refund_method', ['GCash', 'PayMaya', 'Bank Transfer', 'Credit Card'])->default('GCash');
            $table->enum('status', ['pending', 'approved', 'rejected', 'processed'])->default('pending');
            $table->string('transaction_id')->nullable();
            $table->boolean('admin_approved')->nullable();
            $table->timestamps();
        });

        Schema::create('artist_payment', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('artist_id')->constrained('artist_profile')->cascadeOnDelete();
            $table->enum('payment_method', ['GCash', 'PayMaya', 'Bank Transfer', 'Credit Card'])->default('GCash');
            $table->string('account_number', 50);
            $table->string('account_name', 50);
            $table->timestamps();
        });

        Schema::create('payouts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('artist_id')->constrained('artist_profile')->cascadeOnDelete();
            $table->foreignUlid('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->integer('service_fee');
            $table->decimal('net_amount', 10, 2);
            $table->decimal('company_cut', 10, 2);
            $table->enum('payout_type', ['commission', 'order', 'refund']);
            $table->enum('payout_method', ['GCash', 'PayMaya' ,'Bank Transfer'])->default('GCash');
            $table->enum('status', ['pending', 'ready', 'completed', 'failed'])->default('pending');
            $table->string('transaction_id', 255)->nullable();
            $table->timestamps();
        });

        // Schema::table('order_payment_cut', function (Blueprint $table) {
        //     $table->ulid('id')->primary();
        //     $table->foreignUlid('order_id')->constrained('order')->cascadeOnDelete();
        //     $table->foreignUlid('payment_id')->constrained('payments')->cascadeOnDelete();
        //     $table->decimal('amount', 10, 2);
        //     $table->timestamps();
        // });

        // Schema::table('commission_payment_cut', function (Blueprint $table) {
        //     $table->ulid('id')->primary();
        //     $table->foreignUlid('commission_id')->constrained('commission')->cascadeOnDelete();
        //     $table->foreignUlid('payment_id')->constrained('payments')->cascadeOnDelete();
        //     $table->decimal('amount', 10, 2);
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('refunds');
        Schema::dropIfExists('artist_payment');
        Schema::dropIfExists('payouts');
    }
};
