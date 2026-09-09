@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f8f9fa] font-sans text-gray-900">
    @include('components.navbar')

    <main class="pt-10 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <svg class="w-8 h-8 text-[#f9a826]" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <h1 class="text-3xl font-extrabold text-gray-900">Wishlist Saya</h1>
                </div>
                <div class="text-sm font-semibold text-gray-500 bg-white border border-gray-200 px-4 py-2 rounded-full shadow-sm">
                    <span class="text-gray-900">{{ $wishlists->count() }}</span> Destinasi
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl mb-8 flex justify-between items-center shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="bg-green-100 p-1.5 rounded-full text-green-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-900 transition-colors">&times;</button>
                </div>
            @endif

            @if($wishlists->isEmpty())
                <div class="text-center py-24 bg-white border border-gray-100 rounded-3xl shadow-sm">
                    <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Wishlist Anda Masih Kosong</h2>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto text-lg">Mulai eksplorasi keindahan Sukabumi dan simpan destinasi impian Anda di sini dengan menekan ikon hati.</p>
                    <a href="{{ route('place.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-full transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Jelajahi Destinasi
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-6 gap-y-10">
                    @foreach($wishlists as $place)
                        <x-place-card :place="$place" />
                    @endforeach
                </div>
            @endif

        </div>
    </main>

    @include('components.footer')
</div>
@endsection
