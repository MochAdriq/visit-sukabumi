<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Utama Boss Moch Fadillah
        User::updateOrCreate(
            ['email' => 'mochfadillah1208@gmail.com'],
            [
                'name'              => 'Moch Fadillah',
                'password'          => Hash::make('admin123'),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Akun Admin Tambahan
        User::updateOrCreate(
            ['email' => 'visitsukabumidotcom@gmail.com'],
            [
                'name'              => 'Visit Sukabumi Admin',
                'password'          => Hash::make('admin123'),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
