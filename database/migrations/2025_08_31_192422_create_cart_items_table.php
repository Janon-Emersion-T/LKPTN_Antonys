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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            
            // Product details (for quick access without joins)
            $table->string('product_name');
            $table->string('product_sku');
            $table->string('product_image')->nullable();
            
            // Pricing information
            $table->decimal('unit_price', 10, 2);
            $table->decimal('compare_price', 10, 2)->nullable(); // Original price if on sale
            $table->decimal('discount_amount', 10, 2)->default(0);
            
            // Quantity and totals
            $table->integer('quantity');
            $table->decimal('line_total', 12, 2); // unit_price * quantity
            $table->decimal('final_total', 12, 2); // line_total - discount_amount
            
            // Product variations and options
            $table->json('product_options')->nullable(); // {"size": "Large", "color": "Red"}
            $table->string('variant_id')->nullable(); // If using product variants
            
            // Cart item metadata
            $table->json('attributes')->nullable(); // Additional item metadata
            $table->text('notes')->nullable(); // Customer notes for this item
            
            // Item status
            $table->string('status')->default('active'); // active, saved_for_later, removed
            
            // Timestamps for tracking
            $table->timestamp('added_at')->nullable();
            $table->timestamp('last_updated_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['cart_id']);
            $table->index(['product_id']);
            $table->index(['status']);
            $table->index(['product_sku']);
            $table->index(['variant_id']);
            $table->index(['added_at']);
            
            // Unique constraint to prevent duplicate items in cart
            $table->unique(['cart_id', 'product_id', 'variant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
