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
