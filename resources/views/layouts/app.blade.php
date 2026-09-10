<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>{{ config('app.name', 'Visit Sukabumi') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700,900" rel="stylesheet" />

    <!-- Lottie Player (Web Component) -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

    <!-- Vite CSS -->
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased">
    @yield('content')
    
    <!-- GLightbox JS -->
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
