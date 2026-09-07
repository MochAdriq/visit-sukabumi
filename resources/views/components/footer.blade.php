<footer class="bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-6 border-b border-gray-200">
        <div>
            <div class="text-[#1a6bbf] text-2xl font-black tracking-tight leading-none">VISIT SUKABUMI</div>
            <div class="text-[11px] text-gray-500 font-semibold tracking-widest uppercase mt-0.5">Panduan Wisata Resmi</div>
        </div>
        <div class="text-gray-300 hidden md:block">
            <svg width="220" height="55" viewBox="0 0 220 55" fill="none" stroke="currentColor" stroke-width="1.2">
                <path d="M10 55 L10 35 L30 15 L50 35 L70 20 L90 40 L110 25 L130 40 L150 15 L170 35 L190 10 L210 35 L210 55 Z" stroke-linejoin="round"/>
                <circle cx="90" cy="8" r="6"/>
                <path d="M84 8 Q90 2 96 8"/>
            </svg>
        </div>
        <div class="flex items-center gap-4">
            <a href="#" class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
            </a>
            <a href="#" class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37zm1.5-4.87h.01M7.5 20.5h9a5 5 0 0 0 5-5v-9a5 5 0 0 0-5-5h-9a5 5 0 0 0-5 5v9a5 5 0 0 0 5 5z"/></svg>
            </a>
            <a href="#" class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58a2.78 2.78 0 0 0 1.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.47a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58zM10 15.5V8.5l6 3.5-6 3.5z"/></svg>
            </a>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-2 md:grid-cols-4 gap-8 border-b border-gray-200">
        <div>
            <h4 class="text-[11px] font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">WISATA</h4>
            <ul class="space-y-2.5">
                @foreach(['Tempat wisata Sukabumi','Wisata alam','Wisata pantai','Hiking & trekking','Arung jeram','Kuliner & makanan','Belanja oleh-oleh','Penginapan'] as $l)
                <li><a href="#" class="text-[13px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition">{{ $l }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="text-[11px] font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">DESTINASI POPULER</h4>
            <ul class="space-y-2.5">
                @foreach(['Geopark Ciletuh','Situ Gunung','Pelabuhan Ratu','Curug Cikaso','Curug Luhur','Pantai Ujung Genteng','Taman Nasional Halimun','Gunung Gede Pangrango'] as $l)
                <li><a href="#" class="text-[13px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition">{{ $l }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="text-[11px] font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">AKTIVITAS TERBAIK</h4>
            <ul class="space-y-2.5">
                @foreach(['Arung Jeram Citarik','Jembatan Situ Gunung','Snorkeling Ujung Genteng','Surfing Palabuhanratu','Glamping Halimun','Wisata Edukasi Geopark','Bersepeda Selabintana','Camping Curug'] as $l)
                <li><a href="#" class="text-[13px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition">{{ $l }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="text-[11px] font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">PANDUAN PERJALANAN</h4>
            <ul class="space-y-2.5">
                @foreach(['Cara ke Sukabumi','Transportasi lokal','Peta wisata Sukabumi','Tips keselamatan','Hotel & penginapan','Paket wisata','Kontak darurat','Tentang Visit Sukabumi'] as $l)
                <li><a href="#" class="text-[13px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition">{{ $l }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="bg-[#1a6bbf]">
        <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <span class="text-white text-[15px] font-black tracking-tight">VISIT SUKABUMI</span>
                <span class="block text-blue-200 text-[11px] mt-0.5">Didukung oleh Dinas Pariwisata Kabupaten Sukabumi</span>
            </div>
            <div class="flex flex-wrap gap-x-6 gap-y-2">
                @foreach(['Hubungi Kami','Tentang Kami','Kebijakan Privasi','Aksesibilitas','Syarat & Ketentuan'] as $link)
                <a href="#" class="text-blue-100 hover:text-white text-[12px] font-medium transition">{{ $link }}</a>
                @endforeach
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 pb-5">
            <p class="text-blue-200 text-[11px] leading-relaxed max-w-3xl">Visit Sukabumi adalah platform panduan wisata resmi untuk Kabupaten dan Kota Sukabumi. Kami mendukung pariwisata lokal dan UMKM.</p>
        </div>
    </div>
</footer>
