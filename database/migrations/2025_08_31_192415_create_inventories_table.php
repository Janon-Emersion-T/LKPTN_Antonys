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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('quantity_on_hand')->default(0);
            $table->integer('quantity_available')->default(0);
            $table->integer('quantity_reserved')->default(0);
            $table->integer('quantity_incoming')->default(0);
            $table->integer('reorder_level')->default(0);
            $table->integer('reorder_quantity')->default(0);
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->decimal('average_cost', 10, 2)->nullable();
            $table->string('location')->nullable();
            $table->string('bin_location')->nullable();
            $table->string('status')->default('active'); // active, inactive, discontinued
            $table->json('attributes')->nullable(); // For additional inventory metadata
            $table->text('notes')->nullable();
            $table->timestamp('last_counted_at')->nullable();
            $table->foreignId('last_counted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Indexes for performance
            $table->unique(['product_id']);
            $table->index(['status']);
            $table->index(['quantity_on_hand']);
            $table->index(['reorder_level']);
            $table->index(['supplier_id']);
            $table->index(['location']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
