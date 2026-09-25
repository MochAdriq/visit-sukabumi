<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Top Navbar Ribbon (Landscape - Horizontal)
        Advertisement::updateOrCreate(
            ['position' => 'top_navbar'],
            [
                'title' => 'Festival Geopark Ciletuh 2026 — Dapatkan Tiket Early Bird Spesial Sekarang!',
                'format' => 'landscape',
                'image_path' => 'images/ads/visit_sukabumi_animation.jpg',
                'url' => '/event',
                'target_pages' => ['all'],
                'sort_order' => 1,
                'open_in_new_tab' => false,
                'is_active' => true,
            ]
        );

        // 2. Homepage Middle Banner (Landscape - Horizontal)
        Advertisement::updateOrCreate(
            ['position' => 'homepage_middle'],
            [
                'title' => 'Eksplorasi Keindahan Alam Sukabumi — Sepetak Tanah Surga Di Selatan Jawa Barat',
                'format' => 'landscape',
                'image_path' => 'images/ads/visit_sukabumi_animation.jpg',
                'url' => '/jelajahsukabumi',
                'target_pages' => ['home'],
                'sort_order' => 1,
                'open_in_new_tab' => false,
                'is_active' => true,
            ]
        );

        // 3. Place Detail Sidebar (PORTRAIT - Vertikal)
        Advertisement::updateOrCreate(
            ['position' => 'place_sidebar'],
            [
                'title' => 'Sewa Glamping & Villa Nyaman Dekat Destinasi Wisata Favorit',
                'format' => 'portrait',
                'image_path' => 'images/ads/banner-1.jpg',
                'url' => '/penginapan',
                'target_pages' => ['places'],
                'sort_order' => 1,
                'open_in_new_tab' => false,
                'is_active' => true,
            ]
        );

        // 4. Pre-Footer Banner (Landscape - Horizontal)
        Advertisement::updateOrCreate(
            ['position' => 'footer_banner'],
            [
                'title' => 'Jelajahi Pesona Sukabumi Bersama Mitra Penginapan & Transportasi Resmi',
                'format' => 'landscape',
                'image_path' => 'images/ads/visit_sukabumi_animation.jpg',
                'url' => '/wisata',
                'target_pages' => ['all'],
                'sort_order' => 1,
                'open_in_new_tab' => false,
                'is_active' => true,
            ]
        );

        // 5. In-Article Banner (Landscape - Horizontal)
        Advertisement::updateOrCreate(
            ['position' => 'article_middle'],
            [
                'title' => 'Petualangan Seru Arung Jeram Sungai Citarik — Promo Paket Weekend Hemat',
                'format' => 'landscape',
                'image_path' => 'images/ads/visit_sukabumi_animation.jpg',
                'url' => '/wisata',
                'target_pages' => ['blog'],
                'sort_order' => 1,
                'open_in_new_tab' => false,
                'is_active' => true,
            ]
        );

        // 6. Floating Corner Widget
        Advertisement::updateOrCreate(
            ['position' => 'floating_corner'],
            [
                'title' => 'Diskon Spesial Resort Tepi Pantai Palabuhanratu s/d 30%',
                'format' => 'landscape',
                'image_path' => 'images/ads/visit_sukabumi_animation.jpg',
                'url' => '/penginapan',
                'target_pages' => ['home', 'places'],
                'sort_order' => 1,
                'open_in_new_tab' => false,
                'is_active' => true,
            ]
        );

        // 7. Popup Interstitial Modal
        Advertisement::updateOrCreate(
            ['position' => 'popup_interstitial'],
            [
                'title' => 'Jelajah Sukabumi Interaktif — Rasakan Sensasi Menyetir Virtual!',
                'format' => 'landscape',
                'image_path' => 'images/ads/adsvis.gif',
                'url' => '/jelajahsukabumi',
                'target_pages' => ['home'],
                'sort_order' => 1,
                'open_in_new_tab' => false,
                'is_active' => true,
            ]
        );
    }
}
