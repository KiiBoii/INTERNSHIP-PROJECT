<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak; // <-- 1. GANTI Model Pengaduan menjadi Kontak
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- 2. IMPORT Storage

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     * Ini adalah halaman untuk admin melihat semua pesan masuk.
     */
    public function index()
    {
        // 3. Ambil data dari Model 'Kontak', bukan 'Pengaduan'
        //    Gunakan paginate (15) agar tidak terlalu berat
        $pengaduans = Kontak::latest()->paginate(15);

        // 4. Kirim data ke view dengan variabel $pengaduans
        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    /**
     * === 5. METHOD BARU UNTUK HAPUS ===
     * Menghapus pengaduan dari storage.
     */
    public function destroy(Kontak $pengaduan) // 6. Gunakan Model Kontak
    {
        // 1. Hapus foto pengaduan (jika ada)
        if ($pengaduan->foto_pengaduan) {
            Storage::disk('public')->delete($pengaduan->foto_pengaduan);
        }

        // 2. Hapus data dari database
        $pengaduan->delete();

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }
}