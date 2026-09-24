<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Top Navbar Ribbon (Muncul di ribbon paling atas situs)
        Advertisement::updateOrCreate(
            ['position' => 'top_navbar'],
            [
                'title' => 'Festival Geopark Ciletuh 2026 — Dapatkan Tiket Early Bird Spesial Sekarang!',
                'image_path' => 'images/ads/banner-1.jpg',
                'url' => '/event',
                'target_pages' => ['all'],
                'sort_order' => 1,
                'open_in_new_tab' => false,
                'is_active' => true,
            ]
        );

        // 2. Homepage Middle Banner (Banner promo utama di tengah beranda)
        Advertisement::updateOrCreate(
            ['position' => 'homepage_middle'],
            [
                'title' => 'Eksplorasi Keindahan Alam Sukabumi — Sepetak Tanah Surga Di Selatan Jawa Barat',
                'image_path' => 'images/ads/visit_sukabumi_animation.jpg',
                'url' => '/jelajahsukabumi',
                'target_pages' => ['home'],
                'sort_order' => 1,
                'open_in_new_tab' => false,
                'is_active' => true,
            ]
        );

        // 3. Place Detail Sidebar (Sidebar kanan di halaman detail objek wisata)
        Advertisement::updateOrCreate(
            ['position' => 'place_sidebar'],
            [
                'title' => 'Sewa Glamping & Villa Nyaman Dekat Destinasi Wisata Favorit',
                'image_path' => 'images/ads/banner-1.jpg',
                'url' => '/penginapan',
                'target_pages' => ['places'],
                'sort_order' => 1,
                'open_in_new_tab' => false,
                'is_active' => true,
            ]
        );

        // 4. Pre-Footer Banner (Strip horizontal sebelum footer di semua halaman)
        Advertisement::updateOrCreate(
            ['position' => 'footer_banner'],
            [
                'title' => 'Jelajahi Pesona Sukabumi Bersama Mitra Penginapan & Transportasi Resmi',
                'image_path' => 'images/ads/visit_sukabumi_animation.jpg',
                'url' => '/wisata',
                'target_pages' => ['all'],
                'sort_order' => 1,
                'open_in_new_tab' => false,
                'is_active' => true,
            ]
        );

        // 5. In-Article Banner (Tengah Paragraf Artikel Blog)
        Advertisement::updateOrCreate(
            ['position' => 'article_middle'],
            [
                'title' => 'Petualangan Seru Arung Jeram Sungai Citarik — Promo Paket Weekend Hemat',
                'image_path' => 'images/dummy-beach.jpg',
                'url' => '/wisata',
                'target_pages' => ['blog'],
                'sort_order' => 1,
                'open_in_new_tab' => false,
                'is_active' => true,
            ]
        );

        // 6. Floating Corner Widget (Pojok Kanan Bawah)
        Advertisement::updateOrCreate(
            ['position' => 'floating_corner'],
            [
                'title' => 'Diskon Spesial Resort Tepi Pantai Palabuhanratu s/d 30%',
                'image_path' => 'images/dummy-beach.jpg',
                'url' => '/penginapan',
                'target_pages' => ['home', 'places'],
                'sort_order' => 1,
                'open_in_new_tab' => false,
                'is_active' => true,
            ]
        );

        // 7. Popup Interstitial Modal (Promo Sambutan)
        Advertisement::updateOrCreate(
            ['position' => 'popup_interstitial'],
            [
                'title' => 'Jelajah Sukabumi Interaktif — Rasakan Sensasi Menyetir Virtual!',
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
