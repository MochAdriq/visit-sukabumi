@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center relative bg-gray-900 py-12">
    {{-- Background Image with overlay --}}
    <img src="{{ asset('assets/images/2.webp') }}" class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-overlay" alt="Sukabumi Background">
    
    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>

    <div class="relative z-10 w-full max-w-md px-4">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-block group">
                <span class="font-black text-2xl tracking-widest text-white uppercase group-hover:text-[#f9a826] transition-colors">VISIT SUKABUMI</span>
            </a>
            <h2 class="mt-6 text-3xl font-extrabold text-white">Selamat Datang!</h2>
            <p class="mt-2 text-sm text-gray-300">Masuk untuk memberikan ulasan, menyimpan wishlist, dan mengelola destinasi Anda.</p>
        </div>

        <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl shadow-2xl p-8">
            @if ($errors->any())
                <div class="mb-6 bg-red-500/20 border border-red-500/50 text-red-200 px-4 py-3 rounded-xl text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ══ TOMBOL GOOGLE SIGN-IN RESMI (1-KLIK) ══ --}}
            <div>
                <a href="{{ route('auth.google', array_filter(['redirect' => request('redirect', session('url.intended'))])) }}"
                   class="w-full flex items-center justify-center py-3.5 px-4 rounded-xl shadow-md text-sm font-bold text-gray-800 bg-white hover:bg-gray-50 border border-gray-200 transition-all duration-200 hover:shadow-lg hover:scale-[1.01] active:scale-[0.99] group">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                    <span>Lanjutkan dengan Google</span>
                </a>
            </div>

            {{-- ══ KONDISI: FORM MANUAL HANYA MUNCUL DI LOCAL ══ --}}
            @if(app()->environment('local'))
                <div class="relative flex py-5 items-center">
                    <div class="flex-grow border-t border-white/20"></div>
                    <span class="flex-shrink mx-3 text-[11px] text-gray-300 uppercase tracking-widest font-semibold">Atau Mode Dev (Manual)</span>
                    <div class="flex-grow border-t border-white/20"></div>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-medium text-gray-200 uppercase tracking-wider mb-1">Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="appearance-none block w-full px-4 py-2.5 bg-white/5 border border-white/15 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#f9a826] focus:border-transparent transition-all text-sm">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-medium text-gray-200 uppercase tracking-wider mb-1">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="appearance-none block w-full px-4 py-2.5 bg-white/5 border border-white/15 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#f9a826] focus:border-transparent transition-all text-sm">
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center text-gray-300 cursor-pointer">
                            <input id="remember" name="remember" type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-[#f9a826] focus:ring-[#f9a826] bg-white/10 border-white/20">
                            <span class="ml-2">Ingat saya</span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-gray-900 bg-[#f9a826] hover:bg-[#e8971e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-[#f9a826] transition-all">
                            Masuk Manual
                        </button>
                    </div>
                </form>

                <div class="mt-5 text-center">
                    <p class="text-xs text-gray-300">
                        Belum punya akun lokal?
                        <a href="{{ route('register') }}" class="font-bold text-white hover:text-[#f9a826] transition-colors underline underline-offset-2">Daftar di sini</a>
                    </p>
                </div>
            @else
                <div class="mt-6 pt-4 border-t border-white/10 text-center">
                    <div class="inline-flex items-center gap-1.5 text-xs text-gray-300">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Aman & cepat dengan akun Google terverifikasi</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
