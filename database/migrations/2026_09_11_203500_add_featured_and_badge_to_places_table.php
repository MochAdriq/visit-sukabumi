<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('status');
            $table->string('badge_label', 50)->nullable()->after('is_featured');
        });
    }

    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'badge_label']);
        });
    }
};
