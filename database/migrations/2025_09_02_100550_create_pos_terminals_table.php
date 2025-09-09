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
        Schema::create('pos_terminals', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Terminal name (e.g., "Main Counter", "Store Front")
            $table->string('identifier')->unique(); // Unique terminal identifier (e.g., "TERM001")
            $table->string('location')->nullable(); // Physical location description
            $table->string('ip_address')->nullable(); // Terminal IP address
            $table->string('mac_address')->nullable(); // Terminal MAC address
            $table->boolean('is_active')->default(true);
            $table->json('settings')->nullable(); // Terminal-specific settings
            $table->decimal('cash_drawer_limit', 10, 2)->default(5000.00); // Maximum cash allowed
            $table->boolean('accepts_cash')->default(true);
            $table->boolean('accepts_cards')->default(true);
            $table->boolean('accepts_mobile_payments')->default(false);
            $table->string('receipt_printer_type')->default('thermal'); // thermal, inkjet, etc.
            $table->string('receipt_footer_text')->nullable(); // Custom footer for receipts
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
            
            $table->index(['is_active', 'location']);
            $table->index('assigned_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_terminals');
    }
};
