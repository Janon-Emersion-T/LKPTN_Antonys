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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            
            // Product details at time of order (for historical accuracy)
            $table->string('product_name');
            $table->string('product_sku');
            $table->text('product_description')->nullable();
            $table->string('product_image')->nullable();
            
            // Pricing at time of order
            $table->decimal('unit_price', 10, 2);
            $table->decimal('compare_price', 10, 2)->nullable(); // Original price if discounted
            $table->decimal('cost_price', 10, 2)->nullable(); // For profit calculations
            
            // Quantity and totals
            $table->integer('quantity');
            $table->decimal('line_total', 12, 2); // unit_price * quantity
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('final_total', 12, 2); // line_total - discount_amount + tax_amount
            
            // Product variations (size, color, etc.)
            $table->json('product_options')->nullable(); // {"size": "Large", "color": "Red"}
            
            // Fulfillment tracking
            $table->string('fulfillment_status')->default('unfulfilled'); // unfulfilled, partial, fulfilled, returned
            $table->integer('quantity_shipped')->default(0);
            $table->integer('quantity_returned')->default(0);
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('returned_at')->nullable();
            
            // Return/refund information
            $table->string('return_reason')->nullable();
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->timestamp('refunded_at')->nullable();
            
            // Metadata
            $table->json('attributes')->nullable(); // Additional item metadata
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['order_id']);
            $table->index(['product_id']);
            $table->index(['fulfillment_status']);
            $table->index(['product_sku']);
            $table->index(['shipped_at']);
            $table->index(['returned_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
