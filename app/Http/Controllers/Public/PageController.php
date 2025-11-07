<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // <-- DIPERLUKAN UNTUK FILTER
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Pengumuman;
use App\Models\Kontak;
use Illuminate\Support\Facades\Storage; // <-- 1. TAMBAHKAN INI

class PageController extends Controller
{
    /**
     * Halaman Beranda
     */
    public function home()
    {
        // 1. Ambil 6 berita terbaru (Eager load relasi user)
        $semuaBeritaBaru = Berita::with('user')->latest()->take(6)->get();

        // 2. Ambil 1 berita pertama sebagai Berita Utama
        $beritaUtama = $semuaBeritaBaru->first();

        // 3. Ambil 5 berita sisanya (skip 1) sebagai Berita Lainnya
        $beritaLainnya = $semuaBeritaBaru->slice(1);
        
        return view('public.home', compact('beritaUtama', 'beritaLainnya'));
    }

    /**
     * Halaman Profil
     */
    public function profil()
    {
        return view('public.profil');
    }

    /**
     * Halaman Berita
     */
    public function berita()
    {
        // Ambil 6 berita terbaru untuk "Hot News" (Eager load user)
        $hot_news = Berita::with('user')->latest()->take(6)->get();

        // Ambil ID dari hot_news
        $hot_news_ids = $hot_news->pluck('id');

        // Ambil berita lainnya (selain hot news) dengan paginasi (9 per halaman)
        $beritas = Berita::with('user')->whereNotIn('id', $hot_news_ids)
                                ->latest()
                                ->paginate(9);

        // Ambil 5 topik/berita lainnya secara acak
        $beritas_ids = $beritas->pluck('id');
        $exclude_ids = $hot_news_ids->merge($beritas_ids);

        $topik_lainnya = Berita::whereNotIn('id', $exclude_ids)
                                ->inRandomOrder() // Ambil acak
                                ->take(5)
                                ->get();

        return view('public.berita', compact('hot_news', 'beritas', 'topik_lainnya'));
    }

    /**
     * Halaman Galeri
     * === BAGIAN INI DIPERBARUI UNTUK FILTER ISOTOPE ===
     */
    public function galeri(Request $request)
    {
        // 1. Ambil daftar bidang unik dari database
        $bidangList = Galeri::whereNotNull('bidang')
                            ->where('bidang', '!=', '')
                            ->distinct()
                            ->pluck('bidang');

        // 2. Buat query galeri (sudah termasuk relasi user)
        $query = Galeri::with('user');

        // 3. Terapkan filter jika ada (meskipun Isotope akan menanganinya di frontend)
        if ($request->has('bidang') && $request->bidang != '') {
            $query->where('bidang', $request->bidang);
        }

        // 4. Ambil SEMUA hasil (get()) untuk Isotope, BUKAN paginate()
        $galeris = $query->latest()->get(); 

        // 5. Kirim data ke view
        return view('public.galeri', compact('galeris', 'bidangList'));
    }

    /**
     * Halaman Layanan Publik
     */
    public function layanan()
    {
        return view('public.layanan');
    }

    /**
     * Halaman Pengumuman
     */
    public function pengumuman()
    {
        // 5. PERBARUI: Tambahkan with('user') untuk mengambil nama penulis
        $pengumumans = Pengumuman::with('user')->latest()->paginate(10);
        return view('public.pengumuman', compact('pengumumans'));
    }

    /**
     * Halaman Kontak
     */
    public function kontak()
    {
        return view('public.kontak');
    }

    /**
     * Method untuk MENYIMPAN data dari form kontak
     * === BAGIAN INI DIPERBARUI UNTUK PENGADUAN LENGKAP ===
     */
    public function storeKontak(Request $request)
    {
        // 6. Validasi data (menambahkan no_hp dan foto_pengaduan)
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'nullable|string|max:20', // Validasi No HP
            'isi_pengaduan' => 'required|string',
            'foto_pengaduan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi Foto
        ]);

        // 7. Logic untuk upload foto (jika ada)
        if ($request->hasFile('foto_pengaduan')) {
            $validated['foto_pengaduan'] = $request->file('foto_pengaduan')->store('pengaduan_images', 'public');
        }

        // Simpan ke database menggunakan Model Kontak
        Kontak::create($validated);

        // Kembalikan ke halaman kontak dengan pesan sukses
        return redirect()->route('public.kontak')->with('success', 'Pengaduan Anda telah berhasil terkirim. Terima kasih!');
    }
    
    /**
     * Halaman Detail Berita
     */
    public function showBerita($id)
    {
        // 8. PERBARUI: Tambahkan with('user') untuk mengambil nama penulis
        $berita = Berita::with('user')->findOrFail($id);

        // 2. Ambil berita terkait
        $related_news = Berita::where('id', '!=', $id)
                                        ->latest()
                                        ->take(3)
                                        ->get();
                                        
        // 3. Kirim data ke view detail
        return view('public.berita_detail', compact('berita', 'related_news'));
    }
}