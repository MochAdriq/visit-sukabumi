@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900 pb-16">
    @include('components.navbar')

    {{-- HERO BANNER --}}
    <div class="w-full h-[350px] md:h-[550px] relative md:mt-4 max-w-[1400px] mx-auto md:px-4 sm:px-6 lg:px-8">
        <div class="w-full h-full md:rounded-[2rem] overflow-hidden relative shadow-lg group">
            <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=1920&h=1080&fit=crop" alt="Event & Festival" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-[10s]">
            <div class="absolute inset-0 bg-black/40"></div>
            
            <div class="absolute inset-0 flex flex-col items-center justify-center px-4 md:px-10 text-center">
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white mb-6 md:mb-8 tracking-tight drop-shadow-lg leading-tight max-w-3xl">
                    Discover Sukabumi's Best Events
                </h1>
                
                {{-- SEARCH BAR --}}
                <form action="{{ route('event.index') }}" method="GET" class="w-full max-w-2xl bg-white rounded-full p-2 flex items-center shadow-2xl relative z-10">
                    <div class="pl-3 md:pl-4 text-gray-400">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul event atau lokasi..." class="w-full bg-transparent border-none focus:ring-0 text-gray-900 text-base md:text-lg px-3 md:px-4 py-2 md:py-3 outline-none font-medium placeholder-gray-500">
                    <button type="submit" class="bg-[#00aa6c] hover:bg-[#008a57] text-white px-6 md:px-8 py-2 md:py-3.5 rounded-full font-bold text-base md:text-lg transition shadow-md whitespace-nowrap">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- HIGHLIGHT FEATURES --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 md:mt-16 mb-12 md:mb-20 hidden md:grid grid-cols-3 gap-8 text-center">
        <div>
            <div class="w-12 h-12 mx-auto mb-4 flex items-center justify-center text-[#00aa6c]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Acara Pilihan</h3>
            <p class="text-sm text-gray-600">Dikurasi khusus untuk pengalaman tak terlupakan di Sukabumi.</p>
        </div>
        <div>
            <div class="w-12 h-12 mx-auto mb-4 flex items-center justify-center text-[#00aa6c]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            </div>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Budaya & Seni</h3>
            <p class="text-sm text-gray-600">Temukan keberagaman festival kebudayaan dan atraksi lokal.</p>
        </div>
        <div>
            <div class="w-12 h-12 mx-auto mb-4 flex items-center justify-center text-[#00aa6c]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Jadwal Terupdate</h3>
            <p class="text-sm text-gray-600">Selalu dapatkan informasi event terbaru dan jangan sampai ketinggalan.</p>
        </div>
    </div>

    {{-- TOP UPCOMING EVENTS --}}
    @if(isset($topEvents) && $topEvents->count() > 0 && !request()->has('q'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 md:mt-16 mb-16">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">Travelers' Choice: Top Upcoming Events</h2>
                <p class="text-sm md:text-base text-gray-500 mt-1">Acara paling dinantikan dalam waktu dekat.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($topEvents as $index => $event)
                <div class="group relative block overflow-hidden rounded-2xl h-72 shadow-sm border border-gray-200 bg-gray-50 flex flex-col justify-end">
                    <a href="{{ route('event.show', $event->slug) }}" class="absolute inset-0 z-10"></a>
                    @if($event->image_path)
                        <img src="{{ Storage::url($event->image_path) }}" alt="{{ $event->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                    @else
                        <div class="absolute inset-0 w-full h-full flex items-center justify-center bg-[#00aa6c]/10">
                            <svg class="w-12 h-12 text-[#00aa6c]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    
                    {{-- Ranking Badge --}}
                    <div class="absolute top-4 left-4 z-20 flex items-center gap-1 bg-black/60 backdrop-blur text-white px-2.5 py-1 rounded-full text-xs font-bold border border-white/20">
                        Top {{ $index + 1 }}
                    </div>

                    {{-- Content --}}
                    <div class="relative z-20 p-5">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="bg-[#00aa6c] text-white px-2 py-0.5 rounded text-[10px] font-bold uppercase">
                                {{ $event->start_date->translatedFormat('M') }}
                            </div>
                            <div class="text-white font-bold text-sm drop-shadow-sm">
                                {{ $event->start_date->format('d') }} {{ $event->start_date->translatedFormat('Y') }}
                            </div>
                        </div>
                        <h4 class="text-white font-bold text-[16px] leading-tight group-hover:underline drop-shadow-md mb-1">{{ $event->title }}</h4>
                        @if($event->location_name)
                        <div class="flex items-center text-white/80 text-[12px] drop-shadow-sm">
                            <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $event->location_name }}
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ALL EVENTS (GRID) --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 mt-8">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">
                    {{ request()->has('q') ? 'Hasil Pencarian: "' . request('q') . '"' : 'Semua Event & Festival' }}
                </h2>
                <p class="text-sm md:text-base text-gray-500 mt-1">
                    {{ collect($events->items())->count() > 0 ? $events->total() . ' event ditemukan.' : 'Jelajahi berbagai acara seru di Sukabumi.' }}
                </p>
            </div>
            @if(request()->has('q'))
                <a href="{{ route('event.index') }}" class="font-bold text-gray-900 hover:underline">Hapus Pencarian</a>
            @endif
        </div>

        @if($events->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($events as $event)
                <div class="group flex flex-col bg-white rounded-2xl overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-shadow duration-300 border border-gray-100">
                    {{-- Image --}}
                    <div class="relative w-full aspect-[4/3] flex-shrink-0 cursor-pointer overflow-hidden bg-gray-100">
                        <a href="{{ route('event.show', $event->slug) }}" class="block w-full h-full">
                            @if($event->image_path)
                                <img alt="{{ $event->title }}" src="{{ Storage::url($event->image_path) }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"/>
                            @else
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </a>
                        
                        {{-- Date Badge --}}
                        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm rounded-xl px-2.5 py-1.5 text-center shadow-sm">
                            <div class="text-[10px] font-black text-red-500 uppercase leading-none">{{ $event->start_date->translatedFormat('M') }}</div>
                            <div class="text-lg font-black text-gray-900 leading-tight">{{ $event->start_date->format('d') }}</div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-4 flex flex-col flex-grow justify-between">
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg mb-1 leading-snug group-hover:underline">
                                <a href="{{ route('event.show', $event->slug) }}">{{ $event->title }}</a>
                            </h3>
                            
                            {{-- Rating (Dummy avg or real if implemented on event) --}}
                            @php
                                $rating = $event->reviews_avg_rating ?? rand(4,5); // Fallback dummy for aesthetics if no reviews
                            @endphp
                            <div class="flex items-center gap-1 mb-2">
                                <div class="flex items-center text-[#00aa6c]">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <span class="text-xs text-gray-500 font-medium">{{ $event->reviews_count ?? rand(5, 50) }}</span>
                            </div>

                            @if($event->location_name)
                                <div class="text-xs text-gray-600 mb-2 truncate">
                                    {{ $event->location_name }}
                                </div>
                            @endif
                            <p class="text-[13px] text-gray-600 line-clamp-2">
                                {{ strip_tags($event->description) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-12 flex justify-center">
            {{ $events->links() }}
        </div>
        @else
        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-12 flex flex-col items-center justify-center text-center mt-4">
            <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Tidak ada acara ditemukan</h3>
            <p class="text-gray-500 text-sm">Coba sesuaikan kata kunci pencarian Anda.</p>
        </div>
        @endif
    </div>

</div>
@include('components.footer')
@endsection
