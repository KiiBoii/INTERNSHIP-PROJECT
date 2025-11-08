<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Pengumuman;
use App\Models\Kontak;
use App\Models\Slider; 
use App\Models\Dokumen; // <-- IMPORT MODEL DOKUMEN BARU
use Illuminate\Support\Facades\Storage; 
use Illuminate\Validation\Rule; // Tambahkan jika ada validasi rule khusus

class PageController extends Controller
{
    /**
     * Halaman Beranda
     */
    public function home()
    {
        $sliders = Slider::where('halaman', 'home')->where('is_visible', true)->latest()->get();
        $semuaBeritaBaru = Berita::with('user')->latest()->take(6)->get();
        $beritaUtama = $semuaBeritaBaru->first();
        $beritaLainnya = $semuaBeritaBaru->slice(1);
        
        return view('public.home', compact('sliders', 'beritaUtama', 'beritaLainnya'));
    }

    /**
     * Halaman Profil
     */
    public function profil()
    {
        $sliders = Slider::where('halaman', 'profil')->where('is_visible', true)->latest()->get();
        return view('public.profil', compact('sliders'));
    }

    /**
     * Halaman Berita
     */
    public function berita()
    {
        $sliders = Slider::where('halaman', 'berita')->where('is_visible', true)->latest()->get();
        
        $hot_news = Berita::with('user')->latest()->take(6)->get();
        $hot_news_ids = $hot_news->pluck('id');
        $beritas = Berita::with('user')->whereNotIn('id', $hot_news_ids)
                                 ->latest()
                                 ->paginate(9);
        $beritas_ids = $beritas->pluck('id');
        $exclude_ids = $hot_news_ids->merge($beritas_ids);
        $topik_lainnya = Berita::whereNotIn('id', $exclude_ids)
                                 ->inRandomOrder()
                                 ->take(5)
                                 ->get();

        return view('public.berita', compact('sliders', 'hot_news', 'beritas', 'topik_lainnya'));
    }

    /**
     * Halaman Galeri
     */
    public function galeri(Request $request) 
    {
        $sliders = Slider::where('halaman', 'galeri')->where('is_visible', true)->latest()->get();

        $bidangList = Galeri::whereNotNull('bidang')
                            ->where('bidang', '!=', '')
                            ->distinct()
                            ->pluck('bidang');

        $query = Galeri::with('user');

        if ($request->has('bidang') && $request->bidang != '') {
            $query->where('bidang', $request->bidang);
        }

        $galeris = $query->latest()->get(); 

        return view('public.galeri', compact('sliders', 'galeris', 'bidangList'));
    }

    /**
     * Halaman Layanan Publik
     * PERUBAHAN: Sekarang menerima Request dan mengambil data Dokumen.
     */
    public function layanan(Request $request)
    {
        // 1. Ambil data slider
        $sliders = Slider::where('halaman', 'layanan')->where('is_visible', true)->latest()->get();
        
        // 2. Ambil data Dokumen Publikasi (untuk Tab)
        $query = Dokumen::query();
        
        // Filter/Cari
        if ($request->filled('cari')) {
            $query->where('judul', 'like', '%' . $request->cari . '%')
                  ->orWhere('keterangan', 'like', '%' . $request->cari . '%');
        }
        
        // Pagination/Per Page
        $perPage = $request->input('per_page', 10);
        $dokumens = $query->latest()->paginate($perPage)->withQueryString();
        
        // 3. Kirim kedua variabel ke view
        return view('public.layanan', compact('sliders', 'dokumens'));
    }

    /**
     * Halaman Pengumuman
     */
    public function pengumuman()
    {
        $sliders = Slider::where('halaman', 'pengumuman')->where('is_visible', true)->latest()->get();
        $pengumumans = Pengumuman::with('user')->latest()->paginate(10);
        
        return view('public.pengumuman', compact('sliders', 'pengumumans'));
    }

    /**
     * Halaman Kontak
     */
    public function kontak()
    {
        $sliders = Slider::where('halaman', 'kontak')->where('is_visible', true)->latest()->get();
        return view('public.kontak', compact('sliders'));
    }

    /**
     * Method untuk MENYIMPAN data dari form kontak
     */
    public function storeKontak(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'nullable|string|max:20', 
            'isi_pengaduan' => 'required|string',
            'foto_pengaduan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto_pengaduan')) {
            $validated['foto_pengaduan'] = $request->file('foto_pengaduan')->store('pengaduan_images', 'public');
        }

        Kontak::create($validated);

        return redirect()->route('public.kontak')->with('success', 'Pengaduan Anda telah berhasil terkirim. Terima kasih!');
    }
    
    /**
     * Halaman Detail Berita
     */
    public function showBerita($id)
    {
        $berita = Berita::with('user')->findOrFail($id);

        $related_news = Berita::where('id', '!=', $id)
                                         ->latest()
                                         ->take(3)
                                         ->get();
                                         
        return view('public.berita_detail', compact('berita', 'related_news'));
    }
}