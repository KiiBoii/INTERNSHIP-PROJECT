@extends('layouts.public')

{{-- 1. CSS KUSTOM DITAMBAHKAN (SAMA SEPERTI HALAMAN LAINNYA) --}}
@push('styles')
<style>
    /* Mengambil style dari halaman berita/home agar sama persis */
    .news-slider .carousel-item {
        height: 450px; /* Atur tinggi slider */
        background-color: #555;
    }

    .news-slider .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Pastikan gambar mengisi area */
    }

    /* Overlay gradient gelap agar teks terbaca */
    .news-slider .carousel-item::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.6) 20%, rgba(0,0,0,0) 80%);
    }

    .news-slider .carousel-caption {
        bottom: 0;
        z-index: 10;
        text-align: left;
        padding: 2rem 1.5rem;
        width: 80%; 
        left: 5%; 
    }

    .news-slider .carousel-caption h5,
    /* Menargetkan h1 di dalam caption juga */
    .news-slider .carousel-caption h1 {
        font-size: 2.5rem; /* Dibuat sedikit lebih besar untuk Judul Halaman */
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    .news-slider .carousel-caption p {
        font-size: 1.1rem; /* Subtitel dibuat lebih besar */
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }
</style>
@endpush


@section('content')

<!-- 1. Header Halaman (DIGANTI DENGAN SLIDER) -->
<div class="container my-5">
    
    {{-- Slider ini tidak auto-scroll karena hanya 1 item --}}
    <div id="kontakHeader" class="carousel slide news-slider" data-bs-ride="false"
         style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
        
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://placehold.co/1920x400/007bff/white?text=Kontak+Kami" class="d-block w-100" alt="Kontak Header">
                
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="text-white">KONTAK</h1>
                    <p class="text-white-50">Hubungi kami untuk informasi lebih lanjut.</p>
                </div>
            </div>
        </div>
        
    </div>

</div> <!-- Penutup container slider -->


<!-- 2. Konten Kontak (Layout Diperbarui) -->
{{-- Wrapper .py-5 dan style margin-top negatif dihapus --}}
<div class="container my-5">
    <div class="card shadow-lg border-0" style="border-radius: 12px;">
        <div class="row g-0">
            <!-- Kolom Kiri: Info Kontak -->
            <div class="col-lg-5" style="background-color: var(--primary-color); color: white; border-radius: 12px 0 0 12px;">
                <div class="p-4 p-md-5">
                    <h3 class="fw-bold text-white mb-4">Silahkan Hubungi Kami</h3>
                    <p class="text-white-50">Jika Anda memerlukan sesuatu untuk ditanyakan atau dilaporkan, silakan hubungi kami melalui detail di bawah ini atau gunakan formulir di samping.</p>
                    <hr class="border-light">
                    <div class="d-flex align-items-start mb-3">
                        <i class="bi bi-geo-alt-fill fs-4 me-3 mt-1"></i>
                        <div>
                            <h5 class="text-white mb-1">Alamat</h5>
                            <p class="text-white-50 mb-0">Jl. Jend. Sudirman No. 123, Pekanbaru, Riau, 28282</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <i class="bi bi-envelope-fill fs-4 me-3 mt-1"></i>
                        <div>
                            <h5 class="text-white mb-1">Email</h5>
                            <p class="text-white-50 mb-0">info@dinsos.riau.go.id</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <i class="bi bi-telephone-fill fs-4 me-3 mt-1"></i>
                        <div>
                            <h5 class="text-white mb-1">Telepon</h5>
                            <p class="text-white-50 mb-0">(0761) 123-456</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Form -->
            <div class="col-lg-7">
                <div class="card-body p-4 p-md-5">
                    <h4 class="fw-bold mb-4">Kirim Pesan</h4>
                    
                    {{-- Notifikasi Sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('public.kontak.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required placeholder="Nama Lengkap Anda">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="email@anda.com">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="isi_pengaduan" class="form-label">Isi Pesan/Pengaduan</label>
                            <textarea class="form-control @error('isi_pengaduan') is-invalid @enderror" id="isi_pengaduan" name="isi_pengaduan" rows="6" required placeholder="Tuliskan pesan Anda di sini...">{{ old('isi_pengaduan') }}</textarea>
                            @error('isi_pengaduan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill fs-5 py-2">Kirim Pesan <i class="bi bi-send ms-1"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection