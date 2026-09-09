@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans text-gray-900">
    @include('components.navbar')

    <main class="pt-24 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-3 mb-8">
                <svg class="w-8 h-8 text-[#f9a826]" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                <h1 class="text-3xl font-extrabold text-gray-900">Wishlist Saya</h1>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex justify-between items-center shadow-sm">
                    <span>{{ session('success') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 font-bold text-xl leading-none">&times;</button>
                </div>
            @endif

            @if($wishlists->isEmpty())
                <div class="text-center py-20 bg-white border border-gray-200 rounded-3xl shadow-sm">
                    <svg class="w-20 h-20 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Wishlist Anda masih kosong</h2>
                    <p class="text-gray-500 mb-6">Mulai eksplorasi keindahan Sukabumi dan simpan destinasi impian Anda di sini.</p>
                    <a href="{{ route('place.index') }}" class="inline-block px-8 py-3 bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold rounded-full transition shadow-md">
                        Jelajahi Destinasi
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($wishlists as $place)
                        <div class="relative group">
                            {{-- Delete Button (Absolute top right of card) --}}
                            <div class="absolute top-3 right-3 z-20">
                                <form action="{{ route('wishlist.toggle', $place->slug) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-white/90 backdrop-blur text-red-500 hover:text-white hover:bg-red-500 p-2 rounded-full shadow-lg transition duration-200" title="Hapus dari Wishlist">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                            
                            {{-- Card --}}
                            <x-place-card :place="$place" />
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </main>

    @include('components.footer')
</div>
@endsection
