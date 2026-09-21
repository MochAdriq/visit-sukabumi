<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DinasUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'dinas@sukabumi.go.id'],
            [
                'name' => 'Bapenda Pemkab Sukabumi',
                'password' => Hash::make('dinas123'),
                'role' => 'dinas',
                'phone' => '0266221133',
                'bio' => 'Akun Resmi Badan Pendapatan Daerah (Bapenda) Pemerintah Kabupaten Sukabumi.',
            ]
        );
    }
}
