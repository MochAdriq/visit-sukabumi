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
        Schema::create('event_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // e.g. "Early Bird", "VIP", "Reguler"
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->integer('quota')->nullable(); // null = unlimited
            $table->integer('available_quota')->nullable();
            $table->dateTime('sale_start_at')->nullable();
            $table->dateTime('sale_end_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_tickets');
    }
};
