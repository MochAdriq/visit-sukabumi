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
        Schema::table('events', function (Blueprint $table) {
            $table->text('whats_included')->nullable();
            $table->text('what_to_expect')->nullable();
            $table->text('meeting_and_pickup')->nullable();
            $table->text('cancellation_policy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'whats_included',
                'what_to_expect',
                'meeting_and_pickup',
                'cancellation_policy',
            ]);
        });
    }
};
