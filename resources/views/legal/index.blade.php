@extends('layouts.app')

@section('title', 'Pusat Informasi & Ketentuan Resmi — Visit Sukabumi')
@section('meta_description', 'Pusat informasi resmi, kebijakan privasi, syarat dan ketentuan, aksesibilitas, serta kontak bantuan platform Visit Sukabumi.')

@section('content')
<div class="min-h-screen bg-[#fafbfc] font-sans text-gray-900" x-data="{ 
    activeTab: '{{ $activeTab }}',
    messageSent: false,
    formData: { name: '', email: '', subject: 'Umum', message: '' },
    sendMessage() {
        if(this.formData.name && this.formData.email && this.formData.message) {
            this.messageSent = true;
            this.formData = { name: '', email: '', subject: 'Umum', message: '' };
            setTimeout(() => { this.messageSent = false; }, 6000);
        }
    },
    init() {
        const hash = window.location.hash.replace('#', '');
        if(['tentang-kami', 'kebijakan-privasi', 'syarat-ketentuan', 'aksesibilitas', 'hubungi-kami'].includes(hash)) {
            this.activeTab = hash;
        }
    },
    setTab(tab) {
        this.activeTab = tab;
        window.location.hash = tab;
        window.scrollTo({ top: 300, behavior: 'smooth' });
    }
}">
    @include('components.navbar')

    {{-- HERO HEADER --}}
    <section class="relative bg-gradient-to-br from-[#0c2e59] via-[#1a6bbf] to-[#0f4d8d] text-white pt-16 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid-pattern)" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs md:text-sm font-semibold text-blue-100 mb-5">
                <svg class="w-4 h-4 text-[#f9a826]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>Pusat Informasi & Layanan Resmi</span>
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight mb-4">
                Informasi & Ketentuan Layanan
            </h1>
            <p class="text-blue-100 text-sm md:text-base max-w-2xl mx-auto leading-relaxed">
                Komitmen transparansi, privasi, dan pedoman resmi dalam menjelajahi keindahan alam, budaya, dan wisata Kabupaten Sukabumi.
            </p>
        </div>
    </section>

    {{-- MAIN CONTENT AREA (2 COLUMNS) --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- LEFT: Sticky Sidebar Tabs --}}
            <aside class="lg:col-span-4 sticky top-24 z-20 space-y-4">
                <div class="bg-white rounded-2xl p-3 sm:p-4 shadow-sm border border-gray-100 space-y-1.5">
                    
                    {{-- Tab 1: Tentang Kami --}}
                    <button type="button" @click="setTab('tentang-kami')" 
                            :class="activeTab === 'tentang-kami' ? 'bg-[#1a6bbf] text-white shadow-md' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 text-left">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Tentang Kami</span>
                        </div>
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>

                    {{-- Tab 2: Kebijakan Privasi --}}
                    <button type="button" @click="setTab('kebijakan-privasi')" 
                            :class="activeTab === 'kebijakan-privasi' ? 'bg-[#1a6bbf] text-white shadow-md' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 text-left">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span>Kebijakan Privasi</span>
                        </div>
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>

                    {{-- Tab 3: Syarat & Ketentuan --}}
                    <button type="button" @click="setTab('syarat-ketentuan')" 
                            :class="activeTab === 'syarat-ketentuan' ? 'bg-[#1a6bbf] text-white shadow-md' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 text-left">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Syarat & Ketentuan</span>
                        </div>
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>

                    {{-- Tab 4: Aksesibilitas --}}
                    <button type="button" @click="setTab('aksesibilitas')" 
                            :class="activeTab === 'aksesibilitas' ? 'bg-[#1a6bbf] text-white shadow-md' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 text-left">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span>Aksesibilitas</span>
                        </div>
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>

                    {{-- Tab 5: Hubungi Kami --}}
                    <button type="button" @click="setTab('hubungi-kami')" 
                            :class="activeTab === 'hubungi-kami' ? 'bg-[#1a6bbf] text-white shadow-md' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 text-left">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Hubungi Kami</span>
                        </div>
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>

                </div>

                {{-- Fast Contact Box --}}
                <div class="bg-blue-50/70 border border-blue-100 rounded-2xl p-5 text-gray-700">
                    <div class="flex items-center gap-2.5 mb-2 font-bold text-gray-900 text-sm">
                        <svg class="w-4 h-4 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Layanan Bantuan Wisata
                    </div>
                    <p class="text-xs text-gray-600 leading-relaxed mb-3">
                        Dukungan resmi Dinas Pariwisata Kabupaten Sukabumi untuk wisatawan dan pegiat UMKM lokal.
                    </p>
                    <div class="text-xs space-y-1.5 font-medium text-gray-800">
                        <div>Email: <span class="text-[#1a6bbf] font-bold">info@visitsukabumi.com</span></div>
                        <div>Hotline Darurat: <span class="font-bold">110 / 115 (SAR)</span></div>
                    </div>
                </div>

            </aside>

            {{-- RIGHT: Tab Content Cards --}}
            <div class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-8 md:p-10 shadow-sm border border-gray-100">
                
                {{-- ══════════════════════════════════════════
                     TAB 1: TENTANG KAMI
                ══════════════════════════════════════════ --}}
                <div x-show="activeTab === 'tentang-kami'" x-cloak class="space-y-6">
                    <div class="border-b border-gray-100 pb-5">
                        <span class="text-xs font-bold tracking-widest uppercase text-[#1a6bbf]">Profil Platform</span>
                        <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-1">Tentang Visit Sukabumi</h2>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Platform Panduan Wisata Resmi untuk Kabupaten dan Kota Sukabumi</p>
                    </div>

                    <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 leading-relaxed space-y-4">
                        <p>
                            <strong>Visit Sukabumi</strong> adalah portal panduan wisata resmi dan komprehensif yang dirancang untuk memperkenalkan kekayaan destinasi alam, budaya, kuliner, dan petualangan di Kabupaten dan Kota Sukabumi kepada wisatawan domestik maupun mancanegara.
                        </p>
                        <p>
                            Didukung oleh <strong>Dinas Pariwisata Kabupaten Sukabumi</strong>, inisiatif ini hadir sebagai jembatan informasi digital terpercaya yang menghubungkan keindahan bentang alam Tatar Pasundan — mulai dari keajaiban geologis <em>UNESCO Global Geopark Ciletuh</em>, jembatan gantung terpanjang di Asia Tenggara di <em>Situ Gunung</em>, pesona ombak Samudra Hindia di <em>Palabuhanratu</em>, hingga kearifan lokal masyarakat adat Kasepuhan.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 my-8 not-prose">
                            <div class="p-5 rounded-2xl bg-blue-50/70 border border-blue-100 text-center">
                                <div class="w-10 h-10 rounded-xl bg-[#1a6bbf] text-white flex items-center justify-center mx-auto mb-3 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                                </div>
                                <h3 class="font-bold text-gray-900 text-sm">Pariwisata Berkelanjutan</h3>
                                <p class="text-xs text-gray-600 mt-1">Menjaga keasrian cagar biosfer & kelestarian alam Sukabumi.</p>
                            </div>
                            <div class="p-5 rounded-2xl bg-emerald-50/70 border border-emerald-100 text-center">
                                <div class="w-10 h-10 rounded-xl bg-[#00aa6c] text-white flex items-center justify-center mx-auto mb-3 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h3 class="font-bold text-gray-900 text-sm">Pemberdayaan UMKM</h3>
                                <p class="text-xs text-gray-600 mt-1">Menggerakkan roda ekonomi pengrajin oleh-oleh, kuliner, & pemandu lokal.</p>
                            </div>
                            <div class="p-5 rounded-2xl bg-amber-50/70 border border-amber-100 text-center">
                                <div class="w-10 h-10 rounded-xl bg-[#f9a826] text-gray-950 flex items-center justify-center mx-auto mb-3 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <h3 class="font-bold text-gray-900 text-sm">Informasi Terverifikasi</h3>
                                <p class="text-xs text-gray-600 mt-1">Data lokasi, tiket, jam buka, & aksesibilitas yang terus diperbarui.</p>
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900">Visi & Misi</h3>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>Mewujudkan pariwisata Sukabumi yang berdaya saing global dengan tetap berakar pada kearifan budaya lokal Sunda.</li>
                            <li>Memberikan kemudahan bagi setiap wisatawan dalam menyusun rencana perjalanan liburan melalui teknologi digital yang ramah pengguna.</li>
                            <li>Mempromosikan potensi kuliner khas, produk kerajinan tangan, dan akomodasi lokal agar dirasakan langsung manfaatnya oleh masyarakat Sukabumi.</li>
                        </ul>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════
                     TAB 2: KEBIJAKAN PRIVASI
                ══════════════════════════════════════════ --}}
                <div x-show="activeTab === 'kebijakan-privasi'" x-cloak class="space-y-6">
                    <div class="border-b border-gray-100 pb-5">
                        <span class="text-xs font-bold tracking-widest uppercase text-[#1a6bbf]">Perlindungan Pengguna</span>
                        <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-1">Kebijakan Privasi</h2>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Terakhir diperbarui: 12 September 2026</p>
                    </div>

                    <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 leading-relaxed space-y-4">
                        <p>
                            Privasi pengunjung adalah prioritas utama kami. Kebijakan Privasi ini menjelaskan bagaimana <strong>Visit Sukabumi</strong> mengumpulkan, mengelola, menggunakan, dan melindungi data pribadi yang Anda berikan saat mengakses platform kami.
                        </p>

                        <h3 class="text-lg font-bold text-gray-900 mt-6">1. Informasi yang Kami Kumpulkan</h3>
                        <ul class="list-disc pl-5 space-y-1.5">
                            <li><strong>Informasi Akun:</strong> Nama, alamat email, dan kata sandi terenkripsi saat Anda mendaftar akun untuk menyimpan wishlist atau menulis ulasan.</li>
                            <li><strong>Kontribusi Wisatawan:</strong> Ulasan, rating bintang, foto, dan komentar yang Anda bagikan secara sukarela pada destinasi atau event.</li>
                            <li><strong>Data Perangkat & Lokasi:</strong> Lokasi geografis (hanya jika Anda mengizinkan izin lokasi browser) untuk menghitung jarak destinasi terdekat dari posisi Anda.</li>
                            <li><strong>Log Teknis & Cookies:</strong> Alamat IP, tipe peramban, dan data sesi untuk menjaga keamanan serta performa sistem.</li>
                        </ul>

                        <h3 class="text-lg font-bold text-gray-900 mt-6">2. Penggunaan Informasi</h3>
                        <p>Data yang kami peroleh digunakan untuk:</p>
                        <ul class="list-disc pl-5 space-y-1.5">
                            <li>Menyajikan rekomendasi wisata yang relevan dan menampilkan jarak terdekat secara akurat.</li>
                            <li>Memfasilitasi fitur interaktif seperti wishlist favorit dan ulasan komunitas wisatawan.</li>
                            <li>Menganalisis tren pariwisata daerah guna membantu peningkatan fasilitas wisata di Kabupaten Sukabumi.</li>
                            <li>Mencegah aktivitas spam, penipuan, atau penyalahgunaan platform.</li>
                        </ul>

                        <h3 class="text-lg font-bold text-gray-900 mt-6">3. Keamanan Data</h3>
                        <p>
                            Kami menerapkan standar enkripsi modern (HTTPS/SSL), penyimpanan kata sandi satu arah (hashing), serta perlindungan token CSRF untuk melindungi integritas informasi Anda dari akses yang tidak berwenang. Kami <strong>tidak pernah menjual atau menyewakan</strong> data pribadi Anda kepada pihak ketiga mana pun untuk tujuan komersial.
                        </p>

                        <h3 class="text-lg font-bold text-gray-900 mt-6">4. Hak Pengguna</h3>
                        <p>
                            Anda berhak memperbarui profil, menghapus ulasan yang telah Anda tulis, atau meminta penghapusan akun beserta riwayat data Anda kapan saja melalui kontak resmi kami di <a href="mailto:info@visitsukabumi.com" class="text-[#1a6bbf] font-bold hover:underline">info@visitsukabumi.com</a>.
                        </p>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════
                     TAB 3: SYARAT & KETENTUAN
                ══════════════════════════════════════════ --}}
                <div x-show="activeTab === 'syarat-ketentuan'" x-cloak class="space-y-6">
                    <div class="border-b border-gray-100 pb-5">
                        <span class="text-xs font-bold tracking-widest uppercase text-[#1a6bbf]">Aturan Penggunaan</span>
                        <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-1">Syarat & Ketentuan Layanan</h2>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Ketentuan penggunaan platform digital Visit Sukabumi</p>
                    </div>

                    <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 leading-relaxed space-y-4">
                        <p>
                            Selamat datang di Visit Sukabumi. Dengan mengakses atau menggunakan platform ini, Anda setuju untuk terikat oleh Syarat dan Ketentuan berikut. Mohon membacanya dengan saksama.
                        </p>

                        <h3 class="text-lg font-bold text-gray-900 mt-6">1. Peran Platform & Keterangan Informasi</h3>
                        <p>
                            Visit Sukabumi bertindak sebagai penyedia informasi panduan wisata. Informasi mengenai harga tiket, jam operasional, kondisi cuaca, dan ketersediaan fasilitas bersumber dari pengelola destinasi, dinas terkait, serta kurasi tim kami. Walaupun kami berupaya memastikan data selalu akurat, perubahan mendadak dari pihak pengelola tempat wisata (seperti penutupan sementara saat cuaca ekstrem) berada di luar kendali langsung kami.
                        </p>

                        <h3 class="text-lg font-bold text-gray-900 mt-6">2. Pemesanan Pihak Ketiga & Tautan Eksternal</h3>
                        <p>
                            Tautan menuju pembelian tiket eksternal, pemesanan hotel, atau WhatsApp pengelola wisata disediakan semata-mata untuk memudahkan wisatawan. Segala bentuk transaksi keuangan atau perjanjian sewa adalah hubungan hukum langsung antara wisatawan dan penyedia jasa terkait.
                        </p>

                        <h3 class="text-lg font-bold text-gray-900 mt-6">3. Pedoman Konten & Ulasan Komunitas</h3>
                        <p>Saat memberikan ulasan, wisatawan wajib mematuhi etika berikut:</p>
                        <ul class="list-disc pl-5 space-y-1.5">
                            <li>Ulasan harus berdasarkan pengalaman nyata yang dialami sendiri di tempat wisata.</li>
                            <li>Dilarang mengunggah konten yang mengandung ujaran kebencian, fitnah, pornografi, atau konten yang melanggar hukum RI.</li>
                            <li>Tim kurator berhak memoderasi atau menghapus ulasan yang terbukti merupakan spam atau promosi terselubung.</li>
                        </ul>

                        <h3 class="text-lg font-bold text-gray-900 mt-6">4. Hak Cipta & Kekayaan Intelektual</h3>
                        <p>
                            Seluruh logo, merek dagang, desain antarmuka, tata letak, dan konten editorial yang ada di situs ini merupakan hak milik intelektual platform Visit Sukabumi dan dilindungi oleh undang-undang hak cipta. Foto destinasi merupakan hak cipta masing-masing kontributor dan dinas pariwisata yang diatribusikan secara sah.
                        </p>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════
                     TAB 4: AKSESIBILITAS
                ══════════════════════════════════════════ --}}
                <div x-show="activeTab === 'aksesibilitas'" x-cloak class="space-y-6">
                    <div class="border-b border-gray-100 pb-5">
                        <span class="text-xs font-bold tracking-widest uppercase text-[#00aa6c]">Pariwisata Inklusif</span>
                        <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-1">Komitmen Aksesibilitas</h2>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Menjamin pariwisata Sukabumi dapat dinikmati oleh semua kalangan</p>
                    </div>

                    <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 leading-relaxed space-y-4">
                        <p>
                            Kami percaya bahwa keindahan alam dan budaya Sukabumi harus dapat diakses dan dinikmati oleh semua orang, termasuk penyandang disabilitas, lansia, dan keluarga dengan balita.
                        </p>

                        <div class="bg-emerald-50/70 border border-emerald-100 rounded-2xl p-6 my-6 not-prose">
                            <h3 class="font-bold text-gray-900 text-base mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#00aa6c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Fitur Penanda Aksesibilitas di Platform
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-700 leading-relaxed">
                                Setiap halaman destinasi di platform Visit Sukabumi telah dilengkapi penanda aksesibilitas khusus (seperti: <em>Ramah Kursi Roda</em>, <em>Hanya Kendaraan Roda Dua</em>, <em>Perlu Trekking</em>, atau <em>Akses Perahu</em>) agar wisatawan dapat mempersiapkan diri sebelum berangkat.
                            </p>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mt-6">Aksesibilitas Website Digital</h3>
                        <p>
                            Situs web ini dibangun dengan berpedoman pada standar Web Content Accessibility Guidelines (WCAG 2.1), antara lain:
                        </p>
                        <ul class="list-disc pl-5 space-y-1.5">
                            <li><strong>Kontras Warna yang Jelas:</strong> Memastikan teks mudah dibaca oleh pengguna dengan keterbatasan penglihatan.</li>
                            <li><strong>Navigasi Keyboard:</strong> Seluruh elemen interaktif dapat dijelajahi menggunakan tombol Tab keyboard.</li>
                            <li><strong>Atribut Alt Teks Gambar:</strong> Memberikan deskripsi visual gambar untuk perangkat pembaca layar (screen reader).</li>
                            <li><strong>Struktur Semantik:</strong> Penggunaan tag HTML yang tepat untuk memudahkan mesin pembaca memahami hierarki informasi.</li>
                        </ul>

                        <p class="mt-4">
                            Jika Anda menemukan kendala aksesibilitas baik pada website ini maupun di destinasi wisata lapangan, mohon hubungi kami agar tim kami dapat segera melakukan perbaikan.
                        </p>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════
                     TAB 5: HUBUNGI KAMI
                ══════════════════════════════════════════ --}}
                <div x-show="activeTab === 'hubungi-kami'" x-cloak class="space-y-6">
                    <div class="border-b border-gray-100 pb-5">
                        <span class="text-xs font-bold tracking-widest uppercase text-[#1a6bbf]">Saluran Bantuan & Kemitraan</span>
                        <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-1">Hubungi Kami</h2>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Kritik, saran, pelaporan informasi, dan kemitraan pariwisata</p>
                    </div>

                    {{-- Success Notification --}}
                    <div x-show="messageSent" x-cloak class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3 animate-fade-in">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <div class="text-xs sm:text-sm font-bold">Terima kasih! Pesan Anda telah kami terima dan akan segera ditindaklanjuti oleh tim kami.</div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6">
                        {{-- Kantor Dinas --}}
                        <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100 space-y-2">
                            <div class="w-8 h-8 rounded-lg bg-[#1a6bbf]/10 text-[#1a6bbf] flex items-center justify-center mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <h4 class="font-bold text-gray-900 text-sm">Kantor Dinas Pariwisata</h4>
                            <p class="text-xs text-gray-600 leading-relaxed">
                                Komplek Gelanggang Cisaat, Jl. Veteran II No. 1, Cisaat, Kabupaten Sukabumi, Jawa Barat 43152.
                            </p>
                        </div>

                        {{-- Pusat Informasi Wisata Palabuhanratu --}}
                        <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100 space-y-2">
                            <div class="w-8 h-8 rounded-lg bg-[#f9a826]/20 text-[#b36b00] flex items-center justify-center mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <h4 class="font-bold text-gray-900 text-sm">Tourism Information Center (TIC)</h4>
                            <p class="text-xs text-gray-600 leading-relaxed">
                                Kawasan Pantai Citepus, Jl. Raya Cisolok - Palabuhanratu, Kabupaten Sukabumi.
                            </p>
                        </div>
                    </div>

                    {{-- Form Kontak --}}
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h3 class="text-base font-bold text-gray-900 mb-4">Kirimkan Pertanyaan atau Saran</h3>
                        <form @submit.prevent="sendMessage()" class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap *</label>
                                    <input type="text" x-model="formData.name" required placeholder="Nama Anda" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#1a6bbf] focus:border-transparent outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Email *</label>
                                    <input type="email" x-model="formData.email" required placeholder="email@domain.com" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#1a6bbf] focus:border-transparent outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Topik Pesan</label>
                                <select x-model="formData.subject" class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#1a6bbf] focus:border-transparent outline-none bg-white">
                                    <option value="Umum">Pertanyaan Umum Wisata</option>
                                    <option value="Koreksi">Koreksi Informasi Tempat Wisata</option>
                                    <option value="Kemitraan">Kemitraan / Pendaftaran UMKM</option>
                                    <option value="Masalah">Pengaduan Layanan / Kendala Akses</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Pesan Anda *</label>
                                <textarea x-model="formData.message" rows="4" required placeholder="Tuliskan pesan, pertanyaan, atau masukan Anda di sini..." class="w-full text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#1a6bbf] focus:border-transparent outline-none"></textarea>
                            </div>
                            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold px-7 py-3 rounded-xl transition shadow-sm text-sm cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                <span>Kirim Pesan</span>
                            </button>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </main>

    @include('components.footer')
</div>
@endsection
