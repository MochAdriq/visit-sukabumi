@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans text-gray-900 pb-16">
    @include('components.navbar')

    {{-- Hero Section --}}
    <div class="relative bg-gray-900 text-white py-24 px-4 sm:px-6 lg:px-8 mb-12">
        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=1920&h=600&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-overlay" alt="Traveller Guide">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent"></div>
        <div class="relative max-w-4xl mx-auto text-center z-10">
            <h1 class="text-4xl md:text-5xl font-black tracking-tight mb-4 uppercase">Panduan Perjalanan</h1>
            <p class="text-lg text-gray-300">Segala informasi yang Anda butuhkan untuk merencanakan liburan sempurna ke Sukabumi.</p>
        </div>
    </div>

    {{-- Main Content --}}
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        {{-- Section 1: Cara Ke Sukabumi --}}
        <section class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Cara Ke Sukabumi</h2>
            </div>
            <div class="prose max-w-none text-gray-700">
                <p>Sukabumi kini semakin mudah diakses dari Jakarta dan sekitarnya. Berikut adalah beberapa pilihan transportasi terbaik:</p>
                <ul class="list-disc pl-5 mt-4 space-y-2">
                    <li><strong>Kereta Api Pangrango:</strong> Pilihan paling nyaman dan bebas macet. Anda bisa naik dari Stasiun Bogor menuju Stasiun Sukabumi. Waktu tempuh sekitar 2 jam dengan pemandangan alam yang sangat indah sepanjang perjalanan.</li>
                    <li><strong>Mobil Pribadi (Tol Bocimi):</strong> Dengan beroperasinya Tol Bocimi (Bogor-Ciawi-Sukabumi), perjalanan dari Jakarta kini bisa ditempuh dalam waktu kurang dari 2.5 jam (bergantung pada kondisi lalu lintas).</li>
                    <li><strong>Bus / Travel:</strong> Terdapat banyak layanan travel eksekutif (seperti Baraya atau Xtrans) yang berangkat dari Jakarta, Depok, maupun Bandung langsung ke pusat kota Sukabumi.</li>
                </ul>
            </div>
        </section>

        {{-- Section 2: Transportasi Lokal --}}
        <section class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Transportasi Lokal</h2>
            </div>
            <div class="prose max-w-none text-gray-700">
                <p>Untuk berkeliling Sukabumi dan mengeksplorasi destinasi eksotis seperti Geopark Ciletuh atau Ujung Genteng, disarankan untuk menyewa kendaraan karena angkutan umum belum sepenuhnya menjangkau kawasan pelosok secara optimal.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <h3 class="font-bold text-gray-900 mb-1">Sewa Motor</h3>
                        <p class="text-sm">Cocok untuk mobilitas tinggi dan jalan-jalan santai di sekitar Palabuhanratu atau pusat kota. Harga sewa berkisar Rp 80.000 - Rp 150.000 / hari.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <h3 class="font-bold text-gray-900 mb-1">Sewa Mobil (Rental)</h3>
                        <p class="text-sm">Sangat disarankan jika bepergian bersama keluarga ke area pegunungan atau Geopark. Harga mulai dari Rp 400.000 / hari (sudah termasuk supir lokal).</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 3: Waktu Terbaik Berkunjung --}}
        <section class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Cuaca & Waktu Terbaik</h2>
            </div>
            <div class="prose max-w-none text-gray-700">
                <p>Sukabumi memiliki bentang alam yang bervariasi mulai dari pantai di selatan hingga pegunungan di utara. Pastikan Anda merencanakan perjalanan sesuai dengan musim.</p>
                <ul class="list-disc pl-5 mt-4 space-y-2">
                    <li><strong>Musim Kemarau (Mei - September):</strong> Waktu terbaik untuk mengunjungi Pantai, berselancar di Cimaja, atau berfoto di bukit-bukit Geopark Ciletuh tanpa gangguan hujan.</li>
                    <li><strong>Musim Hujan (Oktober - April):</strong> Waktu yang sangat ideal untuk mengunjungi curug (air terjun) seperti Curug Cikaso atau Curug Sodong, karena debit air sedang tinggi dan pemandangannya sangat megah.</li>
                </ul>
            </div>
        </section>

    </main>

    @include('components.footer')
</div>
@endsection
