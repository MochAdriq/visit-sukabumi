<?php
$user = \App\Models\User::first() ?? \App\Models\User::factory()->create();
\App\Models\BlogPost::create([
    'title' => 'Panduan Lengkap Wisata ke Pelabuhan Ratu',
    'slug' => 'panduan-lengkap-wisata-ke-pelabuhan-ratu',
    'content' => '<h2>Mengenal Pelabuhan Ratu</h2><p>Pelabuhan Ratu adalah salah satu destinasi wisata paling terkenal di Sukabumi...</p><p>Pastikan Anda membawa tabir surya dan kacamata hitam.</p>',
    'author_id' => $user->id,
    'category' => 'Panduan Wisata',
    'status' => 'published',
    'published_at' => now(),
]);
\App\Models\BlogPost::create([
    'title' => '5 Makanan Khas Sukabumi yang Wajib Dicoba',
    'slug' => '5-makanan-khas-sukabumi',
    'content' => '<h2>Kuliner Sukabumi</h2><p>Saat berkunjung ke Sukabumi, jangan lupa mencicipi Mochi, Bubur Ayam Bunut, dan lainnya...</p>',
    'author_id' => $user->id,
    'category' => 'Kuliner',
    'status' => 'published',
    'published_at' => now()->subDays(2),
]);
\App\Models\BlogPost::create([
    'title' => 'Tips Aman Mendaki Gunung Gede Pangrango',
    'slug' => 'tips-aman-mendaki-gunung-gede',
    'content' => '<h2>Persiapan Mendaki</h2><p>Bagi pemula, mendaki Gunung Gede memerlukan persiapan matang...</p><ul><li>Bawa perlengkapan lengkap</li><li>Jaga kondisi fisik</li></ul>',
    'author_id' => $user->id,
    'category' => 'Tips & Trik',
    'status' => 'published',
    'published_at' => now()->subDays(5),
]);
echo "Dummy blog posts created successfully!\n";
