@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center relative bg-gray-900">
    {{-- Background Image with overlay --}}
    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1920&h=1080&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-overlay" alt="Sukabumi Background">
    
    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>

    <div class="relative z-10 w-full max-w-md px-4">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-block group">
                <span class="font-black text-2xl tracking-widest text-white uppercase group-hover:text-[#f9a826] transition-colors">VISIT SUKABUMI</span>
            </a>
            <h2 class="mt-6 text-3xl font-extrabold text-white">Selamat Datang!</h2>
            <p class="mt-2 text-sm text-gray-300">Silakan login untuk memberikan ulasan dan menyimpan destinasi favorit Anda.</p>
        </div>

        <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl shadow-2xl p-8">
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-500/10 border border-red-500/50 text-red-200 px-4 py-3 rounded-lg text-sm">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-200">Email Address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="appearance-none block w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#f9a826] focus:border-transparent transition-all sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-200">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="appearance-none block w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#f9a826] focus:border-transparent transition-all sm:text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-[#f9a826] focus:ring-[#f9a826] bg-white/10 border-white/20">
                        <label for="remember" class="ml-2 block text-sm text-gray-300">Remember me</label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-gray-900 bg-[#f9a826] hover:bg-[#e8971e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-[#f9a826] transition-all">
                        Masuk
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-300">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-bold text-white hover:text-[#f9a826] transition-colors underline underline-offset-2">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
