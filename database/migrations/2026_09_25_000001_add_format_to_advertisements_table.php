<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->string('format', 20)->default('landscape')->after('position');
        });

        // Set data eksisting: place_sidebar otomatis berformat portrait
        DB::table('advertisements')
            ->where('position', 'place_sidebar')
            ->update(['format' => 'portrait']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn('format');
        });
    }
};
