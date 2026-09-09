<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventAndTicketSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // ── EVENTS ────────────────────────────────────────────────────
        // Kita ambil gambar dari place_images yang sudah ada agar tidak pecah
        $sampleImages = DB::table('place_images')
            ->orderByRaw('RAND()')
            ->limit(6)
            ->pluck('image_path')
            ->toArray();

        // Fungsi helper ambil gambar yang tersedia
        $getImg = fn($index) => $sampleImages[$index] ?? null;

        $events = [
            [
                'title'         => 'Festival Nelayan Palabuhanratu',
                'slug'          => 'festival-nelayan-palabuhanratu',
                'description'   => '<p>Festival tahunan nelayan Palabuhanratu yang menampilkan budaya lokal, perlombaan perahu, pasar ikan segar, dan pertunjukan seni tradisional Sunda. Acara ini dihadiri ribuan pengunjung dari seluruh Jawa Barat.</p>',
                'start_date'    => Carbon::now()->addDays(5)->setTime(8, 0),
                'end_date'      => Carbon::now()->addDays(7)->setTime(21, 0),
                'location_name' => 'Pantai Palabuhanratu, Sukabumi Selatan',
                'image_path'    => $getImg(0),
                'is_active'     => true,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'title'         => 'Seren Taun Ciptagelar',
                'slug'          => 'seren-taun-ciptagelar',
                'description'   => '<p>Upacara adat panen raya tahunan masyarakat Kasepuhan Ciptagelar. Sebuah tradisi sakral yang memperlihatkan kearifan lokal dan keharmonisan manusia dengan alam. Nikmati keindahan budaya Sunda yang otentik.</p>',
                'start_date'    => Carbon::now()->addDays(12)->setTime(07, 0),
                'end_date'      => Carbon::now()->addDays(12)->setTime(17, 0),
                'location_name' => 'Kampung Adat Ciptagelar, Cisolok',
                'image_path'    => $getImg(1),
                'is_active'     => true,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'title'         => 'Sukabumi Trail Run 2026',
                'slug'          => 'sukabumi-trail-run-2026',
                'description'   => '<p>Kompetisi lari alam terbuka di jalur-jalur eksotis Geopark Ciletuh. Tersedia kategori 15K, 30K, dan 50K untuk para petualang sejati. Melewati hutan, air terjun, dan tebing megah.</p>',
                'start_date'    => Carbon::now()->addDays(3)->setTime(05, 30),
                'end_date'      => Carbon::now()->addDays(3)->setTime(18, 0),
                'location_name' => 'Geopark Ciletuh, Pelabuhan Ratu',
                'image_path'    => $getImg(2),
                'is_active'     => true,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'title'         => 'Pameran Kuliner & UMKM Sukabumi',
                'slug'          => 'pameran-kuliner-umkm-sukabumi',
                'description'   => '<p>Festival kuliner yang menampilkan ratusan produk UMKM lokal Sukabumi. Temukan aneka makanan khas seperti Mie Kocok, Soto Mie, Nasi Liwet, dan berbagai oleh-oleh khas daerah dengan harga terjangkau.</p>',
                'start_date'    => Carbon::now()->addDays(8)->setTime(10, 0),
                'end_date'      => Carbon::now()->addDays(10)->setTime(22, 0),
                'location_name' => 'Alun-Alun Kota Sukabumi',
                'image_path'    => $getImg(3),
                'is_active'     => true,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'title'         => 'Ciletuh Geopark Photography Contest',
                'slug'          => 'ciletuh-geopark-photography-contest',
                'description'   => '<p>Kontes fotografi alam terbuka di kawasan UNESCO Global Geopark Ciletuh-Palabuhanratu. Berhadiah total 25 juta rupiah dengan kategori Landscape, Wildlife, dan Human Interest.</p>',
                'start_date'    => Carbon::now()->addDays(20)->setTime(07, 0),
                'end_date'      => Carbon::now()->addDays(22)->setTime(17, 0),
                'location_name' => 'Kawasan Geopark Ciletuh',
                'image_path'    => $getImg(4),
                'is_active'     => true,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'title'         => 'Malam Budaya Sunda di Gedung Juang',
                'slug'          => 'malam-budaya-sunda-gedung-juang',
                'description'   => '<p>Pagelaran seni dan budaya Sunda yang menampilkan Wayang Golek, Jaipong, dan Tembang Sunda. Sebuah malam yang akan membawa Boss ke dunia budaya lokal yang kaya dan penuh warna.</p>',
                'start_date'    => Carbon::now()->addDays(2)->setTime(19, 0),
                'end_date'      => Carbon::now()->addDays(2)->setTime(23, 0),
                'location_name' => 'Gedung Juang 45, Kota Sukabumi',
                'image_path'    => $getImg(5),
                'is_active'     => true,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ];

        DB::table('events')->insertOrIgnore($events);
        $this->command->info('✓ Seeded ' . count($events) . ' events.');

        // ── TICKETS ───────────────────────────────────────────────────
        // Ambil beberapa place ID yang ada
        $places = DB::table('places')
            ->where('status', 'published')
            ->limit(6)
            ->get(['id', 'name']);

        if ($places->isEmpty()) {
            $this->command->warn('⚠ Tidak ada place yang ditemukan, skip tickets seeder.');
            return;
        }

        $tickets = [];
        foreach ($places as $place) {
            // Tiket Reguler
            $tickets[] = [
                'place_id'    => $place->id,
                'name'        => 'Tiket Masuk Reguler',
                'type'        => 'reguler',
                'price'       => rand(25000, 75000),
                'date'        => null,
                'quota'       => null,
                'is_active'   => true,
                'description' => 'Tiket masuk reguler untuk ' . $place->name . '. Sudah termasuk akses ke seluruh area wisata.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ];

            // Open Trip
            $tickets[] = [
                'place_id'    => $place->id,
                'name'        => 'Open Trip Weekend - ' . $place->name,
                'type'        => 'open_trip',
                'price'       => rand(150000, 450000),
                'date'        => Carbon::now()->addDays(rand(3, 14))->setTime(07, 0),
                'quota'       => rand(10, 25),
                'is_active'   => true,
                'description' => 'Paket Open Trip ke ' . $place->name . '. Include: transportasi PP, guide lokal berpengalaman, makan siang, dan dokumentasi foto.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        DB::table('tickets')->insertOrIgnore($tickets);
        $this->command->info('✓ Seeded ' . count($tickets) . ' tickets.');
    }
}
