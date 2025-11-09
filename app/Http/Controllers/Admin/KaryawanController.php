<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Import Model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Untuk hash password
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    // === TAMBAHAN: DEFINISI DAFTAR ROLE ===
    private $roleList = [
        'admin' => 'Admin Utama',
        'berita' => 'Admin Konten Berita',
        // Tambahkan role lain jika diperlukan di sini
    ];



    public function index()
    {
        $karyawans = User::latest()->get(); // Ambil semua user
        return view('admin.karyawan.index', compact('karyawans'));
    }


    public function create()
    {
        // === PERUBAHAN: KIRIM DAFTAR ROLE KE VIEW ===
        return view('admin.karyawan.create', [
            'roleList' => $this->roleList
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', 
            // === PERUBAHAN: VALIDASI ROLE BERDASARKAN roleList ===
            'role' => ['required', Rule::in(array_keys($this->roleList))],
            // =======================================================
            'jabatan' => 'nullable|string|max:255',
            'departemen' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        $validated['password'] = Hash::make($validated['password']); // Hash password

        User::create($validated);

        return redirect()->route('karyawan.index')->with('success', 'Admin/Karyawan berhasil ditambahkan.');
    }

    public function show(User $karyawan)
    {
        return view('admin.karyawan.show', compact('karyawan'));
    }


    public function edit(User $karyawan)
    {
        // === PERUBAHAN: KIRIM DAFTAR ROLE KE VIEW EDIT ===
        $roleList = $this->roleList;
        return view('admin.karyawan.edit', compact('karyawan', 'roleList'));
    }


    public function update(Request $request, User $karyawan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $karyawan->id, // Abaikan email ini saat update
            'password' => 'nullable|string|min:8|confirmed', // Password opsional saat update
            // === PERUBAHAN: VALIDASI ROLE BERDASARKAN roleList ===
            'role' => ['required', Rule::in(array_keys($this->roleList))],
            // =======================================================
            'jabatan' => 'nullable|string|max:255',
            'departemen' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        if ($request->filled('password')) { // Jika password diisi, hash password baru
            $validated['password'] = Hash::make($validated['password']);
        } else { // Jika password tidak diisi, gunakan password lama
            unset($validated['password']);
        }

        $karyawan->update($validated);

        return redirect()->route('karyawan.index')->with('success', 'Data Admin/Karyawan berhasil diperbarui.');
    }


    public function destroy(User $karyawan)
    {
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Admin/Karyawan berhasil dihapus.');
    }
}