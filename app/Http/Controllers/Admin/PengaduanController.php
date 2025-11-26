<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    /**
     * Menampilkan daftar pengaduan dengan filter status.
     */
    public function index(Request $request)
    {
        // Ambil status dari query parameter (default: semua/null)
        $status = $request->get('status');

        // Query dasar
        $query = Kontak::latest();

        // Jika ada status yang dipilih (bukan 'semua'), filter datanya
        if ($status && $status !== 'semua') {
            $query->where('status', $status);
        }

        // ▼▼▼ PERBAIKAN: Ubah pagination menjadi 20 ▼▼▼
        $pengaduans = $query->paginate(20)->withQueryString();

        // Hitung jumlah untuk badge di tab (Opsional, agar terlihat bagus)
        $counts = [
            'semua' => Kontak::count(),
            'diajukan' => Kontak::where('status', 'diajukan')->count(),
            'diproses' => Kontak::where('status', 'diproses')->count(),
            'diterima' => Kontak::where('status', 'diterima')->count(),
            'selesai' => Kontak::where('status', 'selesai')->count(),
            'ditolak' => Kontak::where('status', 'ditolak')->count(),
        ];

        return view('admin.pengaduan.index', compact('pengaduans', 'counts', 'status'));
    }

    /**
     * Update status pengaduan.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diajukan,diproses,diterima,ditolak,selesai',
        ]);

        $pengaduan = Kontak::findOrFail($id);
        
        // Pastikan 'status' ada di $fillable pada Model Kontak
        $pengaduan->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui menjadi ' . ucfirst($request->status));
    }

    /**
     * Menghapus pengaduan.
     */
    public function destroy($id)
    {
        $pengaduan = Kontak::findOrFail($id);

        // Hapus foto pengaduan (jika ada)
        if ($pengaduan->foto_pengaduan) {
            Storage::disk('public_uploads')->delete($pengaduan->foto_pengaduan);
            // Cek juga disk public biasa untuk kompatibilitas
            if(Storage::disk('public')->exists($pengaduan->foto_pengaduan)){
                 Storage::disk('public')->delete($pengaduan->foto_pengaduan);
            }
        }

        $pengaduan->delete();

        return redirect()->back()->with('success', 'Pengaduan berhasil dihapus.');
    }
}