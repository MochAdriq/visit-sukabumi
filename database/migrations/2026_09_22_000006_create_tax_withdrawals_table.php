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
        Schema::create('tax_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->string('withdrawal_code', 64)->unique(); // e.g. "TAX-WD-202609-0001"
            $table->foreignId('rkud_account_id')->constrained()->cascadeOnDelete();
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('total_amount', 14, 2);
            $table->string('status', 30)->default('pending'); // pending, approved, transferred, rejected
            $table->string('transfer_proof_path')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('transferred_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_withdrawals');
    }
};
