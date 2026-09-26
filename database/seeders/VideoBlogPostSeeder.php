<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class VideoBlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();

        $videos = [
            [
                'title' => 'Eksplorasi Keindahan Geopark Ciletuh UNESCO Global Geopark',
                'slug' => 'eksplorasi-keindahan-geopark-ciletuh',
                'category' => 'Video',
                'youtube_url' => 'https://www.youtube.com/watch?v=kYJvS_8C6wM',
                'content' => '<p>Dokumentasi visual lanskap batuan purba, air terjun eksotis, dan pesona teluk Ciletuh di pesisir selatan Sukabumi yang diakui sebagai warisan dunia UNESCO.</p>',
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'title' => 'Sensasi Melintasi Jembatan Gantung Situ Gunung Sukabumi',
                'slug' => 'sensasi-melintasi-jembatan-gantung-situ-gunung',
                'category' => 'Video',
                'youtube_url' => 'https://www.youtube.com/watch?v=w7T046E5v7U',
                'content' => '<p>Pengalaman sinematik menyeberangi jembatan gantung terpanjang di Asia Tenggara yang membentang di tengah kanopi hutan tropis Gunung Gede Pangrango.</p>',
                'status' => 'published',
                'published_at' => now()->subHours(2),
            ],
            [
                'title' => 'Pesona Gemuruh Tiga Curug Kembar Cikaso Sukabumi',
                'slug' => 'pesona-gemuruh-tiga-curug-kembar-cikaso',
                'category' => 'Video',
                'youtube_url' => 'https://www.youtube.com/watch?v=M7FIvfx5J10',
                'content' => '<p>Penjelajahan menyusuri sungai menggunakan perahu tradisional menuju kemegahan tiga curug kembar Cikaso dengan air toska yang memukau mata.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(1),
            ],
        ];

        foreach ($videos as $videoData) {
            $videoData['author_id'] = $admin?->id;
            BlogPost::updateOrCreate(
                ['slug' => $videoData['slug']],
                $videoData
            );
        }
    }
}
