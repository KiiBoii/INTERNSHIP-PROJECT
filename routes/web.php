<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- IMPORT CONTROLLER ADMIN ---
use App\Http\Controllers\Admin\BeritaController; 
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\KontakController;

// --- IMPORT CONTROLLER PUBLIC ---
use App\Http\Controllers\Public\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// === RUTE HALAMAN PUBLIK (TANPA LOGIN) ===
// (Tidak ada perubahan di sini)
Route::get('/', [PageController::class, 'home'])->name('public.home');
Route::get('/profil', [PageController::class, 'profil'])->name('public.profil');
Route::get('/berita', [PageController::class, 'berita'])->name('public.berita');
Route::get('/berita/{id}', [PageController::class, 'showBerita'])->name('public.berita.detail');
Route::get('/layanan-publik', [PageController::class, 'layanan'])->name('public.layanan');
Route::get('/galeri', [PageController::class, 'galeri'])->name('public.galeri');
Route::get('/pengumuman', [PageController::class, 'pengumuman'])->name('public.pengumuman');
Route::get('/kontak', [PageController::class, 'kontak'])->name('public.kontak');
Route::post('/kontak', [PageController::class, 'storeKontak'])->name('public.kontak.store');


// === GRUP UNTUK SEMUA HALAMAN ADMIN ===
// Middleware 'verified' diganti dengan 'role'
// Grup ini sekarang memvalidasi bahwa pengguna harus login DAN memiliki role 'admin' ATAU 'berita'
Route::middleware(['auth', 'role:admin,berita'])->prefix('admin')->group(function () {
    
    // --- Rute yang bisa diakses KEDUA role (Admin & Berita) ---
    Route::resource('berita', BeritaController::class)->parameter('berita', 'berita');
    
    // Rute Profil (Diasumsikan kedua role bisa mengedit profil mereka sendiri)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // --- Rute yang HANYA bisa diakses oleh 'admin' ---
    Route::middleware('role:admin')->group(function () {
        
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); // Pastikan file ini ada
        })->name('dashboard');
        
        // Rute CRUD Modul Admin Lainnya
        Route::resource('galeri', GaleriController::class);
        Route::resource('pengumuman', PengumumanController::class);
        Route::resource('karyawan', KaryawanController::class);
        Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::get('kontak', [KontakController::class, 'index'])->name('kontak.index');
    
    }); // Akhir grup 'role:admin'

}); // Akhir grup 'auth'


// Ini adalah file yang berisi route untuk login, register, logout, dll.
// BIARKAN SEPERTI INI.
require __DIR__.'/auth.php';