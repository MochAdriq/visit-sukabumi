<?php

namespace Database\Seeders;

use App\Models\RkudAccount;
use App\Models\TaxSetting;
use Illuminate\Database\Seeder;

class TaxSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'category' => 'hotel',
                'name' => 'PBJT Jasa Perhotelan',
                'rate_percent' => 10.00,
                'is_active' => true,
                'description' => 'Pajak Barang dan Jasa Tertentu (PBJT) atas penyediaan akomodasi perhotelan sesuai UU HKPD No. 1 Tahun 2022.',
            ],
            [
                'category' => 'event',
                'name' => 'PBJT Kesenian dan Hiburan',
                'rate_percent' => 10.00,
                'is_active' => true,
                'description' => 'Pajak Barang dan Jasa Tertentu (PBJT) atas penyelenggaraan festival, konser musik, dan pameran kesenian.',
            ],
            [
                'category' => 'attraction',
                'name' => 'PBJT Wisata dan Rekreasi',
                'rate_percent' => 10.00,
                'is_active' => true,
                'description' => 'Pajak Barang dan Jasa Tertentu (PBJT) atas tiket masuk wahana rekreasi dan daya tarik wisata.',
            ],
        ];

        foreach ($settings as $setting) {
            TaxSetting::updateOrCreate(
                ['category' => $setting['category']],
                $setting
            );
        }

        // Rekening Kas Umum Daerah (RKUD) Default
        RkudAccount::firstOrCreate(
            ['account_number' => '0012345678901'],
            [
                'bank_name' => 'Bank BJB',
                'account_holder_name' => 'KAS DAERAH KABUPATEN SUKABUMI',
                'agency_name' => 'Badan Pendapatan Daerah (Bapenda) Kabupaten Sukabumi',
                'is_active' => true,
            ]
        );
    }
}
