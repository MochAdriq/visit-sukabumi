<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun admin utama (Super Admin)
        \App\Models\User::updateOrCreate(
            ['email' => 'visitsukabumidotcom@gmail.com'],
            [
                'name' => 'Visit Sukabumi Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Seed master tags & admin users
        $this->call([
            AdminUserSeeder::class,
            TagSeeder::class,
        ]);

        // Hapus komentar di bawah jika ingin men-seed data destinasi dan event secara otomatis:
        // $this->call([
        //     VisitSukabumiSeeder::class,
        //     EventAndTicketSeeder::class,
        // ]);
    }
}
