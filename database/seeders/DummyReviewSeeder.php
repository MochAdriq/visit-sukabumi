<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Place;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Protected emails that must NEVER be deleted
        $protectedEmails = [
            'admin@admin.com',
            'visitsukabumidotcom@gmail.com',
            'adriq@gmail.com',
            'adrik@gmail.com',
            'test@example.com',
        ];

        $this->command->info("Membersihkan data ulasan dummy sebelumnya agar data baru terdistribusi alami...");
        $oldDummyUserIds = User::whereNotIn('email', $protectedEmails)
            ->where(function ($query) {
                $query->where('role', 'user')->orWhereNull('role');
            })
            ->pluck('id');

        Review::whereIn('user_id', $oldDummyUserIds)->delete();
        User::whereIn('id', $oldDummyUserIds)->delete();

        // Extended pool of realistic Indonesian names
        $firstNamesMale = [
            'Ahmad', 'Rizky', 'Dimas', 'Budi', 'Fajar', 'Ilham', 'Hendra', 'Gilang', 'Bayu', 'Aditya',
            'Wahyu', 'Eko', 'Rian', 'Arif', 'Bagus', 'Deni', 'Tri', 'Doni', 'Farhan', 'Irfan',
            'Dwi', 'Galih', 'Indra', 'Aldi', 'Angga', 'Reza', 'Rendy', 'Satria', 'Wildan', 'Tegar',
            'Yoga', 'Yusuf', 'Lukman', 'Dani', 'Agung', 'Ryan', 'Aris', 'Rio', 'Fauzan', 'Haidar',
            'Danu', 'Bobby', 'Taufik', 'Dicky', 'Faisal', 'Akbar', 'Rahmat', 'Surya', 'Pandu', 'Yudha',
            'Asep', 'Dadang', 'Cecep', 'Deden', 'Ginanjar', 'Heru', 'Joko', 'Kukuh', 'Maman', 'Rangga'
        ];

        $firstNamesFemale = [
            'Siti', 'Putri', 'Dewi', 'Nabila', 'Anisa', 'Maya', 'Ayu', 'Intan', 'Rina', 'Indah',
            'Dina', 'Fitri', 'Laras', 'Tiara', 'Ratna', 'Melati', 'Tari', 'Citra', 'Dinda', 'Nadia',
            'Wulan', 'Rini', 'Gita', 'Annisa', 'Mega', 'Nurul', 'Salsabila', 'Riska', 'Febby', 'Safira',
            'Cindy', 'Vina', 'Zahra', 'Aulia', 'Tasya', 'Bella', 'Alifah', 'Hanifah', 'Farah', 'Desi',
            'Lestari', 'Salma', 'Shafa', 'Amanda', 'Sherly', 'Karina', 'Mira', 'Hilda', 'Novita', 'Widya',
            'Eneng', 'Ai', 'Imas', 'Neng', 'Resti', 'Yuni', 'Poppy', 'Winda', 'Silvia', 'Kania'
        ];

        $lastNames = [
            'Pratama', 'Saputra', 'Santoso', 'Setiawan', 'Wijaya', 'Hidayat', 'Nugroho', 'Wibowo', 'Kusuma', 'Lestari',
            'Anggraini', 'Permata', 'Rahmawati', 'Utami', 'Susanto', 'Gunawan', 'Firmansyah', 'Ramadhan', 'Maulana', 'Kurniawan',
            'Syahputra', 'Siregar', 'Nasution', 'Lubis', 'Simanjuntak', 'Pasaribu', 'Subagyo', 'Prasetya', 'Suherman', 'Hartono',
            'Budiman', 'Sulaeman', 'Iskandar', 'Arifin', 'Basri', 'Syahrul', 'Darmawan', 'Wardhana', 'Purnomo', 'Tanjung',
            'Suhendra', 'Kusnadi', 'Fachrudin', 'Mulyadi', 'Hasan', 'Pangestu', 'Wahyudi', 'Firmanto', 'Hermawan', 'Subekti',
            'Kosasih', 'Ginanjar', 'Suryana', 'Kurnia', 'Somantri', 'Supratman', 'Kusumah', 'Rohendi', 'Subarna', 'Purwanto'
        ];

        $domains = [
            'gmail.com', 'gmail.com', 'gmail.com', 'gmail.com', 'gmail.com',
            'yahoo.com', 'yahoo.com',
            'outlook.com'
        ];

        // 1. Create pool of 150 realistic Indonesian users
        $users = [];
        $existingEmails = User::pluck('email')->toArray();
        $targetUserCount = 150;

        $this->command->info("Membuat pool {$targetUserCount} akun pengguna Indonesia yang realistis...");

        $allFirstNames = array_merge($firstNamesMale, $firstNamesFemale);
        shuffle($allFirstNames);

        for ($i = 0; $i < $targetUserCount; $i++) {
            $firstName = $allFirstNames[$i % count($allFirstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = "{$firstName} {$lastName}";

            $domain = $domains[array_rand($domains)];
            $cleanFirst = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $firstName));
            $cleanLast = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $lastName));
            $style = rand(1, 5);

            switch ($style) {
                case 1:
                    $emailUser = $cleanFirst . '.' . $cleanLast . rand(10, 99);
                    break;
                case 2:
                    $emailUser = $cleanFirst . '_' . $cleanLast . rand(1, 99);
                    break;
                case 3:
                    $emailUser = $cleanFirst . $cleanLast . rand(1985, 2004);
                    break;
                case 4:
                    $emailUser = $cleanLast . '.' . $cleanFirst . rand(1, 99);
                    break;
                case 5:
                default:
                    $emailUser = $cleanFirst . rand(100, 999);
                    break;
            }

            $email = "{$emailUser}@{$domain}";
            while (in_array($email, $existingEmails)) {
                $email = "{$emailUser}" . rand(100, 9999) . "@{$domain}";
            }
            $existingEmails[] = $email;

            $user = User::create([
                'name' => $fullName,
                'email' => $email,
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => Carbon::now()->subDays(rand(10, 200)),
            ]);

            $users[] = $user;
        }

        $this->command->info("Berhasil membuat " . count($users) . " akun pengguna aktif.");

        // 2. Review Content Banks by Rating and Type
        // --- 5 STARS ---
        $reviews5General = [
            "Pemandangannya bener-bener luar biasa indah! Udara sejuk dan asri khas Sukabumi, bikin pikiran jadi segar kembali. Pelayanan dan keramahan warga lokal patut diacungi jempol.",
            "Tempat wisata favorit keluarga kalau lagi ke Sukabumi. Areanya bersih, tertata rapi, dan banyak spot foto estetik. Anak-anak sangat senang bermain di sini.",
            "Luar biasa memukau! Salah satu destinasi alam terbaik di Jawa Barat yang wajib dikunjungi. Pengalaman liburan yang sangat berkesan dan tak terlupakan.",
            "Sangat memuaskan berkunjung ke sini. Tempatnya tenang, hijau, dan sangat asri. Cocok banget buat healing melepas penat setelah seminggu beraktivitas.",
            "Suasana magis saat matahari terbit maupun tenggelam. Fasilitas musholla dan toilet sangat terawat dan bersih. Pasti akan kembali lagi ke sini bersama keluarga!",
            "Hidden gem yang sangat memanjakan mata. Spot fotonya melimpah ruah dengan latar belakang alam yang megah. Worth it banget perjalanan jauh ke sini!",
            "Harga tiket masuk sangat ramah di kantong dibandingkan keindahan alam yang disajikan. Udara pegunungan yang sangat bersih dan menyegarkan."
        ];

        $reviews5Curug = [
            "Curugnya spektakuler sekali! Debit airnya deras dan airnya sangat dingin menyegarkan. Begitu sampai di bawah tebing rasanya semua penat langsung hilang.",
            "Pemandangan air terjun yang megah di antara tebing bebatuan hijau. Spot terbaik untuk foto-foto dan merasakan kesegaran alam Sukabumi yang asli.",
            "Air terjun terindah yang pernah saya kunjungi di Sukabumi. Airnya jernih sekali dan suasananya benar-benar damai. Sangat recommended!"
        ];

        $reviews5Pantai = [
            "Garis pantai yang luas dengan pemandangan ombak laut selatan yang megah. Sunset di sore hari sangat luar biasa indah dan memukau!",
            "Pemandangan laut lepas yang eksotis. Warung kelapa muda di pinggir pantai harganya sangat terjangkau dan suasananya bikin betah berlama-lama.",
            "Pantai yang bersih dan angin sepoi-sepoi yang menenangkan. Momen senja di sini benar-benar magis untuk dinikmati bareng pasangan."
        ];

        // --- 4 STARS ---
        $reviews4General = [
            "Tempatnya bagus banget dan sangat asri. Sedikit catatan buat yang mau ke sini lebih baik datang sebelum jam 10 pagi biar udaranya masih sejuk dan belum terlalu ramai.",
            "Pemandangan alamnya juara dan suasananya tenang. Akses jalan masuk lumayan menanjak dan sedikit sempit di beberapa titik, tapi begitu sampai terbayar lunas.",
            "Sangat menikmati kunjungan ke sini bareng teman-teman. Fasilitas umum sudah lumayan lengkap, hanya saja pilihan warung makanan agak terbatas jadi lebih baik bawa camilan sendiri.",
            "Destinasi wisata yang sangat berkesan. Spot foto instagramable di mana-mana. Disarankan pakai alas kaki yang nyaman karena areanya cukup luas untuk dijelajahi.",
            "Udara sejuk dan pemandangan hijau membentang. Tempat parkirnya cukup luas dan aman. Pengalaman liburan yang sangat menyenangkan secara keseluruhan.",
            "Keindahan alamnya memanjakan mata. Pelayanan petugas cukup ramah dan informatif. Sedikit perbaikan petunjuk arah di jalan utama akan membuatnya semakin sempurna."
        ];

        $reviews4Curug = [
            "Air terjunnya luar biasa sejuk dan pemandangannya eksotis. Jalur trekking ke curug agak licin berbatu, jadi pastikan pakai sepatu atau sandal gunung yang tidak licin ya.",
            "Curug yang sangat asri dan segar. Perjalanan turun dan naiknya cukup menguras tenaga, tapi begitu melihat air terjunnya semua lelah langsung terbayar. Wajib bawa air minum!"
        ];

        $reviews4Pantai = [
            "Pantainya bersih dan suasananya syahdu saat sore. Ombaknya cukup besar jadi tidak disarankan berenang ke tengah, tapi sangat asyik untuk duduk santai di pinggir pantai.",
            "Pemandangan sunset-nya juara dunia! Hanya saja fasilitas bilas air tawar saat kami datang agak antre sedikit. Selebihnya sangat bagus dan berkesan."
        ];

        // --- 3 STARS ---
        $reviews3General = [
            "Pemandangan alamnya sebetulnya sangat indah dan segar. Hanya saja pas kami datang di hari libur pengunjungnya sangat padat, jadi harus sabar antre saat mau ambil foto.",
            "Potensi wisatanya luar biasa bagus dan alami. Namun fasilitas tempat sampah perlu ditambah lagi di beberapa sudut agar kebersihan area wisata tetap terjaga maksimal.",
            "Suasana lumayan sejuk dan asri. Sayangnya pas ke sana cuaca lagi agak mendung jadi pemandangannya tertutup kabut tebal. Mungkin lain kali harus pilih waktu saat cuaca cerah."
        ];

        $reviews3Curug = [
            "Curugnya indah tapi akses jalan menuju lokasi masih butuh perhatian terutama saat musim hujan karena cukup licin. Bagi yang bawa lansia atau anak kecil harus ekstra hati-hati."
        ];

        $reviews3Pantai = [
            "Pemandangan pantainya lumayan bagus untuk santai sore. Namun parkirannya pas akhir pekan agak padat dan perlu penataan yang lebih rapi lagi oleh pengelola."
        ];

        // Event Reviews
        $eventReviews5 = [
            "Acaranya seru banget dan terselenggara dengan sangat meriah! Penampilan seni dan budayanya luar biasa memukau penonton dari berbagai daerah.",
            "Festival budaya yang wajib dibanggakan warga Sukabumi! Sangat menginspirasi dan menghibur. Panggungnya megah dan kuliner lokalnya melimpah ruah.",
            "Pengalaman pertama kali hadir di event ini dan langsung takjub. Antusiasme masyarakat dan suguhan atraksinya keren abis! Sukses terus untuk panitia."
        ];

        $eventReviews4 = [
            "Event yang sangat positif dan edukatif untuk melestarikan tradisi lokal. Rangkaian acaranya padat dan menarik, hanya saja tempat parkir saat jam puncak agak padat.",
            "Pertunjukan budayanya sangat memukau! Stand bazar UMKM juga kreatif. Sedikit saran agar jadwal rundown acara bisa dibagikan lebih awal di media sosial."
        ];

        $eventReviews3 = [
            "Acaranya ramai dan semarak. Hanya saja antrean di pintu masuk utama cukup panjang saat menjelang sore. Semoga tahun depan pengaturan alur masuknya bisa lebih tertib."
        ];

        $visitTypes = ['Keluarga', 'Pasangan', 'Teman', 'Solo'];

        // Helper function to pick realistic rating & matching review
        $pickReview = function ($type, $isCurug, $isPantai) use (
            $reviews5General, $reviews5Curug, $reviews5Pantai,
            $reviews4General, $reviews4Curug, $reviews4Pantai,
            $reviews3General, $reviews3Curug, $reviews3Pantai,
            $eventReviews5, $eventReviews4, $eventReviews3
        ) {
            // Realistic Weighted Distribution:
            // 58% -> 5 Stars
            // 34% -> 4 Stars
            // 8%  -> 3 Stars
            $rand = rand(1, 100);
            if ($rand <= 58) {
                $rating = 5;
            } elseif ($rand <= 92) {
                $rating = 4;
            } else {
                $rating = 3;
            }

            if ($type === 'event') {
                if ($rating === 5) {
                    $content = $eventReviews5[array_rand($eventReviews5)];
                } elseif ($rating === 4) {
                    $content = $eventReviews4[array_rand($eventReviews4)];
                } else {
                    $content = $eventReviews3[array_rand($eventReviews3)];
                }
            } else {
                if ($rating === 5) {
                    $pool = $reviews5General;
                    if ($isCurug) $pool = array_merge($reviews5Curug, $reviews5General);
                    if ($isPantai) $pool = array_merge($reviews5Pantai, $reviews5General);
                } elseif ($rating === 4) {
                    $pool = $reviews4General;
                    if ($isCurug) $pool = array_merge($reviews4Curug, $reviews4General);
                    if ($isPantai) $pool = array_merge($reviews4Pantai, $reviews4General);
                } else {
                    $pool = $reviews3General;
                    if ($isCurug) $pool = array_merge($reviews3Curug, $reviews3General);
                    if ($isPantai) $pool = array_merge($reviews3Pantai, $reviews3General);
                }
                $content = $pool[array_rand($pool)];
            }

            return [$rating, $content];
        };

        // 3. Populate Reviews for Places
        $places = Place::all();
        $this->command->info("Menambahkan ulasan terdistribusi alami untuk {$places->count()} destinasi...");

        $totalAdded = 0;
        foreach ($places as $place) {
            $nameLower = strtolower($place->name . ' ' . $place->description);
            $isCurug = str_contains($nameLower, 'curug') || str_contains($nameLower, 'air terjun');
            $isPantai = str_contains($nameLower, 'pantai') || str_contains($nameLower, 'laut') || str_contains($nameLower, 'ujung genteng') || str_contains($nameLower, 'pelabuhan');

            // 18 to 24 reviews per destination
            $reviewsTarget = rand(18, 24);
            $shuffledUsers = $users;
            shuffle($shuffledUsers);
            $selectedUsers = array_slice($shuffledUsers, 0, $reviewsTarget);

            foreach ($selectedUsers as $user) {
                [$rating, $content] = $pickReview('place', $isCurug, $isPantai);
                $visitType = $visitTypes[array_rand($visitTypes)];
                $createdAt = Carbon::now()->subDays(rand(1, 150))->subHours(rand(1, 23))->subMinutes(rand(1, 59));

                Review::create([
                    'user_id'     => $user->id,
                    'place_id'    => $place->id,
                    'event_id'    => null,
                    'rating'      => $rating,
                    'content'     => $content,
                    'visit_type'  => $visitType,
                    'likes_count' => rand(2, 16),
                    'created_at'  => $createdAt,
                    'updated_at'  => $createdAt,
                ]);

                $totalAdded++;
            }
        }

        // 4. Populate Reviews for Events
        $events = Event::all();
        $this->command->info("Menambahkan ulasan terdistribusi alami untuk {$events->count()} event festival...");

        foreach ($events as $event) {
            $reviewsTarget = rand(10, 16);
            $shuffledUsers = $users;
            shuffle($shuffledUsers);
            $selectedUsers = array_slice($shuffledUsers, 0, $reviewsTarget);

            foreach ($selectedUsers as $user) {
                [$rating, $content] = $pickReview('event', false, false);
                $visitType = $visitTypes[array_rand($visitTypes)];
                $createdAt = Carbon::now()->subDays(rand(1, 120))->subHours(rand(1, 23))->subMinutes(rand(1, 59));

                Review::create([
                    'user_id'     => $user->id,
                    'place_id'    => null,
                    'event_id'    => $event->id,
                    'rating'      => $rating,
                    'content'     => $content,
                    'visit_type'  => $visitType,
                    'likes_count' => rand(2, 14),
                    'created_at'  => $createdAt,
                    'updated_at'  => $createdAt,
                ]);

                $totalAdded++;
            }
        }

        $this->command->info("Selesai! Berhasil membuat {$totalAdded} ulasan dengan distribusi rating realistis (Bintang 5: ~58%, Bintang 4: ~34%, Bintang 3: ~8%).");
    }
}
