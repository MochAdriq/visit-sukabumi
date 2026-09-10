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
        Schema::table('place_images', function (Blueprint $table) {
            $table->string('copyright_name')->nullable();
            $table->string('copyright_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('place_images', function (Blueprint $table) {
            $table->dropColumn(['copyright_name', 'copyright_link']);
        });
    }
};
