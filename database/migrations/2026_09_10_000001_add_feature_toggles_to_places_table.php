<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('places', function (Blueprint $table) {

            // ── MASTER TOGGLES ─────────────────────────────────────
            $table->boolean('has_ticket')->default(false)->after('nearby_places');
            $table->boolean('has_accommodation')->default(false)->after('has_ticket');
            $table->boolean('has_restaurant')->default(false)->after('has_accommodation');
            $table->boolean('has_tour_package')->default(false)->after('has_restaurant');
            $table->boolean('has_accessibility_warning')->default(false)->after('has_tour_package');

            // ── TIKET ──────────────────────────────────────────────
            $table->decimal('ticket_price', 12, 2)->nullable()->after('has_accessibility_warning');
            $table->string('ticket_booking_url')->nullable()->after('ticket_price');
            $table->text('ticket_terms')->nullable()->after('ticket_booking_url');

            // ── PENGINAPAN ─────────────────────────────────────────
            $table->tinyInteger('hotel_star')->nullable()->after('ticket_terms');
            $table->json('hotel_facilities')->nullable()->after('hotel_star');
            $table->string('hotel_booking_url')->nullable()->after('hotel_facilities');

            // ── RESTORAN ───────────────────────────────────────────
            $table->boolean('restaurant_is_halal')->default(false)->nullable()->after('hotel_booking_url');
            $table->string('restaurant_menu_url')->nullable()->after('restaurant_is_halal');
            $table->string('restaurant_reservation_url')->nullable()->after('restaurant_menu_url');

            // ── PAKET TUR ──────────────────────────────────────────
            $table->json('tour_packages')->nullable()->after('restaurant_reservation_url');
            $table->string('tour_meeting_point')->nullable()->after('tour_packages');
            $table->string('tour_guide_contact')->nullable()->after('tour_meeting_point');

            // ── AKSESIBILITAS ──────────────────────────────────────
            $table->text('accessibility_note')->nullable()->after('tour_guide_contact');
            $table->string('accessibility_type', 50)->nullable()->after('accessibility_note');
        });
    }

    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn([
                'has_ticket', 'has_accommodation', 'has_restaurant',
                'has_tour_package', 'has_accessibility_warning',
                'ticket_price', 'ticket_booking_url', 'ticket_terms',
                'hotel_star', 'hotel_facilities', 'hotel_booking_url',
                'restaurant_is_halal', 'restaurant_menu_url', 'restaurant_reservation_url',
                'tour_packages', 'tour_meeting_point', 'tour_guide_contact',
                'accessibility_note', 'accessibility_type',
            ]);
        });
    }
};
