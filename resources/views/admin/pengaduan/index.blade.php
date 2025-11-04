@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Pengaduan & Pesan Masyarakat</h3>
    <p class="text-muted mb-4">Daftar pesan, keluhan, dan masukan yang dikirim oleh publik melalui form Kontak dan Layanan.</p>

    <div class="row">
        @forelse ($pengaduans as $pengaduan)
        <div class="col-lg-4 col-md-6 mb-4">
            {{-- Card styling diambil dari layout global, tapi kita tambahkan h-100 --}}
            <div class="card h-100"> 
                <div class="card-body d-flex flex-column">
                    
                    {{-- Bagian Header Kartu (Info Pengirim) --}}
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; flex-shrink: 0;">
                            {{-- Ambil 2 huruf pertama dari nama --}}
                            <span class="fw-bold fs-5 text-primary">{{ strtoupper(substr($pengaduan->nama, 0, 2)) }}</span>
                        </div>
                        <div>
                            <h5 class="card-title mb-0 fs-6 fw-bold">{{ $pengaduan->nama }}</h5>
                            <small class="text-muted">{{ $pengaduan->email ?? 'Email tidak ada' }}</small>
                        </div>
                    </div>

                    {{-- Isi Pesan/Pengaduan --}}
                    <p class="card-text fst-italic text-dark bg-light p-3 rounded-3">
                        "{{ $pengaduan->isi_pengaduan }}"
                    </p>

                    {{-- Footer Kartu (Tanggal) --}}
                    <div class="mt-auto text-end">
                        <small class="text-muted">{{ $pengaduan->created_at->format('d/m/Y H:i') }}</small>
                    </div>

                    {{-- Opsional: Tombol Hapus Pesan --}}
                    {{-- 
                    <hr>
                    <form action="#" method="POST" onsubmit="return confirm('Hapus pesan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                            <i class="bi bi-trash me-1"></i> Tandai Selesai / Hapus
                        </button>
                    </form>
                    --}}

                </div>
            </div>
        </div>
        @empty
        {{-- Pesan jika tidak ada pengaduan --}}
        <div class="col-12">
            <div class="alert alert-secondary text-center" role="alert">
                Belum ada pengaduan atau pesan yang masuk dari publik.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
