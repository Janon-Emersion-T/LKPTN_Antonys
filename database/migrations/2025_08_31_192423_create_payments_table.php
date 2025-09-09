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
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete(); // Associated order
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // User who made payment
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete(); // Customer profile
            
            // Payment identification
            $table->string('payment_id')->unique(); // Internal payment ID
            $table->string('transaction_id')->nullable(); // Gateway transaction ID
            $table->string('reference_number')->nullable(); // External reference
            
            // Payment details
            $table->decimal('amount', 12, 2); // Payment amount
            $table->string('currency', 3)->default('USD');
            $table->string('status')->default('pending'); // pending, processing, completed, failed, cancelled, refunded, partially_refunded
            $table->string('type')->default('payment'); // payment, refund, partial_refund, chargeback
            
            // Payment method information
            $table->string('method')->nullable(); // credit_card, debit_card, paypal, stripe, cash, bank_transfer, etc.
            $table->string('gateway')->nullable(); // stripe, paypal, square, authorize_net, manual, etc.
            $table->string('gateway_payment_id')->nullable(); // Gateway's internal payment ID
            
            // Card/Payment method details (encrypted/tokenized)
            $table->string('payment_method_token')->nullable(); // Tokenized payment method
            $table->string('last_four')->nullable(); // Last 4 digits of card
            $table->string('card_brand')->nullable(); // visa, mastercard, amex, etc.
            $table->string('card_type')->nullable(); // credit, debit
            $table->string('expiry_month')->nullable();
            $table->string('expiry_year')->nullable();
            
            // Processing information
            $table->decimal('processing_fee', 10, 4)->nullable(); // Gateway processing fee
            $table->decimal('net_amount', 12, 2)->nullable(); // Amount after fees
            $table->string('processor_response')->nullable(); // Gateway response code
            $table->text('processor_message')->nullable(); // Gateway response message
            
            // Authorization and capture (for credit cards)
            $table->string('authorization_code')->nullable();
            $table->decimal('authorized_amount', 12, 2)->nullable();
            $table->decimal('captured_amount', 12, 2)->default(0);
            $table->timestamp('authorized_at')->nullable();
            $table->timestamp('captured_at')->nullable();
            
            // Refund information
            $table->decimal('refunded_amount', 12, 2)->default(0);
            $table->string('refund_reason')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->foreignId('refunded_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Failure information
            $table->string('failure_code')->nullable();
            $table->text('failure_message')->nullable();
            $table->timestamp('failed_at')->nullable();
            
            // Billing information
            $table->json('billing_address')->nullable();
            
            // POS specific fields
            $table->string('terminal_id')->nullable(); // POS terminal ID
            $table->string('receipt_number')->nullable(); // Physical receipt number
            $table->foreignId('cashier_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Metadata and tracking
            $table->json('gateway_response')->nullable(); // Full gateway response data
            $table->json('attributes')->nullable(); // Additional payment metadata
            $table->string('ip_address')->nullable(); // Customer's IP address
            $table->text('user_agent')->nullable(); // Customer's user agent
            $table->text('notes')->nullable(); // Admin notes
            
            // Risk and fraud
            $table->string('risk_level')->nullable(); // low, medium, high
            $table->decimal('risk_score', 5, 2)->nullable(); // Risk assessment score
            $table->json('fraud_details')->nullable(); // Fraud detection results
            
            // Timestamps
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['order_id']);
            $table->index(['user_id']);
            $table->index(['customer_id']);
            $table->index(['status']);
            $table->index(['type']);
            $table->index(['method']);
            $table->index(['gateway']);
            $table->index(['payment_id']);
            $table->index(['transaction_id']);
            $table->index(['gateway_payment_id']);
            $table->index(['reference_number']);
            $table->index(['processed_at']);
            $table->index(['created_at']);
            $table->index(['terminal_id']);
            $table->index(['risk_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
