<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider; // <-- INI ADALAH PERBAIKANNYA

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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // === PERUBAHAN DI SINI ===
        // 2. Coba autentikasi (parameter 'remember' dihapus)
        // Ini memastikan session akan hangus saat browser ditutup
        // (sesuai pengaturan SESSION_EXPIRE_ON_CLOSE=true di .env)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Pengecekan Role dan Redirect
            $user = Auth::user();

            if ($user->role === 'admin') {
                // Arahkan 'admin' ke dashboard utama
                // Baris ini (baris 40) sekarang akan berfungsi
                return redirect()->intended(RouteServiceProvider::HOME_ADMIN);
            }

            if ($user->role === 'berita') {
                // Arahkan 'berita' ke halaman manajemen berita
                return redirect()->intended(RouteServiceProvider::HOME_BERITA);
            }

            // Fallback jika role tidak dikenal (seharusnya tidak terjadi)
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