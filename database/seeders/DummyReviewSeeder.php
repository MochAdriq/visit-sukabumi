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

        // Extended pool of realistic Indonesian names (60 male + 60 female = 120 first names x 60 last names = 7,200 combinations)
        $firstNamesMale = [
            'Ahmad', 'Rizky', 'Dimas', 'Budi', 'Fajar', 'Ilham', 'Hendra', 'Gilang', 'Bayu', 'Aditya',
            'Wahyu', 'Eko', 'Rian', 'Arif', 'Bagus', 'Deni', 'Tri', 'Doni', 'Farhan', 'Irfan',
            'Dwi', 'Galih', 'Indra', 'Aldi', 'Angga', 'Reza', 'Rendy', 'Satria', 'Wildan', 'Tegar',
            'Yoga', 'Yusuf', 'Lukman', 'Dani', 'Agung', 'Ryan', 'Aris', 'Rio', 'Fauzan', 'Haidar',
            'Danu', 'Bobby', 'Taufik', 'Dicky', 'Faisal', 'Akbar', 'Rahmat', 'Surya', 'Pandu', 'Yudha',
            'Asep', 'Dadang', 'Cecep', 'Deden', 'Ginanjar', 'Heru', 'Joko', 'Kukuh', 'Maman', 'Rangga',
            'Yayan', 'Bambang', 'Candra', 'Dharma', 'Edi', 'Gunadi', 'Hadi', 'Iskandar', 'Joni', 'Kurnia'
        ];

        $firstNamesFemale = [
            'Siti', 'Putri', 'Dewi', 'Nabila', 'Anisa', 'Maya', 'Ayu', 'Intan', 'Rina', 'Indah',
            'Dina', 'Fitri', 'Laras', 'Tiara', 'Ratna', 'Melati', 'Tari', 'Citra', 'Dinda', 'Nadia',
            'Wulan', 'Rini', 'Gita', 'Annisa', 'Mega', 'Nurul', 'Salsabila', 'Riska', 'Febby', 'Safira',
            'Cindy', 'Vina', 'Zahra', 'Aulia', 'Tasya', 'Bella', 'Alifah', 'Hanifah', 'Farah', 'Desi',
            'Lestari', 'Salma', 'Shafa', 'Amanda', 'Sherly', 'Karina', 'Mira', 'Hilda', 'Novita', 'Widya',
            'Eneng', 'Ai', 'Imas', 'Neng', 'Resti', 'Yuni', 'Poppy', 'Winda', 'Silvia', 'Kania',
            'Tantri', 'Yuliana', 'Zulfa', 'Pratiwi', 'Kusuma', 'Ratnasari', 'Dewantari', 'Febriana', 'Gisella', 'Hartati'
        ];

        $lastNames = [
            'Pratama', 'Saputra', 'Santoso', 'Setiawan', 'Wijaya', 'Hidayat', 'Nugroho', 'Wibowo', 'Kusuma', 'Lestari',
            'Anggraini', 'Permata', 'Rahmawati', 'Utami', 'Susanto', 'Gunawan', 'Firmansyah', 'Ramadhan', 'Maulana', 'Kurniawan',
            'Syahputra', 'Siregar', 'Nasution', 'Lubis', 'Simanjuntak', 'Pasaribu', 'Subagyo', 'Prasetya', 'Suherman', 'Hartono',
            'Budiman', 'Sulaeman', 'Iskandar', 'Arifin', 'Basri', 'Syahrul', 'Darmawan', 'Wardhana', 'Purnomo', 'Tanjung',
            'Suhendra', 'Kusnadi', 'Fachrudin', 'Mulyadi', 'Hasan', 'Pangestu', 'Wahyudi', 'Firmanto', 'Hermawan', 'Subekti',
            'Kosasih', 'Ginanjar', 'Suryana', 'Kurnia', 'Somantri', 'Supratman', 'Kusumah', 'Rohendi', 'Subarna', 'Purwanto',
            'Adriansyah', 'Bachtiar', 'Chaniago', 'Djatmiko', 'Effendi', 'Fauzi', 'Hakim', 'Irawan', 'Juanda', 'Kharisma'
        ];

        $domains = [
            'gmail.com', 'gmail.com', 'gmail.com', 'gmail.com', 'gmail.com',
            'yahoo.com', 'yahoo.com',
            'outlook.com'
        ];

        // 1. Create pool of 400 realistic Indonesian users
        $users = [];
        $existingEmails = User::pluck('email')->toArray();
        $targetUserCount = 400;

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
                    $emailUser = $cleanFirst . $cleanLast . rand(1980, 2005);
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
                'email_verified_at' => Carbon::now()->subDays(rand(10, 240)),
            ]);

            $users[] = $user;
        }

        $this->command->info("Berhasil membuat " . count($users) . " akun pengguna aktif.");

        // 2. Comprehensive Review Content Banks (Ratings 5, 4, 3, 2, and 1)
        // --- 5 STARS (Luar Biasa) ---
        $reviews5General = [
            "Pemandangannya bener-bener luar biasa indah! Udara sejuk dan asri khas Sukabumi, bikin pikiran jadi segar kembali. Pelayanan dan keramahan warga lokal patut diacungi jempol.",
            "Tempat wisata favorit keluarga kalau lagi ke Sukabumi. Areanya bersih, tertata rapi, dan banyak spot foto estetik. Anak-anak sangat senang bermain di sini.",
            "Luar biasa memukau! Salah satu destinasi alam terbaik di Jawa Barat yang wajib dikunjungi. Pengalaman liburan yang sangat berkesan dan tak terlupakan.",
            "Sangat memuaskan berkunjung ke sini. Tempatnya tenang, hijau, dan sangat asri. Cocok banget buat healing melepas penat setelah seminggu beraktivitas.",
            "Suasana magis saat matahari terbit maupun tenggelam. Fasilitas musholla dan toilet sangat terawat dan bersih. Pasti akan kembali lagi ke sini bersama keluarga!",
            "Hidden gem yang sangat memanjakan mata. Spot fotonya melimpah ruah dengan latar belakang alam yang megah. Worth it banget perjalanan jauh ke sini!",
            "Harga tiket masuk sangat ramah di kantong dibandingkan keindahan alam yang disajikan. Udara pegunungan yang sangat bersih dan menyegarkan.",
            "Sensasi menyatu dengan alam yang sesungguhnya. Pemandangan hijau sejauh mata memandang, fasilitas parkir luas dan aman.",
            "Sangat kagum dengan kelestarian alamnya. Bersih dan bebas polusi, rekomendasi utama untuk liburan akhir pekan!"
        ];

        $reviews5Curug = [
            "Curugnya spektakuler sekali! Debit airnya deras dan airnya sangat dingin menyegarkan. Begitu sampai di bawah tebing rasanya semua penat langsung hilang.",
            "Pemandangan air terjun yang megah di antara tebing bebatuan hijau. Spot terbaik untuk foto-foto dan merasakan kesegaran alam Sukabumi yang asli.",
            "Air terjun terindah yang pernah saya kunjungi di Sukabumi. Airnya jernih sekali dan suasananya benar-benar damai. Sangat recommended!",
            "Percikan embun air terjunnya sejuk banget di wajah. Dikelilingi hutan lebat yang masih sangat perawan. Juara pisan!"
        ];

        $reviews5Pantai = [
            "Garis pantai yang luas dengan pemandangan ombak laut selatan yang megah. Sunset di sore hari sangat luar biasa indah dan memukau!",
            "Pemandangan laut lepas yang eksotis. Warung kelapa muda di pinggir pantai harganya sangat terjangkau dan suasananya bikin betah berlama-lama.",
            "Pantai yang bersih dan angin sepoi-sepoi yang menenangkan. Momen senja di sini benar-benar magis untuk dinikmati bareng pasangan.",
            "Hamparan pasir yang lembut dan deretan pohon kelapa yang asri. Pemandangan matahari terbenamnya luar biasa spektakuler!"
        ];

        // --- 4 STARS (Bagus) ---
        $reviews4General = [
            "Tempatnya bagus banget dan sangat asri. Sedikit catatan buat yang mau ke sini lebih baik datang sebelum jam 10 pagi biar udaranya masih sejuk dan belum terlalu ramai.",
            "Pemandangan alamnya juara dan suasananya tenang. Akses jalan masuk lumayan menanjak dan sedikit sempit di beberapa titik, tapi begitu sampai terbayar lunas.",
            "Sangat menikmati kunjungan ke sini bareng teman-teman. Fasilitas umum sudah lumayan lengkap, hanya saja pilihan warung makanan agak terbatas jadi lebih baik bawa camilan sendiri.",
            "Destinasi wisata yang sangat berkesan. Spot foto instagramable di mana-mana. Disarankan pakai alas kaki yang nyaman karena areanya cukup luas untuk dijelajahi.",
            "Udara sejuk dan pemandangan hijau membentang. Tempat parkirnya cukup luas dan aman. Pengalaman liburan yang sangat menyenangkan secara keseluruhan.",
            "Keindahan alamnya memanjakan mata. Pelayanan petugas cukup ramah dan informatif. Sedikit perbaikan petunjuk arah di jalan utama akan membuatnya semakin sempurna.",
            "Suasana tenang dan damai. Cocok buat santai sore. Fasilitas musholla sudah tersedia walau ukurannya tidak terlalu besar."
        ];

        $reviews4Curug = [
            "Air terjunnya luar biasa sejuk dan pemandangannya eksotis. Jalur trekking ke curug agak licin berbatu, jadi pastikan pakai sepatu atau sandal gunung yang tidak licin ya.",
            "Curug yang sangat asri dan segar. Perjalanan turun dan naiknya cukup menguras tenaga, tapi begitu melihat air terjunnya semua lelah langsung terbayar. Wajib bawa air minum!"
        ];

        $reviews4Pantai = [
            "Pantainya bersih dan suasananya syahdu saat sore. Ombaknya cukup besar jadi tidak disarankan berenang ke tengah, tapi sangat asyik untuk duduk santai di pinggir pantai.",
            "Pemandangan sunset-nya juara dunia! Hanya saja fasilitas bilas air tawar saat kami datang agak antre sedikit. Selebihnya sangat bagus dan berkesan."
        ];

        // --- 3 STARS (Biasa / Cukup) ---
        $reviews3General = [
            "Pemandangan alamnya sebetulnya sangat indah dan segar. Hanya saja pas kami datang di hari libur pengunjungnya sangat padat, jadi harus sabar antre saat mau ambil foto.",
            "Potensi wisatanya luar biasa bagus dan alami. Namun fasilitas tempat sampah perlu ditambah lagi di beberapa sudut agar kebersihan area wisata tetap terjaga maksimal.",
            "Suasana lumayan sejuk dan asri. Sayangnya pas ke sana cuaca lagi agak mendung jadi pemandangannya tertutup kabut tebal. Mungkin lain kali harus pilih waktu saat cuaca cerah.",
            "Bagus tapi jarak dari jalan raya utama lumayan jauh dan berliku. Semoga ke depannya penerangan jalan saat malam bisa ditingkatkan."
        ];

        $reviews3Curug = [
            "Curugnya indah tapi akses jalan menuju lokasi masih butuh perhatian terutama saat musim hujan karena cukup licin. Bagi yang bawa lansia atau anak kecil harus ekstra hati-hati."
        ];

        $reviews3Pantai = [
            "Pemandangan pantainya lumayan bagus untuk santai sore. Namun parkirannya pas akhir pekan agak padat dan perlu penataan yang lebih rapi lagi oleh pengelola."
        ];

        // --- 2 STARS (Buruk - Sangat Sedikit) ---
        $reviews2 = [
            "Pemandangan alamnya sebenarnya potensial, tapi sayang pas kami datang fasilitas toilet kurang bersih dan airnya kecil. Pengelola perlu lebih memperhatikan kebersihan fasilitas umum.",
            "Akses jalan beberapa kilometer sebelum lokasi masih berbatu dan berlubang. Bagi mobil ceper harus ekstra hati-hati. Semoga pemda setempat segera memperbaiki jalan masuknya.",
            "Ekspektasi cukup tinggi dari ulasan medsos, tapi ternyata pas akhir pekan sangat macet di pintu masuk dan pedagang agak terlalu agresif menawarkan barang."
        ];

        // --- 1 STAR (Sangat Buruk - Sangat Langka) ---
        $reviews1 = [
            "Sangat disayangkan ada oknum yang meminta tarif parkir tidak resmi di luar pos masuk resmi. Mohon pihak pengelola menertibkan hal ini agar tidak merusak nama baik wisata Sukabumi.",
            "Pengalaman kurang mengenakkan saat musim hujan karena jalanan tanah jadi sangat berlumpur tanpa ada jalan setapak yang layak. Tidak disarankan membawa anak kecil atau orang tua saat musim penghujan."
        ];

        // Event Reviews
        $eventReviews5 = [
            "Acaranya seru banget dan terselenggara dengan sangat meriah! Penampilan seni dan budayanya luar biasa memukau penonton dari berbagai daerah.",
            "Festival budaya yang wajib dibanggakan warga Sukabumi! Sangat menginspirasi dan menghibur. Panggungnya megah dan kuliner lokalnya melimpah ruah.",
            "Pengalaman pertama kali hadir di event ini dan langsung takjub. Antusiasme masyarakat dan suguhan atraksinya keren abis! Sukses terus untuk panitia.",
            "Tata panggung dan lighting-nya spektakuler. Acara tahunan yang wajib terus dilestarikan dan didukung!"
        ];

        $eventReviews4 = [
            "Event yang sangat positif dan edukatif untuk melestarikan tradisi lokal. Rangkaian acaranya padat dan menarik, hanya saja tempat parkir saat jam puncak agak padat.",
            "Pertunjukan budayanya sangat memukau! Stand bazar UMKM juga kreatif. Sedikit saran agar jadwal rundown acara bisa dibagikan lebih awal di media sosial."
        ];

        $eventReviews3 = [
            "Acaranya ramai dan semarak. Hanya saja antrean di pintu masuk utama cukup panjang saat menjelang sore. Semoga tahun depan pengaturan alur masuknya bisa lebih tertib."
        ];

        $eventReviews2 = [
            "Kurang koordinasi soal kantong parkir sehingga sempat terjadi penumpukan kendaraan di sekitar area festival. Acaranya sendiri lumayan bagus."
        ];

        $visitTypes = ['Keluarga', 'Pasangan', 'Teman', 'Solo'];

        // Helper function for picking rating & review (56% 5★, 32% 4★, 8% 3★, 3% 2★, 1% 1★)
        $pickReview = function ($type, $isCurug, $isPantai) use (
            $reviews5General, $reviews5Curug, $reviews5Pantai,
            $reviews4General, $reviews4Curug, $reviews4Pantai,
            $reviews3General, $reviews3Curug, $reviews3Pantai,
            $reviews2, $reviews1,
            $eventReviews5, $eventReviews4, $eventReviews3, $eventReviews2
        ) {
            $rand = rand(1, 100);
            if ($rand <= 56) {
                $rating = 5;
            } elseif ($rand <= 88) {
                $rating = 4;
            } elseif ($rand <= 96) {
                $rating = 3;
            } elseif ($rand <= 99) {
                $rating = 2;
            } else {
                $rating = 1;
            }

            if ($type === 'event') {
                if ($rating === 5) {
                    $content = $eventReviews5[array_rand($eventReviews5)];
                } elseif ($rating === 4) {
                    $content = $eventReviews4[array_rand($eventReviews4)];
                } elseif ($rating === 3) {
                    $content = $eventReviews3[array_rand($eventReviews3)];
                } else {
                    $content = $eventReviews2[array_rand($eventReviews2)];
                }
            } else {
                if ($rating === 5) {
                    $pool = $reviews5General;
                    if ($isCurug) $pool = array_merge($reviews5Curug, $reviews5General);
                    if ($isPantai) $pool = array_merge($reviews5Pantai, $reviews5General);
                    $content = $pool[array_rand($pool)];
                } elseif ($rating === 4) {
                    $pool = $reviews4General;
                    if ($isCurug) $pool = array_merge($reviews4Curug, $reviews4General);
                    if ($isPantai) $pool = array_merge($reviews4Pantai, $reviews4General);
                    $content = $pool[array_rand($pool)];
                } elseif ($rating === 3) {
                    $pool = $reviews3General;
                    if ($isCurug) $pool = array_merge($reviews3Curug, $reviews3General);
                    if ($isPantai) $pool = array_merge($reviews3Pantai, $reviews3General);
                    $content = $pool[array_rand($pool)];
                } elseif ($rating === 2) {
                    $content = $reviews2[array_rand($reviews2)];
                } else {
                    $content = $reviews1[array_rand($reviews1)];
                }
            }

            // Realistic likes count based on rating
            if ($rating >= 4) {
                $likes = rand(3, 35);
            } elseif ($rating === 3) {
                $likes = rand(1, 10);
            } else {
                $likes = rand(0, 4);
            }

            return [$rating, $content, $likes];
        };

        // 3. Populate Reviews for Places (~75 to 88 reviews per destination = ~1,200 reviews)
        $places = Place::all();
        $this->command->info("Menambahkan ulasan dummy 4x lipat untuk {$places->count()} destinasi...");

        $totalAdded = 0;
        foreach ($places as $place) {
            $nameLower = strtolower($place->name . ' ' . $place->description);
            $isCurug = str_contains($nameLower, 'curug') || str_contains($nameLower, 'air terjun');
            $isPantai = str_contains($nameLower, 'pantai') || str_contains($nameLower, 'laut') || str_contains($nameLower, 'ujung genteng') || str_contains($nameLower, 'pelabuhan');

            // 75 to 88 reviews per destination
            $reviewsTarget = rand(75, 88);
            $shuffledUsers = $users;
            shuffle($shuffledUsers);
            $selectedUsers = array_slice($shuffledUsers, 0, $reviewsTarget);

            foreach ($selectedUsers as $user) {
                [$rating, $content, $likes] = $pickReview('place', $isCurug, $isPantai);
                $visitType = $visitTypes[array_rand($visitTypes)];
                $createdAt = Carbon::now()->subDays(rand(1, 240))->subHours(rand(1, 23))->subMinutes(rand(1, 59));

                Review::create([
                    'user_id'     => $user->id,
                    'place_id'    => $place->id,
                    'event_id'    => null,
                    'rating'      => $rating,
                    'content'     => $content,
                    'visit_type'  => $visitType,
                    'likes_count' => $likes,
                    'created_at'  => $createdAt,
                    'updated_at'  => $createdAt,
                ]);

                $totalAdded++;
            }
        }

        // 4. Populate Reviews for Events (~40 to 50 reviews per event = ~270 reviews)
        $events = Event::all();
        $this->command->info("Menambahkan ulasan dummy 4x lipat untuk {$events->count()} event festival...");

        foreach ($events as $event) {
            $reviewsTarget = rand(40, 50);
            $shuffledUsers = $users;
            shuffle($shuffledUsers);
            $selectedUsers = array_slice($shuffledUsers, 0, $reviewsTarget);

            foreach ($selectedUsers as $user) {
                [$rating, $content, $likes] = $pickReview('event', false, false);
                $visitType = $visitTypes[array_rand($visitTypes)];
                $createdAt = Carbon::now()->subDays(rand(1, 200))->subHours(rand(1, 23))->subMinutes(rand(1, 59));

                Review::create([
                    'user_id'     => $user->id,
                    'place_id'    => null,
                    'event_id'    => $event->id,
                    'rating'      => $rating,
                    'content'     => $content,
                    'visit_type'  => $visitType,
                    'likes_count' => $likes,
                    'created_at'  => $createdAt,
                    'updated_at'  => $createdAt,
                ]);

                $totalAdded++;
            }
        }

        $this->command->info("Selesai! Berhasil membuat {$totalAdded} ulasan (4x lipat) dengan distribusi 5★, 4★, 3★, dan sedikit 2★ & 1★.");
    }
}
