<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            // ── TIPE: activity (Apa yang Bisa Dilakukan) ─────────────
            [
                'name'        => 'Pacu Adrenalin',
                'slug'        => 'pacu-adrenalin',
                'type'        => 'activity',
                'description' => 'Tantang diri Anda dengan aktivitas ekstrem dan petualangan seru di Sukabumi — rafting, arung jeram, ATV, hingga cliff jumping.',
                'icon_svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Hiking & Trekking',
                'slug'        => 'hiking-trekking',
                'type'        => 'activity',
                'description' => 'Jelajahi jalur pendakian dan trekking terbaik Sukabumi — dari hutan tropis hingga puncak gunung yang memukau.',
                'icon_svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"/>',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Sukabumi untuk Anak',
                'slug'        => 'sukabumi-untuk-anak',
                'type'        => 'activity',
                'description' => 'Destinasi dan aktivitas ramah anak yang seru, aman, dan penuh edukasi untuk liburan keluarga tak terlupakan.',
                'icon_svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Kuliner & Makanan',
                'slug'        => 'kuliner-makanan',
                'type'        => 'activity',
                'description' => 'Cicipi cita rasa autentik Sukabumi — dari jajanan tradisional, restoran seafood pinggir pantai, hingga kafe estetik.',
                'icon_svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                'sort_order'  => 4,
            ],
            [
                'name'        => 'Budaya & Sejarah',
                'slug'        => 'budaya-sejarah',
                'type'        => 'activity',
                'description' => 'Kenali warisan budaya, situs bersejarah, dan kekayaan tradisi yang tersimpan di setiap sudut Sukabumi.',
                'icon_svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
                'sort_order'  => 5,
            ],
            [
                'name'        => 'Santai & Healing',
                'slug'        => 'santai-healing',
                'type'        => 'activity',
                'description' => 'Lepaskan penat dan nikmati ketenangan alam, glamping, spa, dan kafe tepi sungai yang menyejukkan jiwa.',
                'icon_svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
                'sort_order'  => 6,
            ],
            [
                'name'        => 'Pendidikan & Edu Wisata',
                'slug'        => 'eduwisata',
                'type'        => 'activity',
                'description' => 'Belajar sambil berwisata — kunjungi pusat konservasi, kebun edukasi, museum, dan tempat riset ilmu pengetahuan.',
                'icon_svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 7v-6m0 0l-3.5-2M12 15l3.5-2"/>',
                'sort_order'  => 7,
            ],
            [
                'name'        => 'Belanja Oleh-Oleh',
                'slug'        => 'belanja-oleh-oleh',
                'type'        => 'activity',
                'description' => 'Bawa pulang kenangan terbaik Sukabumi — mulai dari kerajinan tangan, makanan khas, batik, hingga souvenir unik.',
                'icon_svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>',
                'sort_order'  => 8,
            ],

            // ── TIPE: wisata (menu Wisata) ────────────────────────────
            [
                'name'        => 'Wisata Alam',
                'slug'        => 'wisata-alam',
                'type'        => 'wisata',
                'description' => 'Curug, hutan, gunung, sungai, dan keajaiban alam Sukabumi yang memukau — siap memanjakan mata dan jiwa petualang.',
                'icon_svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l7 4 7-4M5 3v10l7 4 7-4V3"/>',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Wisata Pantai',
                'slug'        => 'wisata-pantai',
                'type'        => 'wisata',
                'description' => 'Garis pantai selatan Sukabumi yang memukau — ombak bergelora, pasir putih, tebing dramatis, dan matahari terbenam memesona.',
                'icon_svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Wisata Spiritual',
                'slug'        => 'wisata-spiritual',
                'type'        => 'wisata',
                'description' => 'Temukan ketenangan batin di situs ziarah, pesantren bersejarah, makam keramat, dan tempat meditasi yang sakral di Sukabumi.',
                'icon_svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
                'sort_order'  => 3,
            ],
        ];

        foreach ($tags as $tagData) {
            Tag::updateOrCreate(
                ['slug' => $tagData['slug']],
                $tagData
            );
        }

        $this->command->info('✅ Tag seeder selesai — ' . count($tags) . ' tag berhasil di-seed.');
    }
}
