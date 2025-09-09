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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code')->unique()->nullable(); // Internal supplier code
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            
            // Contact Person
            $table->string('contact_person')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            
            // Address Information
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            
            // Business Information
            $table->string('tax_number')->nullable();
            $table->string('business_license')->nullable();
            $table->decimal('credit_limit', 15, 2)->nullable();
            $table->integer('payment_terms')->default(30); // Payment terms in days
            $table->string('payment_method')->default('bank_transfer'); // bank_transfer, cash, check, credit_card
            
            // Banking Information
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_routing')->nullable();
            
            // Status and Metadata
            $table->string('status')->default('active'); // active, inactive, suspended
            $table->decimal('rating', 2, 1)->nullable(); // Rating out of 5
            $table->json('tags')->nullable(); // Categories or tags for suppliers
            $table->json('attributes')->nullable(); // Additional supplier metadata
            $table->text('notes')->nullable();
            
            // Timestamps
            $table->timestamp('last_order_date')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['status']);
            $table->index(['name']);
            $table->index(['code']);
            $table->index(['email']);
            $table->index(['country']);
            $table->index(['rating']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
