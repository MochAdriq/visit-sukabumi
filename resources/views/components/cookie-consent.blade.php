{{-- COOKIE CONSENT BANNER & INTERACTIVE PREFERENCE MODAL --}}
<div x-data="{
    showBanner: false,
    showModal: false,
    preferences: {
        essential: true,
        analytics: true,
        location: true
    },
    init() {
        const saved = localStorage.getItem('visit_sukabumi_cookie_consent');
        if (!saved) {
            setTimeout(() => { this.showBanner = true; }, 1200);
        } else {
            try {
                this.preferences = Object.assign(this.preferences, JSON.parse(saved));
            } catch(e) {}
        }

        window.addEventListener('open-cookie-modal', () => {
            this.showModal = true;
        });
    },
    acceptAll() {
        this.preferences = { essential: true, analytics: true, location: true };
        localStorage.setItem('visit_sukabumi_cookie_consent', JSON.stringify(this.preferences));
        this.showBanner = false;
        this.showModal = false;
    },
    rejectAll() {
        this.preferences = { essential: true, analytics: false, location: false };
        localStorage.setItem('visit_sukabumi_cookie_consent', JSON.stringify(this.preferences));
        this.showBanner = false;
        this.showModal = false;
    },
    savePreferences() {
        this.preferences.essential = true;
        localStorage.setItem('visit_sukabumi_cookie_consent', JSON.stringify(this.preferences));
        this.showBanner = false;
        this.showModal = false;
    }
}" x-cloak>

    {{-- 1. FLOATING BOTTOM BANNER --}}
    <div x-show="showBanner" 
         x-transition:enter="transition ease-out duration-500 transform"
         x-transition:enter-start="translate-y-full opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-300 transform"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-full opacity-0"
         class="fixed bottom-4 sm:bottom-6 inset-x-4 sm:inset-x-auto sm:right-6 sm:max-w-md bg-white/95 backdrop-blur-md rounded-2xl border border-gray-200 shadow-2xl p-5 z-50">
        
        <div class="flex items-start gap-3.5 mb-3">
            <div class="w-10 h-10 rounded-xl bg-[#1a6bbf]/10 text-[#1a6bbf] flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-sm">Privasi & Penggunaan Cookie</h4>
                <p class="text-xs text-gray-600 leading-relaxed mt-1">
                    Kami menggunakan cookie untuk memastikan pengalaman jelajah terbaik, personalisasi rekomendasi destinasi terdekat, serta analisis performa situs.
                </p>
            </div>
        </div>

        <div class="flex items-center justify-between gap-2 pt-2 border-t border-gray-100 text-xs">
            <button type="button" @click="showModal = true" class="text-gray-500 hover:text-gray-900 font-semibold underline underline-offset-2">
                Atur Cookie
            </button>
            <div class="flex items-center gap-2">
                <button type="button" @click="rejectAll()" class="px-3 py-1.5 rounded-lg text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold transition">
                    Tolak
                </button>
                <button type="button" @click="acceptAll()" class="px-4 py-1.5 rounded-lg text-white bg-[#1a6bbf] hover:bg-[#145299] font-bold transition shadow-xs">
                    Terima Semua
                </button>
            </div>
        </div>
    </div>

    {{-- 2. INTERACTIVE PREFERENCES MODAL --}}
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        {{-- Backdrop --}}
        <div x-show="showModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showModal = false" 
             class="fixed inset-0 bg-black/50 backdrop-blur-xs"></div>

        {{-- Dialog Box --}}
        <div x-show="showModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-gray-100 z-10 max-h-[90vh] overflow-y-auto">
            
            {{-- Header --}}
            <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#1a6bbf] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-gray-900 text-lg sm:text-xl">Pusat Pengaturan Cookie</h3>
                        <p class="text-xs text-gray-500">Kelola izin dan preferensi data peramban Anda</p>
                    </div>
                </div>
                <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-full hover:bg-gray-100 transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-6">
                Kami menghargai privasi Anda. Anda dapat memilih kategori cookie yang diizinkan untuk aktif selama menjelajahi platform Visit Sukabumi.
            </p>

            {{-- Categories list --}}
            <div class="space-y-4">
                {{-- 1. Essential --}}
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-900 text-sm">Cookie Esensial</span>
                            <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-blue-100 text-blue-700">Wajib</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Diperlukan untuk fungsionalitas dasar seperti sesi login, keamanan form token, dan penyimpanan daftar wishlist Anda.
                        </p>
                    </div>
                    <input type="checkbox" checked disabled class="mt-1 w-4 h-4 text-[#1a6bbf] rounded cursor-not-allowed opacity-70">
                </div>

                {{-- 2. Analytics --}}
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-900 text-sm">Cookie Analitik & Kinerja</span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-gray-200 text-gray-700">Opsional</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Membantu kami memahami statistik pengunjung guna mengevaluasi destinasi dan fasilitas wisata yang paling digemari.
                        </p>
                    </div>
                    <input type="checkbox" x-model="preferences.analytics" class="mt-1 w-4 h-4 text-[#1a6bbf] rounded focus:ring-[#1a6bbf] cursor-pointer">
                </div>

                {{-- 3. Location & Personalization --}}
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-900 text-sm">Cookie Preferensi & Lokasi</span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-gray-200 text-gray-700">Opsional</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Mengingat preferensi tampilan serta izin lokasi Anda untuk menghitung jarak tempuh destinasi terdekat secara instan.
                        </p>
                    </div>
                    <input type="checkbox" x-model="preferences.location" class="mt-1 w-4 h-4 text-[#1a6bbf] rounded focus:ring-[#1a6bbf] cursor-pointer">
                </div>
            </div>

            {{-- Modal Actions --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-6 mt-6 border-t border-gray-100">
                <button type="button" @click="rejectAll()" class="w-full sm:w-auto text-xs font-bold text-gray-600 hover:text-gray-900 py-2.5 px-4 rounded-xl hover:bg-gray-100 transition cursor-pointer">
                    Tolak Non-Esensial
                </button>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="button" @click="savePreferences()" class="flex-1 sm:flex-initial text-xs font-bold text-gray-800 bg-gray-100 hover:bg-gray-200 py-2.5 px-5 rounded-xl transition cursor-pointer">
                        Simpan Pengaturan
                    </button>
                    <button type="button" @click="acceptAll()" class="flex-1 sm:flex-initial text-xs font-bold text-white bg-[#1a6bbf] hover:bg-[#145299] py-2.5 px-6 rounded-xl transition shadow-xs cursor-pointer">
                        Terima Semua
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
