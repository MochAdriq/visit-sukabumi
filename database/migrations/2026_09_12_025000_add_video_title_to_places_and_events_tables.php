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
        Schema::table('places', function (Blueprint $table) {
            $table->string('video_title')->nullable()->after('youtube_url');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('video_title')->nullable()->after('youtube_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn('video_title');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('video_title');
        });
    }
};
