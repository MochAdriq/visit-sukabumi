<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Place;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            // ── TIPE: activity (Apa yang Bisa Dilakukan) ─────────────
            [
                'name'             => 'Pacu Adrenalin',
                'slug'             => 'pacu-adrenalin',
                'type'             => 'activity',
                'description'      => 'Tantang diri Anda dengan aktivitas ekstrem dan petualangan seru di Sukabumi — rafting, arung jeram, ATV, hingga cliff jumping.',
                'long_description' => '<p>Bagi para pencari tantangan dan penikmat sensasi detak jantung berdegup kencang, <strong>Sukabumi adalah panggung petualangan luar ruangan terbaik di Jawa Barat</strong>. Kontur geografisnya yang ekstrem — diapit oleh pegunungan vulkanik yang curam, jeram-jeram sungai berarus deras, dan tebing karst terjal — menciptakan arena alami berstandar internasional untuk berbagai aktivitas pemacu adrenalin.</p><p>Dua sungai legendaris, <strong>Sungai Citarik dan Sungai Cicatih</strong>, telah lama diakui sebagai episentrum arung jeram (<em>white water rafting</em>) terpopuler yang bahkan pernah menjadi tuan rumah kejuaraan dunia. Dengan variasi jeram dari Grade III hingga IV+, setiap hempasan ombak sungai menjanjikan sensasi tak terlupakan di bawah pengawasan pemandu berlisensi internasional.</p><p>Tak berhenti di atas air, Anda juga dapat menguji nyali dengan menjelajahi jalur off-road berlumpur menggunakan ATV, menuruni air terjun vertikal (<em>canyoning</em>), hingga meluncur di atas kanopi hutan tropis Geopark Ciletuh.</p>',
                'icon_svg'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                'sort_order'       => 1,
            ],
            [
                'name'             => 'Hiking & Trekking',
                'slug'             => 'hiking-trekking',
                'type'             => 'activity',
                'description'      => 'Jelajahi jalur pendakian dan trekking terbaik Sukabumi — dari hutan tropis hingga puncak gunung yang memukau.',
                'long_description' => '<p>Merupakan gerbang utama menuju petualangan pegunungan tropis, <strong>Sukabumi menyuguhkan bentang alam trekking paling menantang sekaligus memukau di Pulau Jawa</strong>. Dari hutan lumut purba di Taman Nasional Gunung Gede Pangrango hingga keheningan rimba Halimun Salak, setiap langkah pendakian menjanjikan panorama magis yang memanjakan jiwa.</p><p>Jalur pendakian via Selabintana menawarkan salah satu rute trekking terpanjang dan paling alami dengan lintasan kanopi rapat, air terjun tersembunyi, hingga habitat satwa liar endemik seperti Owa Jawa dan elang Jawa. Bagi pendaki pemula, rute-rute bukit seperti Puncak Peuteuy dan perbukitan Geopark menyajikan panorama matahari terbit yang spektakuler tanpa memerlukan persiapan teknis yang rumit.</p>',
                'icon_svg'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"/>',
                'sort_order'       => 2,
            ],
            [
                'name'             => 'Sukabumi untuk Anak',
                'slug'             => 'sukabumi-untuk-anak',
                'type'             => 'activity',
                'description'      => 'Destinasi dan aktivitas ramah anak yang seru, aman, dan penuh edukasi untuk liburan keluarga tak terlupakan.',
                'long_description' => '<p>Menciptakan kenangan masa kecil yang penuh keceriaan di alam terbuka adalah salah satu pengalaman terbaik yang ditawarkan oleh Sukabumi. <strong>Kategori ini didedikasikan untuk destinasi ramah anak dan keluarga</strong>, tempat si kecil dapat bereksplorasi, belajar mencintai satwa, serta berinteraksi langsung dengan keindahan alam secara aman dan nyaman.</p><p>Mulai dari taman rekreasi air, wahana bermain edukatif, kebun binatang mini (<em>petting zoo</em>), hingga berkemah ceria dengan fasilitas glamping keluarga di tepi danau. Semua destinasi dikurasi dengan standar keamanan tinggi dan aksesibilitas yang ramah keluarga.</p>',
                'icon_svg'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                'sort_order'       => 3,
            ],
            [
                'name'             => 'Kuliner & Makanan',
                'slug'             => 'kuliner-makanan',
                'type'             => 'activity',
                'description'      => 'Cicipi cita rasa autentik Sukabumi — dari jajanan tradisional, restoran seafood pinggir pantai, hingga kafe estetik.',
                'long_description' => '<p>Menjelajahi Sukabumi tidak akan pernah lengkap tanpa mencecap kekayaan kulinernya yang legendaris. <strong>Kombinasi tradisi Sunda yang otentik dan pengaruh pesisir Samudra Hindia</strong> menghasilkan ragam hidangan gurih, manis, dan pedas yang memanjakan lidah setiap pelancong.</p><p>Dari semerbak aroma <strong>Mochi Kaswari</strong> yang kenyal dan harum wijen di gang-gang kota, gurihnya bubur ayam khas Sukabumi berkuah kuning, hingga pesta hidangan laut (<em>fresh seafood</em>) bumbu bakar jimbaran di tepian Pantai Pelabuhanratu. Nikmati pula deretan kafe estetik berhawa sejuk di lereng perbukitan untuk momen santai terbaik Anda.</p>',
                'icon_svg'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                'sort_order'       => 4,
            ],
            [
                'name'             => 'Budaya & Sejarah',
                'slug'             => 'budaya-sejarah',
                'type'             => 'activity',
                'description'      => 'Kenali warisan budaya, situs bersejarah, dan kekayaan tradisi yang tersimpan di setiap sudut Sukabumi.',
                'long_description' => '<p>Di balik pesona alamnya yang mendunia, Sukabumi menyimpan jejak peradaban dan kearifan lokal yang telah mengakar selama berabad-abad. <strong>Dari era megalitikum, kerajaan Sunda kuno, hingga masa keemasan kolonial Hindia Belanda</strong>, setiap tapak sejarahnya menyimpan cerita luhur yang memikat untuk dipelajari.</p><p>Kunjungi <strong>Kampung Adat Ciptagelar</strong> di lereng Halimun Salak yang masih memegang teguh tradisi leluhur bertani padi berusia ratusan tahun tanpa menggunakan listrik modern. Di jantung kota, deretan arsitektur kolonial peninggalan perkebunan teh abad ke-19 dan museum bersejarah berdiri anggun mengajak Anda melintasi lorong waktu.</p>',
                'icon_svg'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
                'sort_order'       => 5,
            ],
            [
                'name'             => 'Santai & Healing',
                'slug'             => 'santai-healing',
                'type'             => 'activity',
                'description'      => 'Lepaskan penat dan nikmati ketenangan alam, glamping, spa, dan kafe tepi sungai yang menyejukkan jiwa.',
                'long_description' => '<p>Bagi Anda yang merindukan jeda sejenak dari hiruk-pikuk kesibukan perkotaan, <strong>Sukabumi adalah tempat pelarian sempurna untuk menyegarkan pikiran dan memulihkan energi jiwa</strong>. Hawa pegunungan yang sejuk, gemericik air sungai yang menenangkan, serta bentangan kebun teh hijau yang luas menciptakan terapi alami terbaik.</p><p>Pilihlah pengalaman menginap di resort glamping mewah di tengah hutan pinus, berendam di kolam air panas alami Cisolok yang mengandung belerang vulkanik, atau sekadar menikmati secangkir kopi hangat sambil memandang kabut pagi yang turun perlahan di lembah.</p>',
                'icon_svg'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
                'sort_order'       => 6,
            ],
            [
                'name'             => 'Pendidikan & Edu Wisata',
                'slug'             => 'eduwisata',
                'type'             => 'activity',
                'description'      => 'Belajar sambil berwisata — kunjungi pusat konservasi, kebun edukasi, museum, dan tempat riset ilmu pengetahuan.',
                'long_description' => '<p>Belajar tidak lagi terbatas di dalam ruang kelas. Sukabumi menghadirkan konsep <strong>edukasi interaktif berbasis alam dan sains</strong> yang menginspirasi anak-anak maupun orang dewasa untuk memahami ekologi dan konservasi bumi secara langsung.</p><p>Pusat konservasi penyu hijau di Pangumbahan, stasiun riset primata di Bodogol, hingga laboratorium alam Geopark Ciletuh-Palabuhanratu yang diakui UNESCO menawarkan pembelajaran langsung tentang geologi batuan purba berusia jutaan tahun, keanekaragaman hayati, dan pelestarian lingkungan hidup.</p>',
                'icon_svg'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 7v-6m0 0l-3.5-2M12 15l3.5-2"/>',
                'sort_order'       => 7,
            ],
            [
                'name'             => 'Belanja Oleh-Oleh',
                'slug'             => 'belanja-oleh-oleh',
                'type'             => 'activity',
                'description'      => 'Bawa pulang kenangan terbaik Sukabumi — mulai dari kerajinan tangan, makanan khas, batik, hingga souvenir unik.',
                'long_description' => '<p>Bawa pulang sepotong kehangatan Sukabumi untuk orang-orang tersayang di rumah. Sentra oleh-oleh Sukabumi menawarkan aneka buah tangan khas yang melegenda dan kerajinan tangan bermutu tinggi hasil karya pengrajin lokal.</p><p>Mulai dari Mochi Lampion aneka rasa, kue jahe otentik, keripik pisang tanduk, madu hutan murni, hingga kain batik motif khas Sukabumi yang sarat filosofi lokal. Jelajahi kawasan pusat oleh-oleh di sepanjang Jalan Bhayangkara dan pusat cinderamata pesisir.</p>',
                'icon_svg'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>',
                'sort_order'       => 8,
            ],

            // ── TIPE: wisata (menu Wisata) ────────────────────────────
            [
                'name'             => 'Wisata Alam',
                'slug'             => 'wisata-alam',
                'type'             => 'wisata',
                'description'      => 'Curug, hutan, gunung, sungai, dan keajaiban alam Sukabumi yang memukau — siap memanjakan mata dan jiwa petualang.',
                'long_description' => '<p>Dianugerahi predikat <strong>UNESCO Global Geopark</strong>, bentang alam Sukabumi adalah salah satu mahakarya bumi terindah di khatulistiwa. Dari amfiteater raksasa Geopark Ciletuh, deretan puluhan air terjun megah (<em>curug</em>), hingga danau vulkanik Situ Gunung dengan jembatan gantung (<em>suspension bridge</em>) terpanjang di Asia Tenggara.</p><p>Setiap penjuru Sukabumi menyuguhkan pemandangan yang memukau mata: hamparan sawah bertingkat, ngarai hijau yang dramatis, serta udara pegunungan berkabut yang segar. Surga abadi bagi para fotografer lanskap dan pecinta alam liar.</p>',
                'icon_svg'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l7 4 7-4M5 3v10l7 4 7-4V3"/>',
                'sort_order'       => 1,
            ],
            [
                'name'             => 'Wisata Pantai',
                'slug'             => 'wisata-pantai',
                'type'             => 'wisata',
                'description'      => 'Garis pantai selatan Sukabumi yang memukau — ombak bergelora, pasir putih, tebing dramatis, dan matahari terbenam memesona.',
                'long_description' => '<p>Membentang di sepanjang Samudra Hindia, <strong>garis pantai selatan Sukabumi menyajikan drama pertemuan antara laut biru berombak spektakuler dan tebing-tebing karang kokoh</strong>. Pantai-pantai di sini terkenal dengan karakteristiknya yang beragam, dari ombak kelas dunia untuk peselancar hingga laguna pasir putih yang tenang.</p><p>Saksikan matahari terbenam keemasan di Pantai Cimaja yang terkenal di kalangan peselancar internasional, jelajahi pantai tersembunyi Pantai Amanda Ratu dengan pulau karang mirip Tanah Lot, hingga keindahan Pantai Ujung Genteng dengan pasir putihnya yang lembut.</p>',
                'icon_svg'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>',
                'sort_order'       => 2,
            ],
            [
                'name'             => 'Wisata Spiritual',
                'slug'             => 'wisata-spiritual',
                'type'             => 'wisata',
                'description'      => 'Temukan ketenangan batin di situs ziarah, pesantren bersejarah, makam keramat, dan tempat meditasi yang sakral di Sukabumi.',
                'long_description' => '<p>Mencari kedamaian batin dan ketenangan jiwa di tanah yang diberkati ketenangan alam. <strong>Wisata spiritual di Sukabumi memadukan napak tilas sejarah keagamaan, ziarah makam tokoh ulama besar, dan tempat perenungan yang sakral</strong>.</p><p>Kunjungi pondok pesantren bersejarah, makam para wali dan tokoh penyebar Islam di tatar Pasundan, hingga wihara dan tempat peribadatan berarsitektur megah di kawasan perbukitan yang dikelilingi ketenangan alam pedesaan yang asri.</p>',
                'icon_svg'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
                'sort_order'       => 3,
            ],
        ];

        foreach ($tags as $tagData) {
            Tag::updateOrCreate(
                ['slug' => $tagData['slug']],
                $tagData
            );
        }

        // Auto-assign existing places to tags based on category & keywords
        $tagMap = [
            'wisata-alam'        => ['wisata-alam'],
            'wisata-pantai'      => ['wisata-pantai'],
            'wisata-spiritual'   => ['wisata-budaya'],
            'kuliner-makanan'    => ['kuliner'],
            'pacu-adrenalin'     => ['aktivitas-seru'],
            'hiking-trekking'    => ['wisata-alam'],
            'sukabumi-untuk-anak'=> ['hotel-resort', 'wisata-pantai', 'wisata-alam'],
            'santai-healing'     => ['hotel-resort', 'wisata-alam'],
            'eduwisata'          => ['wisata-budaya', 'wisata-alam'],
            'belanja-oleh-oleh'   => ['kuliner'],
            'budaya-sejarah'     => ['wisata-budaya'],
        ];

        foreach ($tagMap as $tagSlug => $catSlugs) {
            $tag = Tag::where('slug', $tagSlug)->first();
            if (!$tag) continue;

            $catIds = Category::whereIn('slug', $catSlugs)->pluck('id');
            $places = Place::whereIn('category_id', $catIds)->pluck('id');
            $tag->places()->syncWithoutDetaching($places);
        }
    }
}
