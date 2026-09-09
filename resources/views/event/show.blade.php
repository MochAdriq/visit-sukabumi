@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900">
    @include('components.navbar')

    <main class="pt-20">

        {{-- ══ HERO IMAGE ══ --}}
        <div class="w-full h-72 md:h-96 relative bg-gray-900 overflow-hidden">
            @if($event->image_path)
                <img src="{{ Storage::url($event->image_path) }}"
                     alt="{{ $event->title }}"
                     class="w-full h-full object-cover opacity-75"/>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>

            {{-- Date Badge --}}
            <div class="absolute top-6 left-6 bg-white rounded-xl px-4 py-2 text-center shadow-lg">
                <div class="text-[11px] font-black text-red-500 uppercase tracking-widest">{{ $event->start_date->translatedFormat('M Y') }}</div>
                <div class="text-3xl font-black text-gray-900 leading-none">{{ $event->start_date->format('d') }}</div>
            </div>

            {{-- Title over hero --}}
            <div class="absolute bottom-0 inset-x-0 px-4 pb-8 md:px-8 max-w-7xl mx-auto">
                <h1 class="text-2xl md:text-4xl font-extrabold text-white drop-shadow-lg leading-tight">
                    {{ $event->title }}
                </h1>
            </div>
        </div>

        {{-- ══ BREADCRUMB ══ --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-2">
            <nav class="flex text-sm text-gray-500 gap-2 items-center flex-wrap">
                <a href="{{ url('/') }}" class="hover:underline hover:text-gray-900">Home</a>
                <span>›</span>
                <span class="text-gray-900 font-medium">{{ $event->title }}</span>
            </nav>
        </div>

        {{-- ══ CONTENT GRID ══ --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

                {{-- ── LEFT: Main Content ── --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- About --}}
                    <div class="border-b border-gray-100 pb-8">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4">Tentang Event Ini</h2>
                        @if($event->description)
                            <div class="prose prose-sm md:prose-base max-w-none text-gray-700 leading-relaxed">
                                {!! $event->description !!}
                            </div>
                        @else
                            <p class="text-gray-400 italic">Belum ada deskripsi untuk event ini.</p>
                        @endif
                    </div>

                    {{-- Event Info Chips --}}
                    <div class="border-b border-gray-100 pb-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi Acara</h2>
                        <div class="flex flex-wrap gap-3">
                            {{-- Date Start --}}
                            <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-lg text-sm text-gray-700">
                                <svg class="w-4 h-4 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span><strong>Mulai:</strong> {{ $event->start_date->translatedFormat('l, d F Y · H:i') }} WIB</span>
                            </div>
                            {{-- Date End --}}
                            @if($event->end_date)
                            <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-lg text-sm text-gray-700">
                                <svg class="w-4 h-4 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span><strong>Selesai:</strong> {{ $event->end_date->translatedFormat('l, d F Y · H:i') }} WIB</span>
                            </div>
                            @endif
                            {{-- Location --}}
                            @if($event->location_name)
                            <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-lg text-sm text-gray-700">
                                <svg class="w-4 h-4 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ $event->location_name }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- ── RIGHT: CTA Sidebar ── --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-5">

                        {{-- Event Status --}}
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-sm font-bold text-green-600">Event Akan Datang</span>
                        </div>

                        {{-- Date Summary --}}
                        <div>
                            <p class="text-2xl font-extrabold text-gray-900">{{ $event->start_date->translatedFormat('d F Y') }}</p>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $event->start_date->format('H:i') }} WIB
                                @if($event->end_date)
                                    – {{ $event->end_date->format('H:i') }} WIB
                                @endif
                            </p>
                        </div>

                        @if($event->location_name)
                        <div class="flex items-start gap-2 text-sm text-gray-600 pb-4 border-b border-gray-100">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $event->location_name }}</span>
                        </div>
                        @endif

                        {{-- WhatsApp CTA --}}
                        @php
                            $waText = "Halo Admin Visit Sukabumi! Saya tertarik dengan event *" . $event->title . "* pada tanggal *" . $event->start_date->translatedFormat('d F Y') . "*. Mohon info selengkapnya 🙏";
                            $waPhone = env('ADMIN_WHATSAPP_NUMBER', '6281234567890');
                        @endphp
                        <a href="https://wa.me/{{ $waPhone }}?text={{ urlencode($waText) }}"
                           target="_blank"
                           class="w-full flex items-center justify-center gap-2 bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold py-3.5 px-6 rounded-full transition shadow text-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Tanya / Daftar via WhatsApp
                        </a>

                        <p class="text-xs text-gray-400 text-center">Klik tombol di atas untuk menghubungi admin dan mendapatkan informasi lebih lanjut.</p>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <x-footer />
</div>
@endsection
