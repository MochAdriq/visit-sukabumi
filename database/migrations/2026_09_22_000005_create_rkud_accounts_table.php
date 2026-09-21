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
        Schema::create('rkud_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name', 100); // e.g. "Bank BJB", "Bank Mandiri"
            $table->string('account_number', 50);
            $table->string('account_holder_name', 150); // e.g. "KAS DAERAH KABUPATEN SUKABUMI"
            $table->string('agency_name', 150)->default('Badan Pendapatan Daerah');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rkud_accounts');
    }
};
