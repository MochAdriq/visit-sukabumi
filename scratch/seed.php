<?php

$event = App\Models\Event::first();
if ($event) {
    App\Models\EventItinerary::where('event_id', $event->id)->delete();
    
    $event->itineraries()->create([
        'title' => 'Alun-Alun Kota Sukabumi',
        'description' => 'Titik kumpul keberangkatan. Harap datang 30 menit sebelum jadwal.',
        'duration_text' => 'See departure details',
        'latitude' => -6.918991,
        'longitude' => 106.928174,
        'order_num' => 1
    ]);
    
    $event->itineraries()->create([
        'title' => 'Jembatan Gantung Situ Gunung',
        'description' => 'Suspension bridge terpanjang di Asia Tenggara. Nikmati sensasi berjalan di atas kanopi hutan.',
        'duration_text' => 'Stop: 2 hours - Admission included',
        'latitude' => -6.833621,
        'longitude' => 106.924295,
        'order_num' => 2
    ]);
    
    $event->itineraries()->create([
        'title' => 'Curug Sawer',
        'description' => 'Air terjun indah di kawasan Situ Gunung. Perjalanan kembali ke titik kumpul dimulai dari sini.',
        'duration_text' => 'Stop: 60 minutes - Admission included',
        'latitude' => -6.828551,
        'longitude' => 106.927429,
        'order_num' => 3
    ]);
    
    echo "Successfully seeded itineraries for Event ID: " . $event->id . "\n";
} else {
    echo "No events found to seed.\n";
}
