<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Place;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstNamesMale = [
            'Ahmad', 'Rizky', 'Dimas', 'Budi', 'Fajar', 'Ilham', 'Hendra', 'Gilang', 'Bayu', 'Aditya',
            'Wahyu', 'Eko', 'Rian', 'Arif', 'Bagus', 'Deni', 'Tri', 'Doni', 'Farhan', 'Irfan',
            'Dwi', 'Galih', 'Indra', 'Aldi', 'Angga', 'Reza', 'Rendy', 'Satria', 'Wildan', 'Tegar',
            'Yoga', 'Yusuf', 'Lukman', 'Dani', 'Agung', 'Ryan', 'Aris', 'Rio', 'Fauzan', 'Haidar',
            'Danu', 'Bobby', 'Taufik', 'Dicky', 'Faisal', 'Akbar', 'Rahmat', 'Surya', 'Pandu', 'Yudha'
        ];

        $firstNamesFemale = [
            'Siti', 'Putri', 'Dewi', 'Nabila', 'Anisa', 'Maya', 'Ayu', 'Intan', 'Rina', 'Indah',
            'Dina', 'Fitri', 'Laras', 'Tiara', 'Ratna', 'Melati', 'Tari', 'Citra', 'Dinda', 'Nadia',
            'Wulan', 'Rini', 'Gita', 'Annisa', 'Mega', 'Nurul', 'Salsabila', 'Riska', 'Febby', 'Safira',
            'Cindy', 'Vina', 'Zahra', 'Aulia', 'Tasya', 'Bella', 'Alifah', 'Hanifah', 'Farah', 'Desi',
            'Lestari', 'Salma', 'Shafa', 'Amanda', 'Sherly', 'Karina', 'Mira', 'Hilda', 'Novita', 'Widya'
        ];

        $lastNames = [
            'Pratama', 'Saputra', 'Santoso', 'Setiawan', 'Wijaya', 'Hidayat', 'Nugroho', 'Wibowo', 'Kusuma', 'Lestari',
            'Anggraini', 'Permata', 'Rahmawati', 'Utami', 'Susanto', 'Gunawan', 'Firmansyah', 'Ramadhan', 'Maulana', 'Kurniawan',
            'Syahputra', 'Siregar', 'Nasution', 'Lubis', 'Simanjuntak', 'Pasaribu', 'Subagyo', 'Prasetya', 'Suherman', 'Hartono',
            'Budiman', 'Sulaeman', 'Iskandar', 'Arifin', 'Basri', 'Syahrul', 'Darmawan', 'Wardhana', 'Purnomo', 'Tanjung',
            'Suhendra', 'Kusnadi', 'Fachrudin', 'Mulyadi', 'Hasan', 'Pangestu', 'Wahyudi', 'Firmanto', 'Hermawan', 'Subekti'
        ];

        $domains = [
            'gmail.com', 'gmail.com', 'gmail.com', 'gmail.com', 'gmail.com', // 70% Gmail
            'yahoo.com', 'yahoo.com',                                         // 20% Yahoo
            'outlook.com'                                                     // 10% Outlook
        ];

        // 1. Generate pool of 120 realistic Indonesian users
        $users = [];
        $existingEmails = User::pluck('email')->toArray();
        $targetUserCount = 120;

        $this->command->info("Membuat/menyiapkan pool {$targetUserCount} akun pengguna Indonesia yang realistis...");

        $allFirstNames = array_merge($firstNamesMale, $firstNamesFemale);
        shuffle($allFirstNames);

        $createdCount = 0;
        for ($i = 0; $i < $targetUserCount; $i++) {
            $firstName = $allFirstNames[$i % count($allFirstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = "{$firstName} {$lastName}";

            // Generate realistic Indonesian email address
            $domain = $domains[array_rand($domains)];
            $emailStyle = rand(1, 5);
            $cleanFirst = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $firstName));
            $cleanLast = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $lastName));

            switch ($emailStyle) {
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

            // Ensure unique email
            while (in_array($email, $existingEmails)) {
                $email = "{$emailUser}" . rand(100, 9999) . "@{$domain}";
            }
            $existingEmails[] = $email;

            // Create or update user
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $fullName,
                    'password' => Hash::make('password123'),
                    'role' => 'user', // Safe role: cannot access Filament admin
                    'email_verified_at' => Carbon::now()->subDays(rand(10, 200)),
                ]
            );

            $users[] = $user;
            $createdCount++;
        }

        $this->command->info("Tersedia " . count($users) . " akun pengguna aktif.");

        // 2. Realistic review texts tailored for Sukabumi tourism
        $reviewsPoolGeneral = [
            "Tempatnya adem banget dan cocok buat healing bareng keluarga. Pemandangannya luar biasa indah, anak-anak juga betah seharian main di sini.",
            "Akses jalannya sekarang sudah semakin bagus, udaranya sejuk pisan khas Sukabumi. Wajib bawa jaket kalau ke sini pagi-pagi.",
            "Spot foto pemandangannya beneran juara! Warung-warung di sekitar juga ramah dan harganya terjangkau, kopinya nikmat.",
            "Hidden gem di Sukabumi yang wajib dikunjungi. Capek selama perjalanan langsung terbayar lunas begitu sampai di lokasi. Rekomended banget!",
            "Fasilitas musholla dan toilet bersih dan terawat. Tiket masuknya terjangkau dan pemandangan alamnya bikin tenang pikiran.",
            "Salah satu tempat wisata paling berkesan di Sukabumi. Cocok buat melepas penat dari rutinitas kerja ibu kota.",
            "Suasana asri dan sangat alami. Warga lokalnya ramah-ramah dan membantu saat kami tanya arah jalan.",
            "Pemandangan saat cuaca cerah luar biasa bagus. Saran saya datang pagi-pagi biar dapat momen kabut tipis dan udara paling segar.",
            "Tempat yang sangat instagramable dan estetik. Banyak spot foto kece dengan latar belakang alam yang megah.",
            "Sangat puas berkunjung ke sini bersama rombongan teman kantor. Areanya luas dan udaranya segar tiada duanya.",
            "Luar biasa indah! Pengalaman liburan yang sangat berkesan. Anak-anak dan orang tua semua senang berkunjung ke sini.",
            "Wisata alam yang wajib masuk daftar kunjungan kalau ke Sukabumi. Tiket masuk ramah di kantong dengan panorama kelas dunia.",
            "Suasana tenang dan damai, sangat cocok untuk quality time bareng pasangan. Sunset dan udaranya bikin nyaman.",
            "Pengelolaannya cukup rapi dan kebersihannya terjaga. Jangan lupa bawa kamera karena setiap sudutnya sangat fotogenik.",
            "Keren banget! Pemandangannya bener-bener memanjakan mata. Pasti bakal balik lagi ke sini kalau liburan ke Sukabumi.",
            "Pengalaman pertama kali ke sini dan langsung terkesima. Alamnya masih sangat terjaga dan sejuk.",
            "Lokasinya nyaman untuk bersantai santai sambil menikmati bekal. Sangat direkomendasikan untuk wisatawan keluarga.",
            "Pemandangan spektakuler! Sangat beruntung bisa menikmati keindahan alam Sukabumi yang seindah ini.",
            "Tempat yang sangat worth it untuk dikunjungi. Udara bersih, pemandangan hijau membentang, dan suasananya damai.",
            "Gak pernah bosen datang ke sini. Selalu ada rasa tenang dan takjub setiap kali menikmati keindahan alamnya."
        ];

        $reviewsPoolCurug = [
            "Curugnya bener-bener luar biasa indah! Airnya sangat dingin, jernih, dan segar. Jalur trekking ke bawah agak licin, jadi disarankan pakai sepatu yang nyaman.",
            "Suasananya sangat asri dan menenangkan. Suara gemuruh air terjun bikin pikiran jadi plong dan rileks. Kopi hangat di warung sekitar bikin suasana makin mantap.",
            "Pemandangan alam air terjun yang memukau. Spot foto di dekat bebatuan curug sangat estetik. Jangan lupa bawa baju ganti kalau ke sini!",
            "Salah satu air terjun terbaik di kawasan Sukabumi. Wajib dikunjungi kalau butuh healing sejati. Trekking sedikit tapi sangat sebanding dengan pemandangannya.",
            "Treknya cukup menantang dan seru, begitu sampai di depan curug rasanya semua lelah langsung hilang. Airnya segar banget!",
            "Curug yang masih sangat asri dan alami. Percikan airnya bikin sejuk sampai ke hati. Sangat direkomendasikan untuk pecinta wisata alam petualangan."
        ];

        $reviewsPoolPantai = [
            "Pantainya luas dengan pasir yang bersih. Deburan ombak khas pantai selatan sangat megah dan menenangkan. Pemandangan sunset di sore hari luar biasa memukau!",
            "Tempat yang pas banget buat santai sambil menikmati es kelapa muda di pinggir pantai. Angin sepoi-sepoi dan suasananya bikin betah berlama-lama.",
            "Pemandangan laut lepas yang sangat indah. Suasana senja di sini magis banget, cocok banget buat hunting foto siluet.",
            "Garis pantainya panjang dan area parkirnya cukup leluasa. Tempat yang asyik buat liburan bareng keluarga besar.",
            "Ombaknya bagus dan pemandangan tebing karang di sekitarnya sangat eksotis. Salah satu pantai favorit di Sukabumi!"
        ];

        $visitTypes = ['Keluarga', 'Pasangan', 'Teman', 'Solo'];

        // 3. Populate Reviews for each Place
        $places = Place::all();
        $this->command->info("Menambahkan ulasan dummy untuk {$places->count()} destinasi wisata...");

        $totalReviewsAdded = 0;

        foreach ($places as $place) {
            // Check how many reviews to add (15 to 20 reviews per destination)
            $reviewsTarget = rand(15, 20);
            
            // Shuffle users to pick unique reviewers for this place
            $shuffledUsers = $users;
            shuffle($shuffledUsers);
            $selectedUsers = array_slice($shuffledUsers, 0, $reviewsTarget);

            // Determine appropriate review bank based on category or place name
            $nameLower = strtolower($place->name . ' ' . $place->description);
            if (str_contains($nameLower, 'curug') || str_contains($nameLower, 'air terjun')) {
                $pool = array_merge($reviewsPoolCurug, $reviewsPoolGeneral);
            } elseif (str_contains($nameLower, 'pantai') || str_contains($nameLower, 'laut') || str_contains($nameLower, 'ujung genteng') || str_contains($nameLower, 'pelabuhan')) {
                $pool = array_merge($reviewsPoolPantai, $reviewsPoolGeneral);
            } else {
                $pool = $reviewsPoolGeneral;
            }

            foreach ($selectedUsers as $user) {
                // Check if user already reviewed this place
                $alreadyExists = Review::where('user_id', $user->id)
                    ->where('place_id', $place->id)
                    ->exists();

                if ($alreadyExists) {
                    continue;
                }

                // 90% chance of 5 stars, 10% chance of 4 stars
                $rating = (rand(1, 10) <= 9) ? 5 : 4;
                $content = $pool[array_rand($pool)];
                $visitType = $visitTypes[array_rand($visitTypes)];

                // Spread created_at over the last 150 days
                $createdAt = Carbon::now()->subDays(rand(1, 150))->subHours(rand(1, 23))->subMinutes(rand(1, 59));

                Review::create([
                    'user_id'    => $user->id,
                    'place_id'   => $place->id,
                    'event_id'   => null,
                    'rating'     => $rating,
                    'content'    => $content,
                    'visit_type' => $visitType,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                $totalReviewsAdded++;
            }
        }

        // 4. Populate Reviews for each Event as well (8 to 12 reviews per event)
        $events = Event::all();
        $this->command->info("Menambahkan ulasan dummy untuk {$events->count()} event & festival...");

        $eventReviewsPool = [
            "Acaranya seru banget dan tertata rapi! Penampilan budayanya sangat memukau dan menghibur warga maupun wisatawan luar kota.",
            "Festival yang sangat luar biasa untuk melestarikan kebudayaan lokal Sukabumi. Semoga tahun depan diadakan lagi dengan skala yang lebih meriah!",
            "Sangat berkesan bisa hadir di event ini bareng keluarga. Panggungnya megah, stand kulinernya lengkap, dan suasanya sangat hidup.",
            "Event yang keren abis! Pengalaman pertama ikut dan langsung takjub dengan antusiasme masyarakat serta atraksi yang disajikan.",
            "Banyak spot foto menarik dan penampilan seni tradisionalnya bikin bangga. Acara wajib yang patut terus didukung.",
            "Tertib, seru, dan edukatif banget buat anak-anak mengenal tradisi dan budaya lokal. Mantap Visit Sukabumi!"
        ];

        foreach ($events as $event) {
            $shuffledUsers = $users;
            shuffle($shuffledUsers);
            $selectedUsers = array_slice($shuffledUsers, 0, rand(8, 12));

            foreach ($selectedUsers as $user) {
                $alreadyExists = Review::where('user_id', $user->id)
                    ->where('event_id', $event->id)
                    ->exists();

                if ($alreadyExists) {
                    continue;
                }

                $rating = (rand(1, 10) <= 9) ? 5 : 4;
                $content = $eventReviewsPool[array_rand($eventReviewsPool)];
                $visitType = $visitTypes[array_rand($visitTypes)];
                $createdAt = Carbon::now()->subDays(rand(1, 120))->subHours(rand(1, 23))->subMinutes(rand(1, 59));

                Review::create([
                    'user_id'    => $user->id,
                    'place_id'   => null,
                    'event_id'   => $event->id,
                    'rating'     => $rating,
                    'content'    => $content,
                    'visit_type' => $visitType,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                $totalReviewsAdded++;
            }
        }

        $this->command->info("Selesai! Berhasil menambahkan {$totalReviewsAdded} ulasan dengan akun dummy Indonesia yang sangat realistis.");
    }
}
