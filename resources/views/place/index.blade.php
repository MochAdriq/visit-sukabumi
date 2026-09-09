@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans text-gray-900 pb-16">
    @include('components.navbar')

    <main class="pt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- BREADCRUMB --}}
        <nav class="flex text-sm text-gray-500 gap-2 items-center mb-6 flex-wrap">
            <a href="{{ url('/') }}" class="hover:underline hover:text-[#1a6bbf] transition-colors">Home</a>
            <span>›</span>
            <span class="text-gray-900 font-medium">
                {{ $currentCategory ? $currentCategory->name : 'Semua Tempat' }}
            </span>
        </nav>

        {{-- PAGE TITLE & HEADER --}}
        <div class="mb-8 md:mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                {{ $currentCategory ? 'Eksplorasi ' . $currentCategory->name . ' Sukabumi' : 'Eksplorasi Semua Destinasi' }}
            </h1>
            <p class="mt-2 text-gray-600 text-base md:text-lg max-w-3xl">
                {{ $currentCategory && $currentCategory->description 
                    ? $currentCategory->description 
                    : 'Temukan berbagai tempat wisata, kuliner lezat, dan penginapan nyaman untuk pengalaman tak terlupakan di Sukabumi.' }}
            </p>
        </div>

        {{-- MAIN LAYOUT (Sidebar + List) --}}
        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- SIDEBAR FILTER --}}
            <div class="w-full lg:w-1/4 flex-shrink-0">
                <div class="bg-white border border-gray-200 rounded-2xl p-5 sticky top-24 shadow-sm">
                    <h3 class="font-extrabold text-gray-900 text-lg mb-4">Pencarian & Filter</h3>
                    <form action="{{ route('place.index') }}" method="GET" class="space-y-6">
                        
                        {{-- Search Input --}}
                        <div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </div>
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama tempat..." class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#00aa6c] focus:border-[#00aa6c] outline-none transition-all bg-gray-50 text-sm">
                            </div>
                        </div>

                        {{-- Category Filter --}}
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3 text-sm">Kategori</h4>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-[#00aa6c] focus:ring-[#00aa6c] border-gray-300">
                                    <span class="text-sm text-gray-700 group-hover:text-gray-900">Semua Kategori</span>
                                </label>
                                @if(isset($allCategories))
                                    @foreach($allCategories as $cat)
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()" class="w-4 h-4 text-[#00aa6c] focus:ring-[#00aa6c] border-gray-300">
                                            <span class="text-sm text-gray-700 group-hover:text-gray-900">{{ $cat->name }}</span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Rating Visual Filter (Simulated) --}}
                        <div class="pt-5 border-t border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-3 text-sm">Rating Traveler</h4>
                            <div class="space-y-3">
                                @foreach([5, 4, 3] as $star)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" class="w-4 h-4 text-[#00aa6c] focus:ring-[#00aa6c] border-gray-300 rounded">
                                        <span class="flex items-center gap-1">
                                            @for($i=1; $i<=5; $i++)
                                                <svg class="w-3.5 h-3.5 {{ $i <= $star ? 'text-[#00aa6c]' : 'text-gray-200' }} fill-current" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>
                                            @endfor
                                            <span class="text-xs text-gray-500 ml-1">& ke atas</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-gray-900 hover:bg-black text-white font-bold rounded-xl shadow-sm transition-colors text-sm mt-4">
                            Terapkan Filter
                        </button>

                    </form>
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="flex-1">
                {{-- Header Tools --}}
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <h2 class="text-xl font-bold text-gray-900">
                        {{ $places->total() }} tempat ditemukan
                    </h2>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <span class="text-sm text-gray-500 hidden sm:inline">Urutkan:</span>
                        <select class="w-full sm:w-auto text-sm border-gray-200 rounded-xl focus:ring-[#00aa6c] focus:border-[#00aa6c] text-gray-700 bg-white shadow-sm py-2 px-4 cursor-pointer">
                            <option>Paling Relevan</option>
                            <option>Rating Tertinggi</option>
                            <option>Ulasan Terbanyak</option>
                        </select>
                    </div>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak ada tempat ditemukan</h3>
                        <p class="text-gray-500 max-w-md mx-auto mb-6">
                            Maaf, kami tidak dapat menemukan tempat yang sesuai dengan pencarian atau kategori Anda saat ini.
                        </p>
                        <a href="{{ route('place.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-gray-300 shadow-sm text-sm font-bold rounded-full text-gray-900 bg-white hover:bg-gray-50 transition-colors">
                            Hapus Semua Filter
                        </a>
                    </div>
                @endif
            </div>
            
        </div>
    </main>
</div>
@endsection
