<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VisitSukabumiSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // ── CATEGORIES ────────────────────────────────────────────
        $categories = [
            ['name' => 'Wisata Alam',    'slug' => 'wisata-alam',    'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Wisata Pantai',  'slug' => 'wisata-pantai',  'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kuliner',        'slug' => 'kuliner',        'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Hotel & Resort', 'slug' => 'hotel-resort',   'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Aktivitas Seru', 'slug' => 'aktivitas-seru', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Wisata Budaya',  'slug' => 'wisata-budaya',  'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('categories')->insertOrIgnore($categories);
        $catIds = DB::table('categories')->pluck('id', 'slug');

        // ── PLACES ────────────────────────────────────────────────
        $places = [];
        
        // Baca file JSON dari root project
        $jsonPath = base_path('sukabumi_places_perfect.json');
        if (file_exists($jsonPath)) {
            $jsonData = json_decode(file_get_contents($jsonPath), true);
            
            // Map JSON keys to Database categories
            $categoryMapping = [
                'hotel' => $catIds['hotel-resort'],
                'kuliner' => $catIds['kuliner'],
                'pariwisata' => $catIds['wisata-alam']
            ];
            
            foreach ($categoryMapping as $jsonKey => $categoryId) {
                if (isset($jsonData[$jsonKey])) {
                    foreach ($jsonData[$jsonKey] as $p) {
                        $places[] = [
                            'category_id' => $categoryId,
                            'name' => $p['name'],
                            'slug' => \Illuminate\Support\Str::slug($p['name']),
                            'description' => 'Ini adalah deskripsi otomatis untuk ' . $p['name'] . '. ' . 
                                             'Nikmati pengalaman terbaik dengan fasilitas yang memadai dan pelayanan ramah.',
                            'address' => $p['address'],
                            'latitude' => $p['latitude'],
                            'longitude' => $p['longitude'],
                            'status' => 'published',
                            // Simulasi harga: Jika string hapus non-angka, jika kosong beri nilai 0
                            'price' => isset($p['price_level']) && $p['price_level'] == 'Gratis' ? 0 : rand(10000, 150000),
                            'phone' => $p['phone'] ?? null,
                            'website' => $p['website'] ?? null,
                            'open_hours' => $p['open_hours'] ?? 'Buka 24 Jam',
                            'duration' => '1-3 jam',
                            'ticket_info' => 'Tersedia di lokasi',
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                }
            }
        }
        
        DB::table('places')->insertOrIgnore($places);
        $placeIds = DB::table('places')->pluck('id', 'slug');

        // ── REVIEWS ───────────────────────────────────────────────
        $userId = DB::table('users')->value('id');
        $comments = [
            [5, 'Tempat yang luar biasa! Pemandangannya sangat indah dan bikin betah. Pasti akan kembali lagi bersama keluarga.', 'Keluarga'],
            [4, 'Sangat merekomendasikan untuk dikunjungi. Akses jalan sudah cukup baik dan fasilitas memadai.', 'Teman'],
            [5, 'Pengalaman tak terlupakan! Staff sangat ramah dan pelayanan prima. Worth every rupiah!', 'Pasangan'],
            [4, 'Indah banget! Tapi perlu datang pagi supaya tidak terlalu ramai. Foto-fotonya bagus semua.', 'Solo'],
            [3, 'Tempatnya bagus tapi agak susah aksesnya. Secara keseluruhan cukup puas berkunjung ke sini.', 'Keluarga'],
        ];

        $reviews = [];
        foreach ($placeIds as $slug => $placeId) {
            foreach ($comments as $c) {
                $reviews[] = [
                    'user_id'    => $userId,
                    'place_id'   => $placeId,
                    'rating'     => $c[0],
                    'content'    => $c[1],
                    'visit_type' => $c[2],
                    'created_at' => Carbon::now()->subDays(rand(1, 60)),
                    'updated_at' => $now,
                ];
            }
        }
        DB::table('reviews')->insertOrIgnore($reviews);

        $this->command->info('Seeded: ' . count($categories) . ' kategori, ' . count($places) . ' destinasi, ' . count($reviews) . ' ulasan.');
    }
}
