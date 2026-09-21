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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 64)->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            
            // Customer Contact
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone', 30);

            // Polymorphic Target (HotelRoom or EventTicket)
            $table->string('booking_type', 30); // hotel, event
            $table->morphs('bookable');
            $table->string('source_title'); // Snapshot of Event title or Hotel name

            // Booking Schedule / Units
            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();
            $table->integer('quantity')->default(1); // ticket count or room count * nights

            // Financial Breakdown (Precision 12,2)
            $table->decimal('base_price', 12, 2); // Unit base price
            $table->decimal('subtotal_amount', 12, 2); // Net price for vendor
            $table->decimal('tax_rate_percent', 5, 2)->default(10.00); // Snapshot of PBJT tax rate
            $table->decimal('tax_amount', 12, 2)->default(0); // PBJT Tax for Government
            $table->decimal('platform_fee', 12, 2)->default(0); // Admin / PG Fee
            $table->decimal('total_amount', 12, 2); // Total billed to customer

            // Status & Payment
            $table->string('payment_status', 30)->default('pending'); // pending, paid, cancelled, refunded, expired
            $table->string('payment_method', 50)->nullable();
            $table->string('payment_reference')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
