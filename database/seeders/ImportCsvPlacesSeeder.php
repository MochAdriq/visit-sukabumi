<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Place;
use App\Models\PlaceImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImportCsvPlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Dapatkan atau buat Kategori Wisata Pantai
        $category = Category::firstOrCreate(
            ['slug' => 'wisata-pantai'],
            ['name' => 'Wisata Pantai']
        );

        // 2. Siapkan file dummy image ke storage/app/public/places/dummy-pantai.jpg
        $dummySource = public_path('images/dummy-beach.jpg');
        $dummyDestPath = 'places/dummy-pantai.jpg';

        if (File::exists($dummySource)) {
            if (!Storage::disk('public')->exists('places')) {
                Storage::disk('public')->makeDirectory('places');
            }
            Storage::disk('public')->put($dummyDestPath, File::get($dummySource));
        }

        // 3. Daftar 6 Destinasi dari CSV
        $places = [
            [
                'name' => 'Pantai Istana Presiden',
                'slug' => 'pantai-istana-presiden',
                'district' => 'Palabuhanratu',
                'address' => 'Kawasan Citepus, Kec. Palabuhanratu, Kab. Sukabumi, Jawa Barat',
                'latitude' => -6.97450000,
                'longitude' => 106.53120000,
                'price' => 0,
                'open_hours' => 'Buka 24 Jam',
                'duration' => '2-3 Jam',
                'ticket_info' => 'Gratis / Parkir tersedia',
                'description' => "Menikmati Pesona Pesisir Citepus dengan Nuansa Sejarah\n\nDi sepanjang garis pantai selatan Kabupaten Sukabumi, terdapat banyak tempat yang menawarkan panorama laut dengan karakter masing-masing. Salah satunya adalah Pantai Istana Presiden, yang berada di kawasan Citepus, Palabuhanratu. Destinasi ini menjadi bagian dari lanskap wisata pesisir Palabuhanratu yang sejak lama dikenal sebagai salah satu kawasan wisata unggulan di Kabupaten Sukabumi.\n\nMenghadap langsung ke Samudra Hindia, Pantai Istana Presiden menawarkan pengalaman menikmati bentang laut yang luas dengan suasana khas pesisir selatan. Hamparan pantai, suara deburan ombak, angin laut, serta aktivitas masyarakat di kawasan sekitarnya membentuk pengalaman yang sederhana tetapi berkesan.\n\nNama destinasi ini juga memberikan nuansa tersendiri. Keberadaan kawasan kepresidenan di Palabuhanratu telah menjadi bagian dari sejarah perkembangan kawasan tersebut. Karena itu, kunjungan ke Pantai Istana Presiden dapat menjadi kesempatan untuk menikmati keindahan alam sekaligus mengenal sedikit jejak sejarah yang melekat pada kawasan Palabuhanratu.\n\nMenikmati Luasnya Samudra Hindia:\nHal pertama yang akan dirasakan ketika berada di Pantai Istana Presiden adalah luasnya pandangan ke arah laut. Tidak banyak penghalang yang membatasi pandangan sehingga wisatawan dapat merasakan karakter laut selatan yang terbuka dan luas.\nHamparan Samudra Hindia memberikan suasana yang berbeda pada setiap waktu. Pada pagi hari, cahaya matahari yang mulai menyinari permukaan laut menciptakan suasana yang segar. Udara pantai yang masih relatif sejuk dapat menjadi teman yang menyenangkan untuk berjalan santai menyusuri kawasan pesisir.\nMenjelang siang, warna laut dan langit terlihat semakin terang. Wisatawan dapat menggunakan waktu tersebut untuk mengeksplorasi kawasan sekitar atau mengunjungi destinasi lain yang berada tidak jauh dari Palabuhanratu.\nSementara ketika sore tiba, suasana pantai kembali berubah. Cahaya matahari yang semakin rendah menciptakan warna keemasan di kawasan pesisir. Bagi pencinta fotografi, momen seperti ini menjadi salah satu waktu yang menarik untuk mengabadikan perjalanan.",
            ],
            [
                'name' => 'Pantai Citepus',
                'slug' => 'pantai-citepus',
                'district' => 'Palabuhanratu',
                'address' => 'Jl. Raya Cisolok - Pelabuhanratu No. 16, Citepus, Kec. Palabuhanratu, Kab. Sukabumi, Jawa Barat',
                'latitude' => -6.97010000,
                'longitude' => 106.52450000,
                'price' => 5000,
                'open_hours' => 'Buka 24 Jam',
                'duration' => '2-4 Jam',
                'ticket_info' => 'Retribusi masuk dan parkir',
                'description' => "Berada di kawasan pesisir Palabuhanratu dan Desa Citepus, pantai ini menjadi salah satu bagian dari rangkaian wisata bahari Sukabumi yang menawarkan pengalaman sederhana namun berkesan: laut yang luas, garis pantai yang terbuka, suasana masyarakat pesisir, dan panorama yang semakin indah ketika matahari mulai bergerak menuju ufuk.\n\nDaya tarik utama Pantai Citepus terletak pada karakter pesisirnya yang terbuka. Hamparan laut membentang di hadapan wisatawan, menghadirkan panorama yang terasa luas dan lepas. Suara ombak menjadi latar alami yang menemani perjalanan, sementara angin laut memberikan kesejukan khas kawasan pesisir selatan Sukabumi.\n\nCitepus juga menjadi bagian dari kawasan pesisir yang memiliki beragam titik wisata. Destinasi di kawasan Citepus, antara lain Pantai Muara Citepus, Pantai Kebon Kelapa, Pantai Masjid Istiqomah, serta Pantai Katapang Condong.",
            ],
            [
                'name' => 'Pantai Batu Bintang',
                'slug' => 'pantai-batu-bintang',
                'district' => 'Palabuhanratu',
                'address' => 'Desa Jayanti, Kec. Palabuhanratu, Kab. Sukabumi, Jawa Barat',
                'latitude' => -6.96340000,
                'longitude' => 106.51230000,
                'price' => 5000,
                'open_hours' => 'Buka 24 Jam',
                'duration' => '1-3 Jam',
                'ticket_info' => 'Tiket masuk terjangkau',
                'description' => "Menikmati Pesona Pesisir Palabuhanratu dari Sudut yang Berbeda\n\nPalabuhanratu selalu memiliki cara untuk membuat perjalanan ke pantai terasa istimewa. Di sepanjang pesisirnya, wisatawan dapat menemukan berbagai tempat dengan karakter yang berbeda. Ada pantai yang menjadi pusat keramaian, ada kawasan yang menawarkan ketenangan, dan ada pula tempat-tempat yang menjadi ruang pertemuan antara panorama laut dan kehidupan masyarakat pesisir.\n\nSalah satunya adalah Pantai Batu Bintang.\nBerada di Desa Jayanti, Kecamatan Palabuhanratu, Kabupaten Sukabumi, Pantai Batu Bintang menjadi salah satu destinasi wisata bahari yang memperkaya pengalaman menjelajahi kawasan pesisir Palabuhanratu.\nNama Batu Bintang sendiri memberikan kesan yang kuat. Ia mengingatkan kita pada karakter pesisir Sukabumi yang tidak hanya menawarkan hamparan pasir dan laut, tetapi juga bentang alam dengan berbagai bentuk dan cerita.\nDatang ke Batu Bintang berarti membuka kesempatan untuk menikmati sisi lain dari Palabuhanratu.",
            ],
            [
                'name' => 'Pantai Katapang Condong',
                'slug' => 'pantai-katapang-condong',
                'district' => 'Palabuhanratu',
                'address' => 'Kawasan Citepus, Kec. Palabuhanratu, Kab. Sukabumi, Jawa Barat',
                'latitude' => -6.96780000,
                'longitude' => 106.51890000,
                'price' => 0,
                'open_hours' => 'Buka 24 Jam',
                'duration' => '1-2 Jam',
                'ticket_info' => 'Gratis / Biaya parkir kendaraan',
                'description' => "Palabuhanratu tidak hanya menawarkan satu wajah wisata bahari. Di sepanjang garis pantainya, terdapat berbagai sudut yang memiliki suasana, karakter, dan pengalaman yang berbeda.\n\nSalah satunya adalah Pantai Katapang Condong.\nBerada di kawasan pesisir Palabuhanratu, Pantai Katapang Condong menjadi bagian dari perjalanan menyusuri keindahan pantai selatan Sukabumi. Di tempat ini, wisatawan dapat menikmati suasana laut, merasakan hembusan angin pesisir, serta melihat bagaimana kehidupan masyarakat tumbuh berdampingan dengan bentang alam pantai.\n\nTidak selalu harus datang dengan agenda yang padat.\nKatapang Condong justru dapat dinikmati dengan cara yang sederhana: datang, melihat laut, berjalan di tepi pantai, lalu membiarkan suasana pesisir membawa kita menikmati waktu.",
            ],
            [
                'name' => 'Pantai Cimaja',
                'slug' => 'pantai-cimaja',
                'district' => 'Cikakak',
                'address' => 'Desa Cimaja, Kec. Cikakak, Kab. Sukabumi, Jawa Barat',
                'latitude' => -6.95350000,
                'longitude' => 106.49580000,
                'price' => 5000,
                'open_hours' => 'Buka 24 Jam',
                'duration' => '2-4 Jam',
                'ticket_info' => 'Spot favorit para peselancar (surfing)',
                'description' => "Berada di kawasan Palabuhanratu, Pantai Cimaja telah lama dikenal sebagai salah satu kawasan pesisir Sukabumi yang menarik perhatian para pencinta selancar. Ombaknya menjadi bagian penting dari karakter destinasi ini, sementara suasana pesisirnya menawarkan pengalaman yang berbeda dari sekadar bersantai di tepi pantai.\n\nJika sebagian wisatawan datang ke pantai untuk duduk menikmati pasir dan pemandangan, di Cimaja terdapat wisatawan yang datang dengan papan selancar dan menunggu datangnya ombak yang tepat. Suasana seperti ini memberikan identitas tersendiri bagi kawasan Cimaja.",
            ],
            [
                'name' => 'Pantai Cibangban',
                'slug' => 'pantai-cibangban',
                'district' => 'Cisolok',
                'address' => 'Desa Pasir Baru, Kec. Cisolok, Kab. Sukabumi, Jawa Barat',
                'latitude' => -6.94210000,
                'longitude' => 106.46780000,
                'price' => 5000,
                'open_hours' => 'Buka 24 Jam',
                'duration' => '2-3 Jam',
                'ticket_info' => 'Tersedia pondok wisata dan kuliner ikan bakar',
                'description' => "Menikmati Pesona Pesisir Selatan yang Tenang\n\nSetelah menikmati hiruk-pikuk kawasan Palabuhanratu, perjalanan dapat dilanjutkan menuju sebuah kawasan pantai yang menawarkan suasana berbeda. Di antara bentang alam pesisir dan perbukitan selatan Sukabumi, Pantai Cibangban hadir sebagai salah satu destinasi yang menarik untuk ditemukan.\n\nDi sini, wisatawan dapat menikmati perjalanan dengan suasana yang lebih santai, merasakan angin laut, menyaksikan bentang pesisir, serta menemukan sisi lain Sukabumi yang mungkin belum banyak dikenal.",
            ],
        ];

        foreach ($places as $data) {
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

            // Jika belum ada foto pada destinasi ini, pasangkan foto dummy
            if ($place->placeImages()->count() === 0) {
                PlaceImage::create([
                    'place_id' => $place->id,
                    'image_path' => $dummyDestPath,
                    'is_primary' => true,
                ]);
            }
        }

        $this->command->info('Berhasil mengimpor 6 destinasi wisata pantai ke database.');
    }
}
