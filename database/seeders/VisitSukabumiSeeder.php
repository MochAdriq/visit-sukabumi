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
        $placesRaw = [
            // Wisata Alam
            [$catIds['wisata-alam'], 'Geopark Ciletuh', 'geopark-ciletuh', 'UNESCO Global Geopark pertama di Jawa Barat dengan pemandangan amfiteater alam yang menakjubkan dan air terjun bertingkat.', 'Desa Ciwaru, Kec. Ciemas, Kab. Sukabumi', -7.2558, 106.4527, 'published', 0, '081234567890', 'https://geoparkciletuh.com', 'Setiap hari 07.00-17.00', '4-8 jam', 'Gratis masuk kawasan utama'],
            [$catIds['wisata-alam'], 'Situ Gunung', 'situ-gunung', 'Danau alami dengan jembatan gantung terpanjang di Asia Tenggara (243 meter) di tengah hutan pinus yang sejuk dan menyegarkan.', 'Desa Kadudampit, Kab. Sukabumi', -6.9175, 106.9236, 'published', 25000, '082234567891', null, 'Setiap hari 07.00-16.30', '2-4 jam', 'Tiket jembatan terpisah Rp 50.000'],
            [$catIds['wisata-alam'], 'Curug Cikaso', 'curug-cikaso', 'Air terjun tiga serangkai dengan kolam biru kehijauan memukau. Terdiri dari Curug Asih, Asri, dan Anom dengan ketinggian total 80 meter.', 'Desa Cibitung, Kec. Cibitung, Kab. Sukabumi', -7.1263, 106.5821, 'published', 15000, '083334567892', null, 'Setiap hari 07.00-17.00', '2-3 jam', 'Akses naik perahu Rp 10.000'],
            [$catIds['wisata-alam'], 'Curug Luhur', 'curug-luhur', 'Air terjun setinggi 40 meter tersembunyi di balik hutan hujan tropis yang lebat dengan aliran deras dan kabut yang menyejukkan.', 'Kec. Cicurug, Kab. Sukabumi', -6.7821, 106.8432, 'published', 20000, null, null, 'Sabtu-Minggu 07.00-17.00', '1-2 jam', 'Parkir 5rb motor, 10rb mobil'],
            [$catIds['wisata-alam'], 'Taman Nasional Halimun Salak', 'taman-nasional-halimun-salak', 'Hutan hujan tropis pegunungan terluas di Jawa, rumah bagi Owa Jawa, Elang Jawa, dan ratusan spesies langka.', 'Kec. Kabandungan, Kab. Sukabumi', -6.7215, 106.5483, 'published', 35000, '085534567894', null, 'Setiap hari 08.00-16.00', 'Seharian', 'Pemandu wajib Rp 100.000'],
            // Wisata Pantai
            [$catIds['wisata-pantai'], 'Pantai Palabuhanratu', 'pantai-palabuhanratu', 'Ikon wisata bahari Sukabumi dengan ombak legendaris, surga para peselancar kelas dunia dan seafood segar.', 'Kec. Palabuhanratu, Kab. Sukabumi', -6.9987, 106.5432, 'published', 0, '086634567895', null, '24 jam', '2-5 jam', 'Gratis, parkir berbayar'],
            [$catIds['wisata-pantai'], 'Pantai Ujung Genteng', 'pantai-ujung-genteng', 'Destinasi penyu hijau bertelur setiap malam. Menawarkan snorkeling, birdwatching, dan pelepasan tukik yang tak terlupakan.', 'Desa Ujunggenteng, Kec. Ciracap, Kab. Sukabumi', -7.3521, 106.3812, 'published', 15000, '087734567896', null, 'Setiap hari 06.00-18.00', 'Seharian', 'Tur malam penyu Rp 50.000, booking dulu'],
            [$catIds['wisata-pantai'], 'Pantai Cibangban', 'pantai-cibangban', 'Pantai keluarga dengan pasir putih bersih dan ombak relatif tenang. Fasilitas lengkap, cocok untuk liburan bersama anak.', 'Kec. Cisolok, Kab. Sukabumi', -6.9831, 106.4213, 'published', 10000, null, null, 'Setiap hari 06.00-18.00', '2-4 jam', 'Parkir gratis'],
            [$catIds['wisata-pantai'], 'Pantai Minajaya', 'pantai-minajaya', 'Permata tersembunyi dengan pasir hitam vulkanik dan batu karang unik, pilihan sempurna bagi fotografer landscape.', 'Desa Minajaya, Kec. Surade, Kab. Sukabumi', -7.2987, 106.5123, 'published', 10000, null, null, 'Setiap hari 06.00-17.00', '2-3 jam', null],
            [$catIds['wisata-pantai'], 'Pantai Karang Hawu', 'pantai-karang-hawu', 'Pantai legendaris dengan formasi karang berbentuk tungku raksasa dan sumber air panas alami di dekatnya.', 'Desa Cikaret, Kec. Cisolok, Kab. Sukabumi', -6.9654, 106.4312, 'published', 5000, null, null, 'Setiap hari 06.00-18.00', '1-2 jam', null],
            // Kuliner
            [$catIds['kuliner'], 'Mie Kocok Mang Udin', 'mie-kocok-mang-udin', 'Warung mie kocok legendaris sejak 1975 dengan kuah kaldu sapi kaya rempah, mie kenyal, dan kikil empuk.', 'Jl. Bhayangkara No. 12, Kota Sukabumi', -6.9218, 106.9271, 'published', 25000, '081298765432', null, 'Senin-Sabtu 07.00-14.00', '30-60 menit', null],
            [$catIds['kuliner'], 'Restoran Seafood Palabuhanratu', 'restoran-seafood-palabuhanratu', 'Restoran seafood terbaik dengan bahan baku segar langsung dari nelayan setiap pagi. Ikan bakar bumbu Sukabumi jadi andalan.', 'Jl. Siliwangi No. 45, Palabuhanratu', -6.9945, 106.5389, 'published', 75000, '082298765433', null, 'Setiap hari 10.00-22.00', '1-2 jam', 'Harga per orang estimasi'],
            [$catIds['kuliner'], 'Kedai Kopi Puncak Sukabumi', 'kedai-kopi-puncak-sukabumi', 'Kedai kopi dengan view hamparan kebun teh dan pegunungan. Kopi single origin Sukabumi dan sarapan nasi tutug oncom khas.', 'Jl. Raya Puncak KM 3, Kadudampit, Kab. Sukabumi', -6.9012, 106.9134, 'published', 30000, '083398765434', null, 'Setiap hari 06.00-21.00', '1-3 jam', null],
            [$catIds['kuliner'], 'Warung Soto Mie Sukabumi', 'warung-soto-mie-sukabumi', 'Soto mie khas yang memadukan kuah soto Sunda dengan mie, risol, dan daging sapi. Resep rahasia dua generasi.', 'Pasar Pelita, Jl. Ahmad Yani, Kota Sukabumi', -6.9254, 106.9198, 'published', 20000, null, null, 'Setiap hari 06.00-15.00', '30-60 menit', null],
            [$catIds['kuliner'], 'Pusat Oleh-Oleh Sukabumi Khas', 'pusat-oleh-oleh-sukabumi-khas', 'Toko oleh-oleh terlengkap: dodol, mochi, kopi lokal, keripik ikan asin, dan ratusan souvenir khas Sukabumi.', 'Jl. Raya Sukabumi-Bogor No. 88, Kota Sukabumi', -6.9187, 106.9312, 'published', 0, '085598765436', null, 'Setiap hari 08.00-21.00', '30-60 menit', null],
            // Hotel
            [$catIds['hotel-resort'], 'Hotel Inna Samudra Beach', 'hotel-inna-samudra-beach', 'Hotel berbintang dengan pemandangan langsung Samudra Hindia, kolam renang infinity, spa, dan restoran seafood premium.', 'Jl. Kidang Kencana, Palabuhanratu, Kab. Sukabumi', -6.9923, 106.5367, 'published', 800000, '081312345678', null, 'Check-in 14.00, Check-out 12.00', 'Per malam', 'Sudah termasuk sarapan'],
            [$catIds['hotel-resort'], 'Glamping Situ Gunung', 'glamping-situ-gunung', 'Glamping premium di hutan pinus sejuk dengan tenda dome mewah, kasur nyaman, kamar mandi dalam, dan view danau.', 'Kawasan Situ Gunung, Kadudampit, Kab. Sukabumi', -6.9201, 106.9254, 'published', 650000, '082312345679', null, 'Check-in 15.00, Check-out 11.00', 'Per malam', 'Sudah termasuk sarapan dan tiket masuk'],
            [$catIds['hotel-resort'], 'Villa Bumi Pertiwi', 'villa-bumi-pertiwi', 'Villa keluarga dengan kolam renang pribadi dan kebun organik. Kapasitas 20 orang, cocok untuk gathering dan team building.', 'Kec. Sukaraja, Kab. Sukabumi', -6.8731, 106.9521, 'published', 3000000, '085312345682', null, 'Check-in 14.00, Check-out 12.00', 'Per malam', 'Harga villa full, bukan per orang'],
            [$catIds['hotel-resort'], 'Guest House Panorama Ciletuh', 'guest-house-panorama-ciletuh', 'Penginapan cozy dengan view Teluk Ciletuh yang memukau, dikelola warga lokal dengan kehangatan khas Sunda.', 'Desa Taman Jaya, Kec. Ciemas, Kab. Sukabumi', -7.2312, 106.4389, 'published', 250000, '084312345681', null, 'Check-in 13.00, Check-out 11.00', 'Per malam', 'Sarapan tambah Rp 25.000'],
            [$catIds['hotel-resort'], 'Elora Eco Resort', 'elora-eco-resort', 'Resort eco-friendly eksklusif dengan private pool villa, pemandangan lembah, dan farm-to-table restaurant berkonsep alam.', 'Jl. Raya Caringin KM 5, Kab. Sukabumi', -6.8954, 106.8732, 'published', 1500000, '083312345680', null, 'Check-in 14.00, Check-out 12.00', 'Per malam', 'Min. 2 malam saat weekend'],
            // Aktivitas
            [$catIds['aktivitas-seru'], 'Arung Jeram Sungai Citarik', 'arung-jeram-sungai-citarik', 'Rafting kelas III-IV terbaik di Indonesia! 12 km mengarungi hutan tropis selama 3-4 jam penuh adrenalin dan seru.', 'Desa Cikidang, Kec. Cikidang, Kab. Sukabumi', -6.9432, 106.7821, 'published', 195000, '081387654321', null, 'Setiap hari 07.00-15.00', '3-4 jam', 'Termasuk peralatan, pemandu, makan siang, asuransi'],
            [$catIds['aktivitas-seru'], 'Jembatan Gantung Situ Gunung', 'jembatan-gantung-situ-gunung', 'Jembatan gantung terpanjang di Asia Tenggara, 243 meter di ketinggian 161 meter dengan pemandangan hutan yang dramatis.', 'Kawasan Situ Gunung, Kadudampit, Kab. Sukabumi', -6.9189, 106.9241, 'published', 50000, null, null, 'Setiap hari 07.00-16.00', '1-2 jam', 'Tidak termasuk tiket masuk Situ Gunung'],
            [$catIds['aktivitas-seru'], 'Surfing School Palabuhanratu', 'surfing-school-palabuhanratu', 'Sekolah surfing profesional dengan instruktur bersertifikat untuk semua level, lengkap dengan perlengkapan berkualitas.', 'Pantai Karang Hawu, Palabuhanratu, Kab. Sukabumi', -6.9678, 106.4298, 'published', 150000, '083387654323', null, 'Setiap hari 06.00-18.00', '2 jam per sesi', 'Termasuk papan surfing dan leash'],
            [$catIds['aktivitas-seru'], 'Paragliding Gunung Luhur', 'paragliding-gunung-luhur', 'Terbang tandem di atas lembah hijau Sukabumi bersama pilot bersertifikat internasional dengan pemandangan 360 derajat.', 'Gunung Luhur, Kec. Cikidang, Kab. Sukabumi', -6.9354, 106.7654, 'published', 350000, '084387654324', null, 'Sabtu-Minggu 07.00-15.00 (tergantung cuaca)', '15-30 menit terbang', 'Termasuk foto & video dokumentasi'],
            [$catIds['aktivitas-seru'], 'Snorkeling Ujung Genteng', 'snorkeling-ujung-genteng', 'Jelajahi terumbu karang dan ratusan spesies ikan tropis berwarna-warni di taman laut Ujung Genteng yang terjaga.', 'Pantai Ujung Genteng, Kec. Ciracap, Kab. Sukabumi', -7.3498, 106.3801, 'published', 85000, '085387654325', null, 'Setiap hari 07.00-15.00', '2-3 jam', 'Termasuk peralatan snorkeling dan perahu'],
        ];

        $places = [];
        foreach ($placesRaw as $p) {
            $places[] = [
                'category_id' => $p[0], 'name' => $p[1], 'slug' => $p[2],
                'description' => $p[3], 'address' => $p[4],
                'latitude' => $p[5], 'longitude' => $p[6],
                'status' => $p[7], 'price' => $p[8],
                'phone' => $p[9], 'website' => $p[10],
                'open_hours' => $p[11], 'duration' => $p[12],
                'ticket_info' => $p[13],
                'created_at' => $now, 'updated_at' => $now,
            ];
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
