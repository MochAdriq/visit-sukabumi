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
        Schema::create('tax_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tax_setting_id')->nullable()->constrained()->nullOnDelete();
            $table->string('sector', 30); // hotel, event
            $table->string('vendor_name'); // Nama Hotel atau Nama EO
            $table->decimal('tax_amount', 12, 2);
            $table->string('status', 30)->default('held_in_escrow'); // held_in_escrow, ready_for_withdrawal, withdrawn, refunded
            $table->foreignId('tax_withdrawal_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('withdrawn_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_ledgers');
    }
};
