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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // For registered users
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete(); // For customer profiles
            
            // Order Type
            $table->string('type')->default('online'); // online, pos, wholesale, phone
            $table->string('channel')->default('web'); // web, mobile_app, pos_terminal, phone
            
            // Order Status
            $table->string('status')->default('pending'); // pending, confirmed, processing, shipped, delivered, cancelled, refunded
            $table->string('payment_status')->default('pending'); // pending, paid, partially_paid, refunded, failed
            $table->string('fulfillment_status')->default('unfulfilled'); // unfulfilled, partial, fulfilled
            
            // Customer Information (for guest orders)
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_name')->nullable();
            
            // Pricing
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('shipping_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            
            // Shipping Information
            $table->json('shipping_address')->nullable();
            $table->json('billing_address')->nullable();
            $table->string('shipping_method')->nullable();
            $table->decimal('shipping_cost', 10, 2)->nullable();
            $table->string('tracking_number')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            
            // Coupon/Discount Information
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();
            $table->string('coupon_code')->nullable();
            $table->decimal('coupon_discount', 10, 2)->default(0);
            
            // POS Specific Fields
            $table->foreignId('cashier_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('terminal_id')->nullable();
            $table->string('receipt_number')->nullable();
            
            // Metadata and Notes
            $table->json('attributes')->nullable(); // Additional order metadata
            $table->text('notes')->nullable(); // Customer notes
            $table->text('admin_notes')->nullable(); // Internal notes
            $table->json('tags')->nullable(); // Order tags
            
            // Timestamps
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['status']);
            $table->index(['payment_status']);
            $table->index(['fulfillment_status']);
            $table->index(['type']);
            $table->index(['user_id', 'status']);
            $table->index(['customer_id', 'status']);
            $table->index(['customer_email']);
            $table->index(['order_number']);
            $table->index(['tracking_number']);
            $table->index(['coupon_code']);
            $table->index(['created_at']);
            $table->index(['confirmed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
