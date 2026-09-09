<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $categories = [
            ['name' => 'Wisata Alam',    'slug' => 'wisata-alam',    'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Wisata Pantai',  'slug' => 'wisata-pantai',  'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kuliner',        'slug' => 'kuliner',        'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Hotel & Resort', 'slug' => 'hotel-resort',   'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Aktivitas Seru', 'slug' => 'aktivitas-seru', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Wisata Budaya',  'slug' => 'wisata-budaya',  'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('categories')->insertOrIgnore($categories);
        
        $this->command->info('Kategori Master berhasil di-seed!');
    }
}
