<footer class="bg-white border-t border-gray-200 relative">
    {{-- Top Brand Bar --}}
    <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-6 border-b border-gray-200">
        <div>
            <a href="{{ url('/') }}" class="inline-block">
                <img src="{{ asset('images/logo.png') }}" alt="Visit Sukabumi" class="h-16 md:h-20 object-contain drop-shadow-sm mb-1" />
            </a>
            <div class="text-[11px] text-gray-500 font-semibold tracking-widest uppercase mt-0.5 px-2">Panduan Wisata Resmi</div>
        </div>
        <div class="text-gray-300 hidden md:block">
            <svg width="220" height="55" viewBox="0 0 220 55" fill="none" stroke="currentColor" stroke-width="1.2">
                <path d="M10 55 L10 35 L30 15 L50 35 L70 20 L90 40 L110 25 L130 40 L150 15 L170 35 L190 10 L210 35 L210 55 Z" stroke-linejoin="round"/>
                <circle cx="90" cy="8" r="6"/>
                <path d="M84 8 Q90 2 96 8"/>
            </svg>
        </div>
        <div class="flex items-center gap-4">
            {{-- Social links (kept as # for now per user request) --}}
            <a href="#" class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition" title="Facebook">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
            </a>
            <a href="#" class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition" title="Instagram">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37zm1.5-4.87h.01M7.5 20.5h9a5 5 0 0 0 5-5v-9a5 5 0 0 0-5-5h-9a5 5 0 0 0-5 5v9a5 5 0 0 0 5 5z"/></svg>
            </a>
            <a href="#" class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition" title="YouTube">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58a2.78 2.78 0 0 0 1.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.47a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58zM10 15.5V8.5l6 3.5-6 3.5z"/></svg>
            </a>
        </div>
    </div>

    {{-- 4 Columns Navigation Grid --}}
    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-2 md:grid-cols-4 gap-8 border-b border-gray-200">
        {{-- 1. WISATA --}}
        <div>
            <h4 class="text-[11px] font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">WISATA</h4>
            <ul class="space-y-2.5">
                @php
                    $wisataLinks = [
                        ['title' => 'Tempat wisata Sukabumi', 'url' => route('place.index')],
                        ['title' => 'Wisata alam', 'url' => route('place.index', ['search' => 'alam'])],
                        ['title' => 'Wisata pantai', 'url' => route('place.index', ['search' => 'pantai'])],
                        ['title' => 'Hiking & trekking', 'url' => route('place.index', ['search' => 'trekking'])],
                        ['title' => 'Arung jeram', 'url' => route('place.index', ['search' => 'arung jeram'])],
                        ['title' => 'Kuliner & makanan', 'url' => route('place.index', ['category' => 'kuliner'])],
                        ['title' => 'Belanja oleh-oleh', 'url' => route('place.index', ['search' => 'oleh-oleh'])],
                        ['title' => 'Penginapan', 'url' => route('penginapan.index')],
                    ];
                @endphp
                @foreach($wisataLinks as $l)
                <li><a href="{{ $l['url'] }}" class="text-[13px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition">{{ $l['title'] }}</a></li>
                @endforeach
            </ul>
        </div>

        {{-- 2. DESTINASI POPULER --}}
        <div>
            <h4 class="text-[11px] font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">DESTINASI POPULER</h4>
            <ul class="space-y-2.5">
                @php
                    $populerLinks = [
                        ['title' => 'Geopark Ciletuh', 'url' => route('place.index', ['search' => 'Geopark Ciletuh'])],
                        ['title' => 'Situ Gunung', 'url' => route('place.index', ['search' => 'Situ Gunung'])],
                        ['title' => 'Pelabuhan Ratu', 'url' => route('place.index', ['search' => 'Palabuhanratu'])],
                        ['title' => 'Curug Cikaso', 'url' => route('place.index', ['search' => 'Curug Cikaso'])],
                        ['title' => 'Curug Luhur', 'url' => route('place.index', ['search' => 'Curug Luhur'])],
                        ['title' => 'Pantai Ujung Genteng', 'url' => route('place.index', ['search' => 'Ujung Genteng'])],
                        ['title' => 'Taman Nasional Halimun', 'url' => route('place.index', ['search' => 'Halimun'])],
                        ['title' => 'Gunung Gede Pangrango', 'url' => route('place.index', ['search' => 'Gede Pangrango'])],
                    ];
                @endphp
                @foreach($populerLinks as $l)
                <li><a href="{{ $l['url'] }}" class="text-[13px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition">{{ $l['title'] }}</a></li>
                @endforeach
            </ul>
        </div>

        {{-- 3. AKTIVITAS TERBAIK --}}
        <div>
            <h4 class="text-[11px] font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">AKTIVITAS TERBAIK</h4>
            <ul class="space-y-2.5">
                @php
                    $aktivitasLinks = [
                        ['title' => 'Arung Jeram Citarik', 'url' => route('place.index', ['search' => 'Citarik'])],
                        ['title' => 'Jembatan Situ Gunung', 'url' => route('place.index', ['search' => 'Jembatan'])],
                        ['title' => 'Snorkeling Ujung Genteng', 'url' => route('place.index', ['search' => 'Snorkeling'])],
                        ['title' => 'Surfing Palabuhanratu', 'url' => route('place.index', ['search' => 'Surfing'])],
                        ['title' => 'Glamping Halimun', 'url' => route('place.index', ['search' => 'Glamping'])],
                        ['title' => 'Wisata Edukasi Geopark', 'url' => route('place.index', ['search' => 'Edukasi'])],
                        ['title' => 'Bersepeda Selabintana', 'url' => route('place.index', ['search' => 'Selabintana'])],
                        ['title' => 'Camping Curug', 'url' => route('place.index', ['search' => 'Camping'])],
                    ];
                @endphp
                @foreach($aktivitasLinks as $l)
                <li><a href="{{ $l['url'] }}" class="text-[13px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition">{{ $l['title'] }}</a></li>
                @endforeach
            </ul>
        </div>

        {{-- 4. PANDUAN PERJALANAN --}}
        <div>
            <h4 class="text-[11px] font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">PANDUAN PERJALANAN</h4>
            <ul class="space-y-2.5">
                @php
                    $panduanLinks = [
                        ['title' => 'Cara ke Sukabumi', 'url' => route('blog.index', ['search' => 'rute'])],
                        ['title' => 'Transportasi lokal', 'url' => route('blog.index', ['search' => 'transportasi'])],
                        ['title' => 'Peta wisata Sukabumi', 'url' => route('place.index')],
                        ['title' => 'Tips keselamatan', 'url' => route('blog.index', ['search' => 'tips'])],
                        ['title' => 'Hotel & penginapan', 'url' => route('penginapan.index')],
                        ['title' => 'Paket wisata', 'url' => route('place.index', ['search' => 'paket'])],
                        ['title' => 'Kontak darurat', 'url' => route('legal.show', 'hubungi-kami')],
                        ['title' => 'Tentang Sukabumi', 'url' => route('information.index')],
                    ];
                @endphp
                @foreach($panduanLinks as $l)
                <li><a href="{{ $l['url'] }}" class="text-[13px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition">{{ $l['title'] }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Bottom Blue Official Bar --}}
    <div class="bg-[#1a6bbf]">
        <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="bg-white px-3 py-1.5 rounded-xl shadow-sm block">
                    <img src="{{ asset('images/logo.png') }}" alt="Visit Sukabumi" class="h-8 md:h-10 object-contain" />
                </a>
                <span class="block text-blue-100 text-[11px] md:text-[12px] font-medium leading-snug">
                    Didukung oleh Dinas Pariwisata<br class="hidden md:block"/> Kabupaten Sukabumi
                </span>
            </div>
            
            {{-- Official & Legal Links + Cookie Preferences Trigger --}}
            <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
                <a href="{{ route('legal.show', 'hubungi-kami') }}" class="text-blue-100 hover:text-white text-[12px] font-medium transition">Hubungi Kami</a>
                <a href="{{ route('legal.show', 'tentang-kami') }}" class="text-blue-100 hover:text-white text-[12px] font-medium transition">Tentang Kami</a>
                <a href="{{ route('legal.show', 'kebijakan-privasi') }}" class="text-blue-100 hover:text-white text-[12px] font-medium transition">Kebijakan Privasi</a>
                <a href="{{ route('legal.show', 'aksesibilitas') }}" class="text-blue-100 hover:text-white text-[12px] font-medium transition">Aksesibilitas</a>
                <a href="{{ route('legal.show', 'syarat-ketentuan') }}" class="text-blue-100 hover:text-white text-[12px] font-medium transition">Syarat & Ketentuan</a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 pb-5">
            <p class="text-blue-200 text-[11px] leading-relaxed max-w-3xl">Visit Sukabumi adalah platform panduan wisata resmi untuk Kabupaten dan Kota Sukabumi. Kami mendukung pariwisata lokal dan UMKM.</p>
        </div>
    </div>

    {{-- Include Cookie Consent Component --}}
    @include('components.cookie-consent')
</footer>
