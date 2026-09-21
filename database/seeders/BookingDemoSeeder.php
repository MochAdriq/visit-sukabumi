<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventTicket;
use App\Models\HotelRoom;
use App\Models\Place;
use Illuminate\Database\Seeder;

class BookingDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Tiket Event
        $events = Event::where('is_active', true)->take(2)->get();
        if ($events->isEmpty()) {
            $events = Event::take(2)->get();
        }

        foreach ($events as $event) {
            EventTicket::firstOrCreate(
                [
                    'event_id' => $event->id,
                    'name' => 'Tiket Masuk Reguler',
                ],
                [
                    'description' => 'Akses seluruh pameran kebudayaan, pertunjukan musik rakyat, dan bazar kuliner.',
                    'price' => 50000,
                    'quota' => 500,
                    'available_quota' => 485,
                    'is_active' => true,
                ]
            );

            EventTicket::firstOrCreate(
                [
                    'event_id' => $event->id,
                    'name' => 'Tiket VIP Front Row & Souvenir',
                ],
                [
                    'description' => 'Akses baris terdepan panggung utama, welcome drink, t-shirt eksklusif, dan parkir VIP.',
                    'price' => 150000,
                    'quota' => 100,
                    'available_quota' => 92,
                    'is_active' => true,
                ]
            );

            EventTicket::firstOrCreate(
                [
                    'event_id' => $event->id,
                    'name' => 'Early Bird Pass (Terbatas)',
                ],
                [
                    'description' => 'Tiket promo hemat untuk pendaftar awal acara pariwisata Sukabumi.',
                    'price' => 35000,
                    'quota' => 50,
                    'available_quota' => 12,
                    'is_active' => true,
                ]
            );
        }

        // 2. Seed Kamar Hotel
        $places = Place::where('has_accommodation', true)->take(2)->get();
        if ($places->isEmpty()) {
            $places = Place::take(2)->get();
        }

        foreach ($places as $place) {
            HotelRoom::firstOrCreate(
                [
                    'place_id' => $place->id,
                    'name' => 'Deluxe Room (Twin/King Bed)',
                ],
                [
                    'description' => 'Kamar modern ber-AC dengan pemandangan kota/alam Sukabumi, smart TV, dan sarapan 2 pax.',
                    'price_per_night' => 650000,
                    'total_rooms' => 10,
                    'max_guests' => 2,
                    'facilities' => ['AC', 'WiFi Kencang', 'Smart TV', 'Sarapan Gratis', 'Water Heater'],
                    'is_active' => true,
                ]
            );

            HotelRoom::firstOrCreate(
                [
                    'place_id' => $place->id,
                    'name' => 'Executive Suite Room',
                ],
                [
                    'description' => 'Kamar luas dengan ruang tamu terpisah, bathtub pribadi, minibar, dan akses lounge eksekutif.',
                    'price_per_night' => 1250000,
                    'total_rooms' => 4,
                    'max_guests' => 3,
                    'facilities' => ['AC', 'WiFi Kencang', 'Bathtub', 'Ruang Tamu', 'Minibar', 'Sarapan Gratis'],
                    'is_active' => true,
                ]
            );
        }
    }
}
