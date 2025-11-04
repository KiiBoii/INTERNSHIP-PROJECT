@extends('layouts.public')

@section('content')

<!-- 1. Header Halaman (Sesuai CONTACT.jpg) -->
<div class="container-fluid" style="background: url('https://placehold.co/1920x400/007bff/white?text=Kontak+Kami') center center; background-size: cover;">
    <div class="row align-items-center" style="min-height: 300px; background-color: rgba(0, 0, 0, 0.4);">
        <div class="col-12 text-center">
            <h1 class="display-3 fw-bold text-white">KONTAK</h1>
            <p class="lead text-white-50">Hubungi kami untuk informasi lebih lanjut.</p>
        </div>
    </div>
</div>

<!-- 2. Konten Kontak (Sesuai CONTACT.jpg) -->
<div class="py-5" style="background-color: #f0f4f8;">
    <div class="container">
        {{-- Card ditarik ke atas header --}}
        <div class="card shadow-lg border-0" style="margin-top: -120px; border-radius: 12px;">
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

                        {{-- 
                            INI PERBAIKANNYA: 
                            Mengubah 'layanan.store' menjadi 'public.kontak.store'
                            sesuai dengan file routes/web.php Anda.
                        --}}
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
</div>

<!-- Peta (Opsional) -->
<div class="container-fluid p-0">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.664478332158!2d101.4451013147535!3d0.5098059996505307!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5ac0850029531%3A0xe13c613e547e1781!2sKantor%20Gubernur%20Riau!5e0!3m2!1sen!2sid!4v1678888888888!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>

@endsection

