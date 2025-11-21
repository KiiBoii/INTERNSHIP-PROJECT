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
use Illuminate\Support\Carbon; 

class PageController extends Controller
{
    /**
     * Halaman Beranda
     */
    public function home()
    {
        $sliders = Slider::where('halaman', 'home')->where('is_visible', true)->latest()->get();
        
        $semuaBeritaBaru = Berita::with('user')
                                     ->whereNull('tag') 
                                     ->where('is_visible', true) // <-- Asumsi: Kolom ini ada di tabel beritas
                                     ->latest()
                                     ->take(6)
                                     ->get();
                                     
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
     * [BARU] Halaman Profil Kepala Dinas
     */
    public function profilKadis()
    {
        // [SARAN]
        // Nanti Anda bisa mengambil data Kadis secara dinamis dari database
        // $kadis = ProfilPejabat::where('jabatan', 'Kepala Dinas')->first();
        
        // Kirim data ke view
        return view('public.profil-kadis' /*, [
            'kadis' => $kadis 
        ]*/);
    }

    /**
     * Halaman Berita
     */
    public function berita()
    {
        $sliders = Slider::where('halaman', 'berita')->where('is_visible', true)->latest()->get();
        
        // Ambil 6 Berita TERBARU yang BUKAN topik (tag = null) untuk "Hot News"
        $hot_news = Berita::with('user')
                             ->whereNull('tag') // Hanya berita biasa
                             ->where('is_visible', true) // <-- Asumsi: Kolom ini ada di tabel beritas
                             ->latest()
                             ->take(6)
                             ->get();
        
        // Ambil ID Berita 'hot' untuk dikecualikan
        $hot_news_ids = $hot_news->pluck('id');

        // Ambil sisa Berita yang BUKAN topik (tag = null) untuk "Berita Lainnya"
        $beritas = Berita::with('user')
                             ->whereNull('tag') // Hanya berita biasa
                             ->where('is_visible', true) // <-- Asumsi: Kolom ini ada di tabel beritas
                             ->whereNotIn('id', $hot_news_ids) // Lewati berita 'hot'
                             ->latest()
                             ->paginate(9); // Ambil 9 per halaman
        
        // Ambil 5 Berita TERBARU yang MEMILIKI TAG (ini adalah Topik Lainnya)
        $topik_lainnya = Berita::with('user')
                                     ->whereNotNull('tag') // HANYA berita yang punya tag
                                     ->where('is_visible', true) // <-- Asumsi: Kolom ini ada di tabel beritas
                                     ->latest()
                                     ->take(5) // Ambil 5 topik terbaru
                                     ->get();

        return view('public.berita', compact('sliders', 'hot_news', 'beritas', 'topik_lainnya'));
    }
    

    /**
     * Halaman Semua Topik
     */
    public function topik()
    {
        // 1. Ambil 3 Berita 'Topik' terbaru untuk slider (Ini sudah benar)
        $sliders = Berita::with('user')
                             ->whereNotNull('tag') // HANYA berita yang punya tag
                             ->where('is_visible', true) // <-- Asumsi: Kolom ini ada di tabel beritas
                             ->latest()
                             ->take(3) // Ambil 3 saja
                             ->get();
        
        // 2. Konten Utama: Ambil SEMUA berita yang punya TAG
        $semua_topik = Berita::with('user')
                                     ->whereNotNull('tag') // HANYA berita yang punya tag
                                     ->where('is_visible', true) // <-- Asumsi: Kolom ini ada di tabel beritas
                                     ->latest()
                                     ->paginate(9); // Paginasi 9 item per halaman
        
        // 3. Sidebar: Ambil 5 Berita terbaru TANPA tag (Ini sudah benar)
        $berita_terbaru_sidebar = Berita::with('user')
                                                     ->whereNull('tag') // Hanya berita biasa
                                                     ->where('is_visible', true) // <-- Asumsi: Kolom ini ada di tabel beritas
                                                     ->latest()
                                                     ->take(5) // Ambil 5 berita terbaru
                                                     ->get();

        // 4. Kirim data ke view (Ini sudah benar)
        return view('public.berita-topik', compact('sliders', 'semua_topik', 'berita_terbaru_sidebar'));
    }

    /**
     * Halaman Galeri
     */
    public function galeri(Request $request) 
    {
        $sliders = Slider::where('halaman', 'galeri')->where('is_visible', true)->latest()->get();
        $bidangList = Galeri::whereNotNull('bidang')->where('bidang', '!=', '')->distinct()->pluck('bidang');
        
        // PERBAIKAN: Hapus klausa 'is_visible' dari Galeri karena mungkin belum ada kolomnya
        $query = Galeri::with('user'); // <-- DIUBAH

        if ($request->has('bidang') && $request->bidang != '') {
            $query->where('bidang', $request->bidang);
        }

        // ▼▼▼ PERUBAHAN DI SINI ▼▼▼
        $galeris = $query->latest()->paginate()->withQueryString(); // <-- Kode baru
        // ▲▲▲ AKHIR PERUBAHAN ▲▲▲

        return view('public.galeri', compact('sliders', 'galeris', 'bidangList'));
    }

    /**
     * Halaman Layanan Publik
     */
    public function layanan(Request $request)
    {

        $sliders = Slider::where('halaman', 'layanan')->where('is_visible', true)->latest()->get();
        
        // PERBAIKAN: Hapus klausa 'is_visible' yang menyebabkan error di tabel Dokumen
        $query = Dokumen::query(); // <-- DIUBAH

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
     */
    public function pengumuman()
    {

        $sliders = Slider::where('halaman', 'pengumuman')->where('is_visible', true)->latest()->get();
        
        // Asumsi: Pengumuman juga punya kolom is_visible
        // ▼▼▼ PERUBAHAN DI SINI (10 -> 9) ▼▼▼
        $pengumumans = Pengumuman::with('user')
                                     ->where('is_visible', true) // <-- Asumsi: Kolom ini ada di tabel pengumumans
                                     ->latest()
                                     ->paginate(10);
        // ▲▲▲ AKHIR PERUBAHAN ▲▲▲
        
        return view('public.pengumuman', compact('sliders', 'pengumumans'));
    }

    /**
     * [BARU] Halaman FAQ (Pusat Bantuan)
     */
    public function faq()
    {
        // Mengambil data slider untuk halaman 'faq'. 
        $sliders = Slider::where('halaman', 'faq') 
                             ->where('is_visible', true)
                             ->latest()
                             ->get();
        
        return view('public.faq', compact('sliders' /*, 'faqs' */));
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
    public function showBerita($id) // DULU: public public function showBerita($id)
    {
        // Ini akan otomatis gagal (404) jika 'is_visible' = false
        $berita = Berita::with('user')->where('is_visible', true)->findOrFail($id); // <-- Asumsi: Kolom ini ada di tabel beritas

        //Ambil 5 berita acak (apapun tag-nya)
        // "semua berita yg eksis (selain berita yang sedang dibuka user)"
        $topik_lainnya = Berita::where('id', '!=', $id) // Jangan tampilkan berita yang sedang dibaca
                                             ->where('is_visible', true) // <-- Asumsi: Kolom ini ada di tabel beritas
                                             ->inRandomOrder() // Ambil acak dari semua berita
                                             ->take(20)
                                             ->get();
                                             
        return view('public.berita_detail', compact('berita', 'topik_lainnya')); 
    }

    // =========================================================================
    // ▼▼▼ [BARU] 18 METHOD UNTUK HALAMAN PPID (STRUKTUR BARU) ▼▼▼
    // =========================================================================
    
    // Level 1: Tautan Utama PPID
    public function ppidDaftarInfo2025() { return view('public.ppid.daftar_info_2025'); }
    public function ppidMaklumat() { return view('public.ppid.maklumat'); }
    public function ppidPengaduanWewenang() { return view('public.ppid.pengaduan_wewenang'); }
    public function ppidLaporan() { return view('public.ppid.laporan_ppid'); }
    public function ppidInfoPublikLain() { return view('public.ppid.info_publik_lain'); }
    public function ppidJumlahPermohonan() { return view('public.ppid.jumlah_permohonan'); }
    
    // Level 2 & 3: Layanan Informasi
    public function ppidFormulirPermohonan() { return view('public.ppid.formulir_permohonan'); }
    public function ppidAlurSengketa() { return view('public.ppid.alur_sengketa'); }
    public function ppidAlurHakPengajuan() { return view('public.ppid.alur_hak_pengajuan'); }
    public function ppidAlurTataCara() { return view('public.ppid.alur_tata_cara'); }
    public function ppidFormulirKeberatan() { return view('public.ppid.formulir_keberatan'); }
    
    // Level 2 & 3: Jenis Informasi
    public function ppidInfoBerkala() { return view('public.ppid.info_berkala'); }
    public function ppidInfoSertaMerta() { return view('public.ppid.info_serta_merta'); }
    public function ppidInfoSetiapSaat() { return view('public.ppid.info_setiap_saat'); }
    
    // Level 2 & 3: Surat Keputusan
    public function ppidSkTerbaru() { return view('public.ppid.sk_terbaru'); }
    public function ppidArsipSk() { return view('public.ppid.arsip_sk'); }
    
    // Level 2: Layanan Teknis (Yang lama, kini di bawah Layanan Publik)
    public function ppidLansiaPanti() { return view('public.ppid.lansia_panti'); } // <-- Ubah view path
    public function ppidAnakPanti() { return view('public.ppid.anak_panti'); } // <-- Ubah view path
    // Catatan: 10 method Layanan Teknis lainnya harus disalin dan diubah view path-nya di sini
    // (Misalnya, ppidDisabilitasPanti() harus mengarah ke view yang sesuai di folder ppid)

    public function ppidDisabilitasPanti() { return view('public.ppid.disabilitas_panti'); }
    public function ppidDisabilitasMental() { return view('public.ppid.disabilitas_mental'); }
    public function ppidGelandangPengemis() { return view('public.ppid.gelandang_pengemis'); }
    public function ppidStandarPelayananABH() { return view('public.ppid.standar_pelayanan_abh'); }
    public function ppidPenangananBencana() { return view('public.ppid.penanganan_bencana'); }
    public function ppidIzinPengangkatanAnak() { return view('public.ppid.izin_pengangkatan_anak'); }
    public function ppidTandaDaftarLKS() { return view('public.ppid.tanda_daftar_lks'); }
    public function ppidPemulanganImigran() { return view('public.ppid.pemulangan_imigran'); }
    public function ppidPengaduanMonitoringPKH() { return view('public.ppid.pengaduan_monitoring_pkh'); }
    public function ppidPertimbanganTeknisUGBPUB() { return view('public.ppid.pertimbangan_teknis_ugb_pub'); }
    
    // =========================================================================
    // ▲▲▲ AKHIR METHOD PPID BARU ▲▲▲
    // =========================================================================
}