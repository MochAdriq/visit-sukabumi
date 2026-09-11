@extends('layouts.app')

@section('title', $tag->name . ' di Sukabumi — Visit Sukabumi')
@section('meta_description', $tag->description ?? 'Temukan ' . $tag->name . ' terbaik di Sukabumi.')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans text-gray-900 pb-16">
    @include('components.navbar')

    {{-- ── HERO HEADER ─────────────────────────────────────────────────── --}}
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">

            {{-- Breadcrumb --}}
            <nav class="flex text-sm text-gray-500 gap-2 items-center mb-5 flex-wrap">
                <a href="{{ url('/') }}" class="hover:underline hover:text-[#1a6bbf] transition-colors">Home</a>
                <span>›</span>
                <span class="text-gray-400">{{ $tag->type_label }}</span>
                <span>›</span>
                <span class="text-gray-900 font-semibold">{{ $tag->name }}</span>
            </nav>

            <div class="flex items-start gap-5">
                {{-- Icon --}}
                <div class="w-14 h-14 rounded-2xl bg-[#e8f5f0] flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-[#00aa6c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $tag->icon_svg !!}
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">
                        {{ $tag->name }}
                    </h1>
                    @if($tag->description)
                        <p class="mt-2 text-gray-600 text-base md:text-lg max-w-3xl leading-relaxed">
                            {{ $tag->description }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Navigasi tag terkait (satu tipe) --}}
            @if($relatedTags->count() > 0)
                <div class="mt-8 flex flex-wrap gap-2">
                    @foreach($relatedTags as $rt)
                        <a href="{{ $rt->url }}"
                           class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full border border-gray-200 text-sm font-semibold text-gray-600 hover:border-[#00aa6c] hover:text-[#00aa6c] hover:bg-[#f0faf6] transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $rt->icon_svg !!}
                            </svg>
                            {{ $rt->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <main class="pt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- MAIN LAYOUT (Sidebar + List) --}}
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- SIDEBAR FILTER --}}
            <div class="w-full lg:w-1/4 flex-shrink-0">
                <div class="bg-white border border-gray-200 rounded-2xl p-5 sticky top-24 shadow-sm">
                    <h3 class="font-extrabold text-gray-900 text-lg mb-4">Pencarian</h3>
                    <form action="{{ request()->url() }}" method="GET" class="space-y-5">

                        {{-- Search Input --}}
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="q" value="{{ request('q') }}"
                                   placeholder="Cari nama tempat..."
                                   class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#00aa6c] focus:border-[#00aa6c] outline-none transition-all bg-gray-50 text-sm">
                        </div>

                        {{-- Urutkan --}}
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3 text-sm">Urutkan</h4>
                            <div class="space-y-2">
                                @foreach(['popular' => 'Paling Populer', 'rating' => 'Rating Tertinggi', 'newest' => 'Terbaru', 'name' => 'Nama A-Z'] as $val => $label)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="sort" value="{{ $val }}"
                                               {{ $sort === $val ? 'checked' : '' }}
                                               onchange="this.form.submit()"
                                               class="w-4 h-4 text-[#00aa6c] focus:ring-[#00aa6c] border-gray-300">
                                        <span class="text-sm text-gray-700 group-hover:text-gray-900">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full py-2.5 bg-gray-900 hover:bg-black text-white font-bold rounded-xl shadow-sm transition-colors text-sm">
                            Terapkan
                        </button>
                    </form>
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="flex-1">
                {{-- Header Tools --}}
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">
                        {{ $places->total() }} tempat ditemukan
                        @if(request('q'))
                            <span class="text-base font-normal text-gray-500">untuk "<span class="text-gray-800 font-semibold">{{ request('q') }}</span>"</span>
                        @endif
                    </h2>
                </div>

                @if($places->count() > 0)
                    <div class="flex flex-col gap-5">
                        @foreach($places as $place)
                            <x-place-card-list :place="$place" />
                        @endforeach
                    </div>

                    {{-- PAGINATION --}}
                    <div class="mt-10">
                        {{ $places->links() }}
                    </div>
                @else
                    {{-- EMPTY STATE --}}
                    <div class="bg-white rounded-2xl border border-gray-100 p-12 flex flex-col items-center justify-center text-center shadow-sm">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada destinasi di sini</h3>
                        <p class="text-gray-500 max-w-md mx-auto mb-6">
                            Kami sedang mengumpulkan destinasi terbaik untuk kategori <strong>{{ $tag->name }}</strong>. Pantau terus ya!
                        </p>
                        <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-gray-300 shadow-sm text-sm font-bold rounded-full text-gray-900 bg-white hover:bg-gray-50 transition-colors">
                            Kembali ke Beranda
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </main>
</div>
@endsection
