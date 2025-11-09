<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Pengumuman;
use App\Models\Kontak;
use App\Models\Slider; 
use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Validation\Rule;
// ▼▼▼ TAMBAHKAN IMPORT INI JIKA BELUM ADA (Sepertinya sudah ada di file Anda) ▼▼▼
use Illuminate\Support\Carbon; 

class PageController extends Controller
{
    /**
     * Halaman Beranda
     * (Tidak diubah, sesuai file Anda)
     */
    public function home()
    {
        $sliders = Slider::where('halaman', 'home')->where('is_visible', true)->latest()->get();
        
        $semuaBeritaBaru = Berita::with('user')
                                ->whereNull('tag') // Hanya berita biasa
                                ->latest()
                                ->take(6)
                                ->get();
                                
        $beritaUtama = $semuaBeritaBaru->first();
        $beritaLainnya = $semuaBeritaBaru->slice(1);
        
        return view('public.home', compact('sliders', 'beritaUtama', 'beritaLainnya'));
    }

    /**
     * Halaman Profil
     * (Tidak diubah)
     */
    public function profil()
    {
        $sliders = Slider::where('halaman', 'profil')->where('is_visible', true)->latest()->get();
        return view('public.profil', compact('sliders'));
    }

    /**
     * Halaman Berita
     * (Tidak diubah, sesuai file Anda)
     */
    public function berita()
    {
        $sliders = Slider::where('halaman', 'berita')->where('is_visible', true)->latest()->get();
        
        // 1. Ambil 6 Berita TERBARU yang BUKAN topik (tag = null) untuk "Hot News"
        $hot_news = Berita::with('user')
                            ->whereNull('tag') // Hanya berita biasa
                            ->latest()
                            ->take(6)
                            ->get();
        
        // 2. Ambil ID Berita 'hot' untuk dikecualikan
        $hot_news_ids = $hot_news->pluck('id');

        // 3. Ambil sisa Berita yang BUKAN topik (tag = null) untuk "Berita Lainnya"
        $beritas = Berita::with('user')
                           ->whereNull('tag') // Hanya berita biasa
                           ->whereNotIn('id', $hot_news_ids) // Lewati berita 'hot'
                           ->latest()
                           ->paginate(9); // Ambil 9 per halaman
        
        // 4. Ambil 5 Berita TERBARU yang MEMILIKI TAG (ini adalah Topik Lainnya)
        // (Logika ini dari file Anda, BUKAN dari permintaan terakhir Anda)
        $topik_lainnya = Berita::with('user')
                                    ->whereNotNull('tag') // HANYA berita yang punya tag
                                    ->latest()
                                    ->take(5) // Ambil 5 topik terbaru
                                    ->get();

        return view('public.berita', compact('sliders', 'hot_news', 'beritas', 'topik_lainnya'));
    }

    /**
     * Halaman Galeri
     * (Tidak diubah)
     */
    public function galeri(Request $request) 
    {
        // ... (Tidak ada perubahan)
        $sliders = Slider::where('halaman', 'galeri')->where('is_visible', true)->latest()->get();
        $bidangList = Galeri::whereNotNull('bidang')->where('bidang', '!=', '')->distinct()->pluck('bidang');
        $query = Galeri::with('user');
        if ($request->has('bidang') && $request->bidang != '') {
            $query->where('bidang', $request->bidang);
        }
        $galeris = $query->latest()->get(); 
        return view('public.galeri', compact('sliders', 'galeris', 'bidangList'));
    }

    /**
     * Halaman Layanan Publik
     * (Tidak diubah)
     */
    public function layanan(Request $request)
    {
        // ... (Tidak ada perubahan)
        $sliders = Slider::where('halaman', 'layanan')->where('is_visible', true)->latest()->get();
        $query = Dokumen::query();
        if ($request->filled('cari')) {
            $query->where('judul', 'like', '%' . $request->cari . '%')
                  ->orWhere('keterangan', 'like', '%' . $request->cari . '%');
        }
        $perPage = $request->input('per_page', 10);
        $dokumens = $query->latest()->paginate($perPage)->withQueryString();
        return view('public.layanan', compact('sliders', 'dokumens'));
    }

    /**
     * Halaman Pengumuman
     * (Tidak diubah)
     */
    public function pengumuman()
    {
        // ... (Tidak ada perubahan)
        $sliders = Slider::where('halaman', 'pengumuman')->where('is_visible', true)->latest()->get();
        $pengumumans = Pengumuman::with('user')->latest()->paginate(10);
        return view('public.pengumuman', compact('sliders', 'pengumumans'));
    }

    /**
     * Halaman Kontak
     * (Tidak diubah)
     */
    public function kontak()
    {
        // ... (Tidak ada perubahan)
        $sliders = Slider::where('halaman', 'kontak')->where('is_visible', true)->latest()->get();
        return view('public.kontak', compact('sliders'));
    }

    /**
     * Method untuk MENYIMPAN data dari form kontak
     * (Tidak diubah)
     */
    public function storeKontak(Request $request)
    {
        // ... (Tidak ada perubahan)
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
     * ▼▼▼ PERBARUAN: Logika diubah sesuai permintaan Anda ▼▼▼
     */
    public function showBerita($id)
    {
        $berita = Berita::with('user')->findOrFail($id);

        // PERBARUAN: Ambil 5 berita acak (apapun tag-nya)
        // "semua berita yg eksis (selain berita yang sedang dibuka user)"
        $topik_lainnya = Berita::where('id', '!=', $id) // Jangan tampilkan berita yang sedang dibaca
                                 ->inRandomOrder() // Ambil acak dari semua berita
                                 ->take(5)
                                 ->get();
                                       
        // Nama variabel $topik_lainnya dipertahankan agar view 'berita_detail'
        // (dari konteks sebelumnya) tetap berfungsi.
        return view('public.berita_detail', compact('berita', 'topik_lainnya')); 
    }
}