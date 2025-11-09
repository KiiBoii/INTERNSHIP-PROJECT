<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak; // <--  GANTI Model Pengaduan menjadi Kontak
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- IMPORT Storage

class PengaduanController extends Controller
{
    /**
     * Ini adalah halaman untuk admin melihat semua pesan masuk.
     */
    public function index()
    {
        // Ambil data dari Model 'Kontak', bukan 'Pengaduan'
        //    Gunakan paginate (15) agar tidak terlalu berat
        $pengaduans = Kontak::latest()->paginate(15);

        // Kirim data ke view dengan variabel $pengaduans
        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    /**
     * Menghapus pengaduan dari storage.
     */
    public function destroy(Kontak $pengaduan) // 6. Gunakan Model Kontak
    {
        // Hapus foto pengaduan (jika ada)
        if ($pengaduan->foto_pengaduan) {
            Storage::disk('public')->delete($pengaduan->foto_pengaduan);
        }

        // Hapus data dari database
        $pengaduan->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }
}