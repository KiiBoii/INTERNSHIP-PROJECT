<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider; // Penting

class LoginController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Tangani proses login.
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba autentikasi
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // 3. Pengecekan Role dan Redirect
            $user = Auth::user();

            if ($user->role === 'admin') {
                // Arahkan 'admin' ke dashboard utama
                return redirect()->intended(RouteServiceProvider::HOME_ADMIN);
            }

            if ($user->role === 'berita') {
                // Arahkan 'berita' ke halaman manajemen berita
                return redirect()->intended(RouteServiceProvider::HOME_BERITA);
            }

            // Fallback jika role tidak dikenal
            return redirect()->intended('/');
        }

        // 4. Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Tangani proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}