<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Place;
use App\Models\PlaceImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImportCurugPlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Dapatkan atau buat Kategori Wisata Alam
        $category = Category::firstOrCreate(
            ['slug' => 'wisata-alam'],
            ['name' => 'Wisata Alam']
        );

        // 2. Siapkan file dummy image ke storage/app/public/places/dummy-curug.webp
        $dummySource = public_path('images/dummy-curug.webp');
        $dummyDestPath = 'places/dummy-curug.webp';

        if (File::exists($dummySource)) {
            if (!Storage::disk('public')->exists('places')) {
                Storage::disk('public')->makeDirectory('places');
            }
            Storage::disk('public')->put($dummyDestPath, File::get($dummySource));
        }

        // 3. Daftar 5 Destinasi Curug dari file Excel
        $curugPlaces = [
            [
                'name' => 'Curug Cikaso',
                'slug' => 'curug-cikaso',
                'district' => 'Cibitung',
                'address' => 'Desa Ciniti, Kec. Cibitung, Kab. Sukabumi, Jawa Barat',
                'latitude' => -7.36015000,
                'longitude' => 106.61868000,
                'price' => 10000,
                'open_hours' => '06.00 - 17.00 WIB',
                'duration' => '2-3 Jam',
                'ticket_info' => 'Tiket masuk Rp10.000 / Tersedia sewa perahu',
                'description' => "Terletak di Desa Ciniti, Kecamatan Cibitung, kawasan Sukabumi Selatan. Dikelilingi pepohonan hijau dan tebing batu yang jauh dari suasana perkotaan.\n\nMemiliki keunikan tiga aliran air terjun yang jatuh berdampingan dan bermuara pada kolam alami di bawahnya, sangat cocok untuk fotografi dan wisata alam.",
            ],
            [
                'name' => 'Curug Cimarinjung',
                'slug' => 'curug-cimarinjung',
                'district' => 'Ciemas',
                'address' => 'Desa Ciwaru, Kec. Ciemas, Kawasan Geopark Ciletuh, Kab. Sukabumi, Jawa Barat',
                'latitude' => -7.16870000,
                'longitude' => 106.49650000,
                'price' => 5000,
                'open_hours' => '07.00 - 17.00 WIB',
                'duration' => '1-2 Jam',
                'ticket_info' => 'Retribusi kawasan Geopark Ciletuh',
                'description' => "Berada di Desa Ciwaru, Kecamatan Ciemas. Merupakan bagian dari kawasan Geopark Ciletuh dengan bentang alam alami tebing batu dan vegetasi hijau.\n\nMenawarkan perpaduan eksotis antara air terjun, formasi batuan purba, dan lanskap perbukitan. Menghadirkan suasana tenang untuk relaksasi.",
            ],
            [
                'name' => 'Curug Sodong',
                'slug' => 'curug-sodong',
                'district' => 'Ciemas',
                'address' => 'Desa Ciwaru, Kec. Ciemas, Kawasan Geopark Ciletuh, Kab. Sukabumi, Jawa Barat',
                'latitude' => -7.17550000,
                'longitude' => 106.50250000,
                'price' => 5000,
                'open_hours' => '07.00 - 17.00 WIB',
                'duration' => '1-2 Jam',
                'ticket_info' => 'Tiket terusan kawasan Geopark',
                'description' => "Terletak di Desa Ciwaru, Kecamatan Ciemas, merupakan destinasi yang berada di jantung Ciletuh-Palabuhanratu UNESCO Global Geopark.\n\nAir terjun mengalir di tengah tebing batu dengan debit yang deras. Selain indah, tempat ini menyuguhkan wisata alam yang memiliki nilai sejarah geologi tinggi.",
            ],
            [
                'name' => 'Curug Awang',
                'slug' => 'curug-awang',
                'district' => 'Ciemas',
                'address' => 'Desa Tamanjaya, Kec. Ciemas, Kawasan Geopark Ciletuh, Kab. Sukabumi, Jawa Barat',
                'latitude' => -7.21830000,
                'longitude' => 106.53670000,
                'price' => 5000,
                'open_hours' => '07.00 - 17.00 WIB',
                'duration' => '1-2 Jam',
                'ticket_info' => 'Tiket kawasan Geopark Ciletuh (Niagara mini Sukabumi)',
                'description' => "Berlokasi di Desa Tamanjaya, Kecamatan Ciemas. Menjadi bagian dari kawasan Ciletuh Amphitheatre yang terbentuk dari aktivitas tektonik laut purba.\n\nMenawarkan pesona aliran air yang jatuh memanjang melewati tebing batu kecokelatan yang khas, berpadu indah dengan rimbunnya vegetasi hijau di sekitarnya.",
            ],
            [
                'name' => 'Curug Sawer',
                'slug' => 'curug-sawer',
                'district' => 'Kadudampit',
                'address' => 'Kawasan Wisata Situ Gunung, Desa Sukamanis, Kec. Kadudampit, Kab. Sukabumi, Jawa Barat',
                'latitude' => -6.83350000,
                'longitude' => 106.92480000,
                'price' => 15000,
                'open_hours' => '07.00 - 17.00 WIB',
                'duration' => '2-3 Jam',
                'ticket_info' => 'Tiket kawasan Situ Gunung / Dekat Jembatan Gantung',
                'description' => "Berada di dalam kawasan wisata Situgunung, Kecamatan Kadudampit. Tersembunyi di tengah lingkungan hutan pegunungan yang sangat asri dan sejuk.\n\nAliran airnya cukup deras dan jatuh ke sungai berbatu di bawahnya. Perjalanan menuju curug ini memberikan pengalaman menyusuri alam hutan yang menyegarkan.",
            ],
        ];

        foreach ($curugPlaces as $data) {
            $place = Place::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'category_id' => $category->id,
                    'name' => $data['name'],
                    'status' => 'published',
                    'district' => $data['district'],
                    'address' => $data['address'],
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'price' => $data['price'],
                    'open_hours' => $data['open_hours'],
                    'duration' => $data['duration'],
                    'ticket_info' => $data['ticket_info'],
                    'description' => $data['description'],
                    'has_ticket' => false,
                    'has_accommodation' => false,
                    'has_restaurant' => false,
                    'has_tour_package' => false,
                    'has_accessibility_warning' => false,
                ]
            );

            // Jika belum ada foto pada destinasi ini, pasangkan foto dummy curug
            if ($place->placeImages()->count() === 0) {
                PlaceImage::create([
                    'place_id' => $place->id,
                    'image_path' => $dummyDestPath,
                    'is_primary' => true,
                ]);
            }
        }

        $this->command->info('Berhasil mengimpor 5 destinasi Curug Sukabumi ke kategori Wisata Alam.');
    }
}
