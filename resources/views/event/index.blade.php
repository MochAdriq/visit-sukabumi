@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans text-gray-900 pb-16">
    @include('components.navbar')

    <main class="pt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- BREADCRUMB --}}
        <nav class="flex text-sm text-gray-500 gap-2 items-center mb-6 flex-wrap">
            <a href="{{ url('/') }}" class="hover:underline hover:text-[#1a6bbf] transition-colors">Home</a>
            <span>›</span>
            <span class="text-gray-900 font-medium">Event & Festival</span>
        </nav>

        {{-- PAGE TITLE & HEADER --}}
        <div class="mb-8 md:mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                Event & Festival Mendatang
            </h1>
            <p class="mt-2 text-gray-600 text-base md:text-lg max-w-3xl">
                Jangan lewatkan berbagai keseruan acara, festival budaya, dan hiburan menarik yang diselenggarakan di Sukabumi.
            </p>
        </div>

        {{-- CONTENT GRID --}}
        @if($events->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($events as $event)
                    <a href="{{ route('event.show', $event->slug) }}" class="group relative block overflow-hidden rounded-2xl h-64 shadow-sm border border-gray-100 bg-gray-200">
                        @if($event->image_path)
                            <img src="{{ Storage::url($event->image_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-[#1a6bbf]/10">
                                <svg class="w-12 h-12 text-[#1a6bbf]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute top-4 left-4 bg-white rounded-lg px-2 py-1 text-center shadow">
                            <div class="text-[10px] font-black text-red-500 uppercase">{{ $event->start_date->translatedFormat('M') }}</div>
                            <div class="text-xl font-black text-gray-900 leading-none">{{ $event->start_date->format('d') }}</div>
                        </div>
                        <div class="absolute bottom-0 inset-x-0 p-5">
                            <h4 class="text-white font-bold text-[15px] leading-tight group-hover:underline mb-1">{{ $event->title }}</h4>
                            @if($event->location_name)
                            <div class="flex items-center text-white/80 text-[12px]">
                                <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $event->location_name }}
                            </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div class="mt-12 flex justify-center">
                {{ $events->links() }}
            </div>
        @else
            {{-- EMPTY STATE --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-12 flex flex-col items-center justify-center text-center shadow-sm mt-8">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada event saat ini</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-6">
                    Saat ini tidak ada event atau festival yang dijadwalkan. Silakan periksa kembali nanti!
                </p>
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        @endif
    </main>
</div>
@endsection
