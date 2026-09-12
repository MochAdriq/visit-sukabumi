<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class VisitorAuthController extends Controller
{
    public function showLoginForm()
    {
        // Jika sudah login, redirect kembali ke sebelumnya atau home
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin');
            }
            return redirect()->intended('/');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin');
            }

            return redirect()->intended('/')->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->intended('/');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'visitor', // Default role untuk pengunjung
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Pendaftaran berhasil! Selamat datang di Visit Sukabumi.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Redirect pengguna ke halaman otentikasi Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle respon callback dari Google setelah login sukses.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $email = strtolower(trim($googleUser->getEmail()));

            // Daftar email yang otomatis ditetapkan sebagai admin
            $adminEmails = [
                'mochfadillah1208@gmail.com',
                'visitsukabumidotcom@gmail.com',
            ];
            $isAdmin = in_array($email, $adminEmails);

            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $email)
                ->first();

            if ($user) {
                // Update data Google jika belum tersinkronisasi
                $updates = [];
                if (!$user->google_id) {
                    $updates['google_id'] = $googleUser->getId();
                }
                if (!$user->avatar && $googleUser->getAvatar()) {
                    $updates['avatar'] = $googleUser->getAvatar();
                }
                if (!$user->email_verified_at) {
                    $updates['email_verified_at'] = now();
                }
                if ($isAdmin && $user->role !== 'admin') {
                    $updates['role'] = 'admin';
                }

                if (!empty($updates)) {
                    $user->update($updates);
                }
            } else {
                // Buat user baru dari akun Google
                $user = User::create([
                    'name'              => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Pengunjung',
                    'email'             => $email,
                    'google_id'         => $googleUser->getId(),
                    'avatar'            => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                    'password'          => Hash::make(Str::random(32)),
                    'role'              => $isAdmin ? 'admin' : 'visitor',
                ]);
            }

            Auth::login($user, true);
            request()->session()->regenerate();

            if ($user->role === 'admin') {
                return redirect()->intended('/admin');
            }

            return redirect()->intended('/')->with('success', 'Selamat datang, ' . $user->name . '!');

        } catch (\Exception $e) {
            Log::error('Google Auth Error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal masuk dengan Google. Silakan coba lagi atau gunakan akun biasa.',
            ]);
        }
    }
}
