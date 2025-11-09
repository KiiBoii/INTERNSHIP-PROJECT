<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Berita::query();

        // --- Logika Filter Tanggal (Sudah Benar) ---
        if ($request->filled('tanggal')) {
            $tanggal = $request->input('tanggal');
            if ($tanggal == 'hari_ini') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($tanggal == '7_hari') {
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
            } elseif ($tanggal == 'bulan_ini') {
                $query->whereMonth('created_at', Carbon::now()->month);
            }
        }
        
        // --- ▼▼▼ PERBARUAN: LOGIKA FILTER TAG (DIPERBAIKI) ▼▼▼ ---
        if ($request->filled('tag')) {
            $tag = $request->input('tag');
            // Logika Anda sebelumnya mencari di 'isi', saya ubah mencari di kolom 'tag'
            $query->where('tag', $tag);
        }
        // --- ▲▲▲ AKHIR PERBARUAN ▲▲▲ ---

        $beritas = $query->with('user')->latest()->get();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($beritas);
        }

        return view('admin.berita.index', compact('beritas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // --- ▼▼▼ PERBARUAN: Tambahkan 'tag' di validasi ▼▼▼ ---
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tag' => 'nullable|string|in:info,layanan,kegiatan', // Opsional, tapi harus salah satu dari 3 nilai ini
        ]);
        // --- ▲▲▲ AKHIR PERBARUAN ▲▲▲ ---

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita_images', 'public');
        }

        $validated['user_id'] = Auth::id();

        Berita::create($validated);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {
        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $berita)
    {
        // PENTING: Anda juga harus menambahkan dropdown 'tag'
        // ke file 'edit.blade.php' Anda, mirip seperti 'create.blade.php'
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Berita $berita)
    {
        // --- ▼▼▼ PERBARUAN: Tambahkan 'tag' di validasi ▼▼▼ ---
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tag' => 'nullable|string|in:info,layanan,kegiatan', // Opsional
        ]);
        // --- ▲▲▲ AKHIR PERBARUAN ▲▲▲ ---

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('berita_images', 'public');
        }

        // $validated['user_id'] = Auth::id(); // Opsional

        $berita->update($validated);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Berita $berita)
    {
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Berita berhasil dihapus.']);
        }

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}