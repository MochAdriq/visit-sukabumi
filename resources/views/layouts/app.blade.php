<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $pageTitle = trim($__env->yieldContent('title'));
        $defaultTitle = 'Visit Sukabumi - Panduan digital untuk menjelajah Sukabumi';
        $metaTitle = $pageTitle ?: $defaultTitle;

        $pageDesc = trim($__env->yieldContent('meta_description'));
        $defaultDesc = 'Visit Sukabumi adalah platform digital yang menghubungkan wisatawan, pelaku bisnis, dan pemerintah dalam satu ekosistem pariwisata. Temukan destinasi wisata, event, penginapan, dan kuliner terbaik di Kabupaten Sukabumi.';
        $metaDesc = $pageDesc ?: $defaultDesc;

        $ogTitle = trim($__env->yieldContent('og_title')) ?: $metaTitle;
        $ogDesc  = trim($__env->yieldContent('og_description')) ?: $metaDesc;
        $ogImage = trim($__env->yieldContent('og_image')) ?: asset('assets/images/og-default.jpg');
        $ogUrl   = trim($__env->yieldContent('canonical')) ?: url()->current();

        // Hindari .avif untuk og:image karena WhatsApp/FB crawler tidak mendukung AVIF
        if (str_ends_with(strtolower(strtok($ogImage, '?')), '.avif')) {
            $ogImage = asset('assets/images/og-default.jpg');
        }

        // Pastikan ogImage dan ogUrl menggunakan protokol https jika request secure
        if (request()->isSecure() || str_starts_with(url()->current(), 'https://')) {
            $ogImage = preg_replace('/^http:/i', 'https:', $ogImage);
            $ogUrl   = preg_replace('/^http:/i', 'https:', $ogUrl);
        }

        $imagePathOnly = strtolower(strtok($ogImage, '?'));
        $ogImageType = trim($__env->yieldContent('og_image_type')) ?: (
            str_ends_with($imagePathOnly, '.png') ? 'image/png' :
            (str_ends_with($imagePathOnly, '.webp') ? 'image/webp' :
            (str_ends_with($imagePathOnly, '.gif') ? 'image/gif' : 'image/jpeg'))
        );
    @endphp

    {{-- ══ SEO: Title & Meta Dasar ══ --}}
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDesc }}">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="{{ $ogUrl }}">

    {{-- ══ Open Graph (WhatsApp, Facebook, Telegram, LinkedIn) ══ --}}
    <meta property="og:site_name"        content="Visit Sukabumi">
    <meta property="og:locale"           content="id_ID">
    <meta property="og:type"             content="@yield('og_type', 'website')">
    <meta property="og:title"            content="{{ $ogTitle }}">
    <meta property="og:description"      content="{{ $ogDesc }}">
    <meta property="og:url"              content="{{ $ogUrl }}">
    <meta property="og:image"            content="{{ $ogImage }}">
    <meta property="og:image:secure_url" content="{{ $ogImage }}">
    <meta property="og:image:type"       content="{{ $ogImageType }}">
    <meta property="og:image:width"      content="1200">
    <meta property="og:image:height"     content="630">
    <meta property="og:image:alt"        content="@yield('og_image_alt', 'Visit Sukabumi')">

    {{-- ══ Twitter / X Card ══ --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:site"        content="@visitsukabumi">
    <meta name="twitter:title"       content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDesc }}">
    <meta name="twitter:image"       content="{{ $ogImage }}">

    {{-- ══ Structured Data / JSON-LD (per-halaman) ══ --}}
    @stack('structured_data')

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700,900" rel="stylesheet"/>

    {{-- Lottie Player --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- GLightbox CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css"/>

    {{-- Vite CSS --}}
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased">
    {{-- Global Flash Notification (Toast) --}}
    @if(session('error') || session('success') || session('status'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 6000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-3"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-3"
             class="fixed top-5 right-5 z-[9999] max-w-sm w-full px-4 pointer-events-auto">
            @if(session('error'))
                <div class="bg-red-600 text-white px-4 py-3 rounded-2xl shadow-2xl flex items-center justify-between gap-3 text-xs font-semibold">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 flex-shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-white/70 hover:text-white p-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @elseif(session('success') || session('status'))
                <div class="bg-emerald-600 text-white px-4 py-3 rounded-2xl shadow-2xl flex items-center justify-between gap-3 text-xs font-semibold">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 flex-shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>{{ session('success') ?? session('status') }}</span>
                    </div>
                    <button @click="show = false" class="text-white/70 hover:text-white p-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
        </div>
    @endif

    @yield('content')

    {{-- ════════════════════════════════════════════
         FLOATING CORNER AD WIDGET (Bisnis.com Gambar 3)
         ════════════════════════════════════════════ --}}
    @php
        $floatingAd = \App\Models\Advertisement::getRandomAd('floating_corner');
    @endphp
    @if($floatingAd)
        <div x-data="{ dismissed: false }" 
             x-show="!dismissed"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 scale-95"
             class="fixed bottom-5 right-5 z-[9990] max-w-[280px] sm:max-w-[320px] w-full pointer-events-auto">
            
            <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                <div class="flex items-center justify-between px-3 py-1.5 bg-gray-50 border-b border-gray-100 text-[11px] font-semibold text-gray-500">
                    <span class="inline-flex items-center gap-1 uppercase tracking-wider text-[10px] font-extrabold text-[#1a6bbf]">
                        Sponsor Pilihan
                    </span>
                    <button @click="dismissed = true" type="button" class="text-gray-400 hover:text-gray-700 p-0.5 rounded cursor-pointer transition-colors" aria-label="Tutup">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <a href="{{ $floatingAd->url ?? '#' }}" target="{{ ($floatingAd->open_in_new_tab || (isset($floatingAd->url) && str_starts_with($floatingAd->url, 'http'))) ? '_blank' : '_self' }}" rel="noopener noreferrer" class="block w-full">
                    <img src="{{ $floatingAd->image_url }}" alt="{{ $floatingAd->title }}" class="w-full h-auto object-cover max-h-[160px]">
                </a>
                @if($floatingAd->title)
                <div class="p-2.5 bg-white">
                    <p class="text-xs font-bold text-gray-900 truncate">{{ $floatingAd->title }}</p>
                </div>
                @endif
            </div>
        </div>
    @endif

    {{-- ════════════════════════════════════════════
         POPUP / INTERSTITIAL MODAL (Bisnis.com Gambar 2)
         ════════════════════════════════════════════ --}}
    @php
        $popupAd = \App\Models\Advertisement::getRandomAd('popup_interstitial');
    @endphp
    @if($popupAd)
        <div x-data="{ 
                open: false,
                init() {
                    if (!sessionStorage.getItem('vs_popup_seen')) {
                        setTimeout(() => {
                            this.open = true;
                            sessionStorage.setItem('vs_popup_seen', 'true');
                        }, 2000);
                    }
                }
             }"
             x-show="open" 
             style="display: none;"
             class="fixed inset-0 z-[99999] flex items-center justify-center p-4">
            
            <!-- Backdrop -->
            <div @click="open = false" 
                 x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black/70 backdrop-blur-xs"></div>

            <!-- Modal Card -->
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden border border-white/20 z-10">
                
                <button @click="open = false" type="button" class="absolute top-3 right-3 z-20 w-8 h-8 rounded-full bg-black/60 hover:bg-black text-white flex items-center justify-center cursor-pointer transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <a href="{{ $popupAd->url ?? '#' }}" target="{{ ($popupAd->open_in_new_tab || (isset($popupAd->url) && str_starts_with($popupAd->url, 'http'))) ? '_blank' : '_self' }}" rel="noopener noreferrer" class="block w-full">
                    <img src="{{ $popupAd->image_url }}" alt="{{ $popupAd->title }}" class="w-full h-auto object-cover max-h-[360px]">
                </a>
                
                <div class="p-4 bg-white flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-[#1a6bbf] bg-blue-50 px-2 py-0.5 rounded">Sponsor Resmi</span>
                        <h3 class="text-sm font-bold text-gray-900 mt-1 truncate">{{ $popupAd->title }}</h3>
                    </div>
                    <button @click="open = false" type="button" class="px-4 py-1.5 bg-gray-100 hover:bg-gray-200 rounded-full text-xs font-bold text-gray-700 transition flex-shrink-0 cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- GLightbox JS --}}
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
