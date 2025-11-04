<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan; // <-- Import model Pengaduan
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     * Ini adalah halaman untuk admin melihat semua pesan masuk.
     */
    public function index()
    {
        // Ambil semua data pengaduan/kontak, urutkan dari yang terbaru
        $pengaduans = Pengaduan::latest()->get();

        // Kirim data ke view
        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    // Catatan: Sesuai permintaan Anda, kita tidak perlu method create, store, edit,
    // karena admin hanya perlu MELIHAT pesan yang masuk dari publik.
    // Kita bisa menambahkan method destroy() nanti jika admin perlu menghapus pesan.
}
