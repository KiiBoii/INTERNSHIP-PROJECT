<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak; // <-- Gunakan Model Kontak
use Illuminate\Http\Request;

class KontakController extends Controller
{
    /**
     * Menampilkan daftar pesan kontak yang masuk.
     * Ini adalah method yang mengirim data ke kontak/index.blade.php
     */
    public function index()
    {
        // 1. Ambil semua data dari Model Kontak
        //    Urutkan dari yang terbaru
        //    Bagi per 15 data per halaman (Paginasi)
        $pesanKontak = Kontak::latest()->paginate(15);

        // 2. Kirim data (variabel $pesanKontak) ke view
        return view('admin.kontak.index', compact('pesanKontak'));
    }
}

