@extends('layouts.app')

@section('title', 'Semua Destinasi - Visit Sukabumi')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.navbar')

    <div class="bg-[#1a6bbf] pt-12 pb-24">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-black text-white drop-shadow-sm mb-4 tracking-tight">Semua Destinasi</h1>
            <p class="text-blue-100 text-[17px] max-w-2xl mx-auto">
                Jelajahi keindahan Sukabumi, dari pantai yang eksotis hingga pegunungan yang sejuk.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 -mt-12 pb-16">
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 border border-gray-100">
            <!-- Filter or search can go here in the future -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">Menampilkan {{ $places->total() }} tempat wisata</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($places as $place)
                    <x-place-card :place="$place" />
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500">
                        Belum ada destinasi yang ditambahkan.
                    </div>
                @endforelse
            </div>
            
            <div class="mt-10">
                {{ $places->links() }}
            </div>
        </div>
    </div>

    @include('components.footer')
</div>
@endsection
