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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Link to users table if registered
            $table->string('customer_number')->unique(); // Unique customer identifier
            
            // Basic information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable(); // male, female, other, prefer_not_to_say
            
            // Company information (for B2B customers)
            $table->string('company_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('tax_number')->nullable(); // VAT/Tax ID for business customers
            
            // Address information
            $table->json('addresses')->nullable(); // Multiple addresses (billing, shipping, etc.)
            $table->json('default_billing_address')->nullable();
            $table->json('default_shipping_address')->nullable();
            
            // Customer status and type
            $table->string('status')->default('active'); // active, inactive, suspended, pending_verification
            $table->string('type')->default('retail'); // retail, wholesale, vip, corporate
            $table->string('group')->nullable(); // Customer group for pricing/discounts
            
            // Marketing preferences
            $table->boolean('accepts_marketing')->default(false);
            $table->boolean('accepts_sms')->default(false);
            $table->json('marketing_preferences')->nullable(); // Email categories, frequency, etc.
            $table->string('preferred_language')->default('en');
            
            // Customer metrics
            $table->integer('total_orders')->default(0);
            $table->decimal('total_spent', 15, 2)->default(0);
            $table->decimal('average_order_value', 10, 2)->default(0);
            $table->timestamp('last_order_date')->nullable();
            $table->timestamp('first_order_date')->nullable();
            
            // Loyalty and rewards
            $table->integer('loyalty_points')->default(0);
            $table->string('loyalty_tier')->nullable(); // bronze, silver, gold, platinum
            $table->decimal('store_credit', 10, 2)->default(0);
            
            // Customer service
            $table->text('notes')->nullable(); // Internal customer notes
            $table->json('tags')->nullable(); // Customer tags for segmentation
            $table->decimal('credit_limit', 15, 2)->nullable(); // For wholesale/corporate customers
            $table->integer('payment_terms')->default(0); // Payment terms in days
            
            // Source and acquisition
            $table->string('source')->nullable(); // How customer was acquired (website, store, referral, etc.)
            $table->string('referrer')->nullable(); // Who referred them
            $table->json('utm_parameters')->nullable(); // Marketing attribution
            
            // Account verification
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('verification_token')->nullable();
            
            // Privacy and consent
            $table->timestamp('terms_accepted_at')->nullable();
            $table->timestamp('privacy_accepted_at')->nullable();
            $table->json('consents')->nullable(); // GDPR and other consents
            
            // Metadata
            $table->json('attributes')->nullable(); // Additional customer data
            $table->json('preferences')->nullable(); // Shopping preferences, sizes, etc.
            
            // Important dates
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id']);
            $table->index(['email']);
            $table->index(['phone']);
            $table->index(['customer_number']);
            $table->index(['status']);
            $table->index(['type']);
            $table->index(['group']);
            $table->index(['company_name']);
            $table->index(['loyalty_tier']);
            $table->index(['total_orders']);
            $table->index(['total_spent']);
            $table->index(['last_order_date']);
            $table->index(['first_order_date']);
            $table->index(['source']);
            $table->index(['created_at']);
            $table->index(['last_activity_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
