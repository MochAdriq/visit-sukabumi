<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        $videos = [
            [
                'title'       => 'GEOPARK CILETUH: Mahakarya Alam Sukabumi yang Mendunia (UNESCO Global Geopark)',
                'youtube_url' => 'https://www.youtube.com/watch?v=e6w341q3g-k',
                'category'    => 'Wisata Alam',
                'description' => 'Dokumentasi visual sinematik menjelajahi keindahan batuan purba, hamparan tebing amfiteater, dan air terjun megah di Geopark Ciletuh Sukabumi yang diakui dunia.',
                'duration'    => '11:42',
                'is_featured' => true,
                'sort_order'  => 1,
                'is_active'   => true,
            ],
            [
                'title'       => 'Sensasi Berjalan di Atas Awan: Jembatan Gantung Situ Gunung Suspension Bridge',
                'youtube_url' => 'https://www.youtube.com/watch?v=4Jq_Bv8_Z9U',
                'category'    => 'Wisata Alam',
                'description' => 'Eksplorasi jembatan gantung terpanjang di Asia Tenggara yang membelah kanopi hutan tropis Gunung Gede Pangrango.',
                'duration'    => '06:15',
                'is_featured' => true,
                'sort_order'  => 2,
                'is_active'   => true,
            ],
            [
                'title'       => 'Jelajah Jalur Eksotis Pesisir Pantai & Panorama Alam Sukabumi Selatan',
                'youtube_url' => 'https://www.youtube.com/watch?v=Nn1w-XJvX1I',
                'category'    => 'Wisata Alam',
                'description' => 'Perjalanan menembus jalan berliku berlatar samudra Hindia biru dan perbukitan hijau asri di Sukabumi Selatan.',
                'duration'    => '08:30',
                'is_featured' => true,
                'sort_order'  => 3,
                'is_active'   => true,
            ],
            [
                'title'       => 'Pesona Puncak Panenjoan Ciletuh: Lanskap Tebing Purba Jutaan Tahun',
                'youtube_url' => 'https://www.youtube.com/watch?v=0h9V6N8z584',
                'category'    => 'Wisata Alam',
                'description' => 'Melihat bentang alam amfiteater raksasa Ciletuh dari titik pandang tertinggi Puncak Panenjoan yang memukau mata.',
                'duration'    => '05:18',
                'is_featured' => true,
                'sort_order'  => 4,
                'is_active'   => true,
            ],
            [
                'title'       => 'Review Lengkap Jalur Hijau Wisata Alam & Curug Sawer Kadudampit',
                'youtube_url' => 'https://www.youtube.com/watch?v=Gk6Wl65f_1c',
                'category'    => 'Dokumentasi',
                'description' => 'Panduan visual perjalanan lengkap menyusuri kawasan konservasi Situ Gunung hingga gemuruh segar Curug Sawer.',
                'duration'    => '14:20',
                'is_featured' => false,
                'sort_order'  => 5,
                'is_active'   => true,
            ],
            [
                'title'       => 'Pesona Alam Purba Geopark Ciletuh Sukabumi (4K Ultra Cinematic)',
                'youtube_url' => 'https://www.youtube.com/watch?v=k5q4oD9S8t0',
                'category'    => 'Dokumentasi',
                'description' => 'Visual sinematik 4K menyajikan pesona eksotis air terjun Cimarinjung, tebing sodong, dan pantai Palangpang.',
                'duration'    => '07:45',
                'is_featured' => false,
                'sort_order'  => 6,
                'is_active'   => true,
            ],
        ];

        foreach ($videos as $video) {
            Video::updateOrCreate(
                ['youtube_url' => $video['youtube_url']],
                $video
            );
        }
    }
}
