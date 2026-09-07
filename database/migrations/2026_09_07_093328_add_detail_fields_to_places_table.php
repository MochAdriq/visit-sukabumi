<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->unsignedInteger('price')->nullable()->after('status');       // Harga tiket (Rp)
            $table->string('phone', 20)->nullable()->after('price');             // No. WhatsApp
            $table->string('website')->nullable()->after('phone');               // Website resmi
            $table->string('open_hours', 100)->nullable()->after('website');     // Jam operasional
            $table->string('duration', 50)->nullable()->after('open_hours');     // Durasi kunjungan
            $table->string('ticket_info', 255)->nullable()->after('duration');   // Info tiket tambahan
        });
    }

    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn(['price', 'phone', 'website', 'open_hours', 'duration', 'ticket_info']);
        });
    }
};
