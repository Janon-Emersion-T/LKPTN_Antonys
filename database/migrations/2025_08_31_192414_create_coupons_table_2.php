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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Display name for admin
            $table->string('code')->unique(); // The actual coupon code customers enter
            $table->text('description')->nullable();
            
            // Discount type and amount
            $table->string('type')->default('fixed'); // fixed, percentage, buy_x_get_y, free_shipping
            $table->decimal('value', 10, 2)->default(0); // Amount or percentage
            $table->decimal('minimum_amount', 10, 2)->nullable(); // Minimum order amount required
            $table->decimal('maximum_discount', 10, 2)->nullable(); // Maximum discount for percentage coupons
            
            // Usage limits
            $table->integer('usage_limit')->nullable(); // Total usage limit
            $table->integer('usage_limit_per_customer')->nullable(); // Per customer usage limit
            $table->integer('used_count')->default(0); // How many times it's been used
            
            // Validity period
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            
            // Applicability
            $table->json('applicable_products')->nullable(); // Product IDs this applies to
            $table->json('excluded_products')->nullable(); // Product IDs this excludes
            $table->json('applicable_categories')->nullable(); // Category IDs this applies to
            $table->json('excluded_categories')->nullable(); // Category IDs this excludes
            $table->json('applicable_brands')->nullable(); // Brand IDs this applies to
            $table->json('excluded_brands')->nullable(); // Brand IDs this excludes
            
            // Customer eligibility
            $table->json('applicable_customers')->nullable(); // Customer IDs this applies to
            $table->json('excluded_customers')->nullable(); // Customer IDs this excludes
            $table->json('customer_groups')->nullable(); // Customer groups this applies to
            $table->boolean('first_order_only')->default(false); // Only for first-time customers
            
            // Advanced conditions
            $table->integer('minimum_quantity')->nullable(); // Minimum items required
            $table->json('conditions')->nullable(); // Complex conditions as JSON
            
            // Status and metadata
            $table->string('status')->default('active'); // active, inactive, expired, disabled
            $table->boolean('is_public')->default(true); // Public or private/targeted coupon
            $table->string('source')->nullable(); // marketing_campaign, loyalty_program, etc.
            $table->json('tags')->nullable(); // Tags for organization
            $table->json('attributes')->nullable(); // Additional metadata
            
            // Tracking
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable(); // Admin notes
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['code']);
            $table->index(['status']);
            $table->index(['type']);
            $table->index(['starts_at', 'expires_at']);
            $table->index(['is_public']);
            $table->index(['first_order_only']);
            $table->index(['created_by']);
            $table->index(['source']);
            $table->index(['used_count']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
