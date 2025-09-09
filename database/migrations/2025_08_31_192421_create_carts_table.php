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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete(); // For registered users
            $table->string('session_id')->nullable(); // For guest users
            $table->string('status')->default('active'); // active, abandoned, converted, expired
            
            // Cart totals
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('shipping_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            
            // Coupon information
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();
            $table->string('coupon_code')->nullable();
            $table->decimal('coupon_discount', 10, 2)->default(0);
            
            // Shipping information
            $table->json('shipping_address')->nullable();
            $table->string('shipping_method')->nullable();
            $table->decimal('shipping_cost', 10, 2)->nullable();
            
            // Cart type and source
            $table->string('type')->default('web'); // web, mobile, pos
            $table->string('source')->nullable(); // utm_source, referrer, etc.
            
            // Metadata
            $table->json('attributes')->nullable(); // Additional cart metadata
            $table->text('notes')->nullable();
            
            // Timestamps for cart management
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('abandoned_at')->nullable(); // When cart was marked as abandoned
            $table->timestamp('converted_at')->nullable(); // When cart was converted to order
            $table->timestamp('expires_at')->nullable(); // When cart expires
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id', 'status']);
            $table->index(['session_id', 'status']);
            $table->index(['status']);
            $table->index(['coupon_code']);
            $table->index(['last_activity_at']);
            $table->index(['abandoned_at']);
            $table->index(['expires_at']);
            $table->index(['type']);
            
            // Unique constraint to ensure one active cart per user
            $table->unique(['user_id', 'status', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
