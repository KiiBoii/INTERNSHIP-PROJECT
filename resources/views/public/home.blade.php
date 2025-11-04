@extends('layouts.public')

@section('content')

<!-- 1. Bagian Slider/Hero (Sesuai HOME PAGE.jpg) -->
<div id="heroSlider" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="1" aria-label="Slide 2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <!--  -->
            <img src="https://placehold.co/1920x600/a1c4fd/ffffff?text=Image+Slider+Placeholder+1" class="d-block w-100" alt="Slider 1" style="object-fit: cover; max-height: 600px;">
            <div class="carousel-caption d-none d-md-block text-start">
                <h5>Selamat Datang di Dinas Sosial Riau</h5>
                <p>Melayani dengan hati, menjangkau seluruh lapisan masyarakat.</p>
            </div>
        </div>
        <div class="carousel-item">
            <!--  -->
            <img src="https://placehold.co/1920x600/007bff/white?text=Program+Bantuan+Sosial+2025" class="d-block w-100" alt="Slider 2" style="object-fit: cover; max-height: 600px;">
            <div class="carousel-caption d-none d-md-block text-start">
                <h5>Program Bantuan Sosial 2025</h5>
                <p>Informasi terbaru seputar program bantuan sosial di Provinsi Riau.</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- 2. Bagian Sambutan Kepala Dinas (Sesuai HOME PAGE.jpg) -->
<div class="container my-5">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <small class="text-primary fw-bold text-uppercase">Profil</small>
            <h2 class="fw-bold mb-3" style="color: #0d47a1;">KEPALA DINAS</h2>
            
            <div class="d-flex mb-3">
                <!--  -->
                <img src="https://placehold.co/150x150/e0e0e0/333?text=FOTO+KADIS" class="rounded-circle" alt="Foto Kepala Dinas" style="width: 150px; height: 150px; object-fit: cover;">
                <div class="ms-4">
                    <h4 class="fw-bold mb-1">Nama Kepala Dinas, S.H., M.Si.</h4>
                    <p class="text-muted mb-2">Kepala Dinas Sosial Provinsi Riau</p>
                    <p class="text-muted small">
                        Tempat/Tgl Lahir: Pekanbaru, 01 Januari 1970<br>
                        Masa Jabatan: 2023 - Sekarang
                    </p>
                    <div class="d-flex">
                        <a href="#" class="btn btn-primary btn-sm rounded-pill me-2">Baca Lebih Lanjut</a>
                        <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill mx-2"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mt-4">Kata Sambutan</h5>
            <p class="text-muted">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse potenti. Nulla facilisi. Praesent sed felis metus. Vestibulum ac mauris pretium, consequat eros vitae, volutpat neque. Mauris pretium, nisl sed facilisis eleifend, eros felis mollis ante, ac tincidunt lacus felis non
            erat. Suspendisse potenti."</p>
        </div>
        <div class="col-lg-4">
            <h5 class="fw-bold mb-3">Video Kegiatan Kepala Dinas</h5>
            <div class="ratio ratio-16x9 rounded-3 shadow-sm">
                <!-- Placeholder Video Youtube -->
                <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ?si=example" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

<!-- 3. Bagian Berita Terbaru (Sesuai HOME PAGE.jpg) -->
<div class="py-5" style="background-color: #ffffff;">
    <div class="container">
        <h2 class="section-title">Berita Terbaru</h2>
        
        @if($beritaUtama)
        <div class="card mb-5 shadow-lg border-0">
            <div class="row g-0">
                <div class="col-md-6">
                    @if($beritaUtama->gambar)
                        <img src="{{ asset('storage/' . $beritaUtama->gambar) }}" class="img-fluid rounded-start" alt="{{ $beritaUtama->judul }}" style="height: 400px; width: 100%; object-fit: cover;">
                    @else
                        <!--  -->
                        <img src="https://placehold.co/600x400/e0e0e0/999?text=Berita+Utama" class="img-fluid rounded-start" alt="Placeholder" style="height: 400px; width: 100%; object-fit: cover;">
                    @endif
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <div class="card-body p-lg-5">
                        <h3 class="card-title fw-bold mb-3">{{ $beritaUtama->judul }}</h3>
                        <p class="card-date text-muted"><i class="bi bi-calendar3 me-2"></i>{{ $beritaUtama->created_at->format('d F Y') }}</p>
                        <p class="card-text">{{ Str::limit($beritaUtama->isi, 250) }}</p>
                        <a href="#" class="btn btn-primary rounded-pill mt-3">Baca Selengkapnya <i class="bi bi-arrow-right-short"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Berita Lainnya --}}
        <div class="p-4 rounded-3" style="background-color: var(--primary-color);">
            <h4 class="text-white fw-bold mb-3 text-center">Berita Lainnya</h4>
            <div class="row">
                @forelse($beritaLainnya as $berita)
                <div class="col-lg col-md-4 col-sm-6 mb-3 mb-lg-0">
                    <div class="card card-news h-100">
                        @if($berita->gambar)
                            <img src="{{ asset('storage/' . $berita->gambar) }}" class="card-img-top" alt="{{ $berita->judul }}" style="height: 150px; object-fit: cover;">
                        @else
                            <!--  -->
                            <img src="https://placehold.co/300x150/e0e0e0/999?text=Berita" class="card-img-top" alt="Placeholder" style="height: 150px; object-fit: cover;">
                        @endif
                        <div class="card-body p-3">
                            <p class="card-date">{{ $berita->created_at->format('d M Y') }}</p>
                            <h6 class="card-title small fw-bold">
                                <a href="#" class="text-decoration-none text-dark stretched-link">
                                    {{ Str::limit($berita->judul, 50) }}
                                </a>
                            </h6>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-white text-center">Belum ada berita lainnya.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

@endsection

