<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman; // Import Model Pengumuman
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- 1. IMPORT 'Auth' facade
use Illuminate\Support\Facades\Storage; // <-- 2. IMPORT 'Storage' facade

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 3. Tambahkan with('user') untuk mengambil data user (Karyawan)
        // Ini untuk memperbaiki N+1 Query di halaman index
        $pengumumans = Pengumuman::with('user')->latest()->get();
        return view('admin.pengumuman.index', compact('pengumumans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 4. Tambahkan validasi 'gambar'
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Boleh kosong
        ]);

        // 5. Tambahkan logic upload gambar
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('pengumuman_images', 'public');
        }

        // Menambahkan ID user yang sedang login ke data yang akan disimpan
        $validated['user_id'] = Auth::id();
        
        Pengumuman::create($validated);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.show', compact('pengumuman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        // 6. Tambahkan validasi 'gambar'
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Boleh kosong
        ]);
        
        // 7. Tambahkan logic update gambar (termasuk hapus gambar lama)
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($pengumuman->gambar) {
                Storage::disk('public')->delete($pengumuman->gambar);
            }
            // Simpan gambar baru
            $validated['gambar'] = $request->file('gambar')->store('pengumuman_images', 'public');
        }

        // (Opsional: Lacak siapa yang terakhir meng-update)
        // $validated['user_id'] = Auth::id();

        $pengumuman->update($validated);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        // 8. Tambahkan logic hapus gambar dari storage
        if ($pengumuman->gambar) {
            Storage::disk('public')->delete($pengumuman->gambar);
        }

        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}