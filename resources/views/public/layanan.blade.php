@extends('layouts.public')

{{-- 1. CSS KUSTOM DITAMBAHKAN UNTUK SLIDER --}}
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

    .news-slider .carousel-caption h5 {
        font-size: 2rem; 
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    .news-slider .carousel-caption p {
        font-size: 1rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }
    
    /* === CSS BARU UNTUK KARTU KONTAK === */
    .contact-card-link {
        display: block;
        background-color: #f8f9fa; /* Warna abu-abu sangat muda */
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.25rem;
        text-decoration: none;
        color: #333;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }
    .contact-card-link:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.05);
        color: var(--primary-color);
        border-color: var(--primary-color);
    }
    .contact-card-link i {
        font-size: 1.5rem;
        margin-right: 1rem;
        color: var(--primary-color);
        vertical-align: middle;
    }
    /* === AKHIR CSS BARU === */

</style>
@endpush

@section('content')

<!-- 1. Header Halaman (DIGANTI DENGAN SLIDER DINAMIS) -->
<div class="container my-5">
    
    <div id="heroSlider" class="carousel slide news-slider" data-bs-ride="carousel" data-bs-pause="false" data-bs-interval="3000" 
         style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
        
        <!-- Indicators (Dibuat dinamis) -->
        <div class="carousel-indicators">
            {{-- Periksa apakah variabel $sliders ada dan merupakan Collection --}}
            @if(isset($sliders) && $sliders->count() > 0)
                @foreach($sliders as $slider)
                    <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Slide {{ $loop->iteration }}"></button>
                @endforeach
            @else
                {{-- Indikator Fallback --}}
                <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            @endif
        </div>
        
        <!-- Slides (Dibuat dinamis dengan forelse) -->
        <div class="carousel-inner">
            @forelse(isset($sliders) ? $sliders : [] as $slider)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    {{-- Pastikan Anda menggunakan asset('storage/') untuk gambar yang disimpan di disk 'public' --}}
                    <img src="{{ asset('storage/' . $slider->gambar) }}" class="d-block w-100" alt="{{ $slider->judul }}">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{ $slider->judul }}</h5>
                        <p>{{ $slider->keterangan }}</p>
                    </div>
                </div>
            @empty
                {{-- Fallback jika tidak ada data slider yang tersedia --}}
                <div class="carousel-item active">
                    <img src="https://placehold.co/1920x450/6610f2/white?text=LAYANAN+DINAS+SOSIAL" class="d-block w-100" alt="Slider Fallback">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>LAYANAN PUBLIK</h5>
                        <p>Informasi layanan, pusat bantuan, dan formulir pengaduan.</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        {{-- Tampilkan tombol navigasi hanya jika slide lebih dari 1 --}}
        @if(isset($sliders) && $sliders->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        @endif
    </div>

</div> <!-- Penutup container slider -->


<!-- 2. Konten Layanan (Sesuai LAYANAN PUBLIK.jpg) -->
<div class="container my-5">
    <div class="row">
        <!-- Kolom Kiri: Layanan & FAQ -->
        <div class="col-lg-8">
            <h2 class="section-title text-start ps-0" style="margin-left: 0; margin-bottom: 2rem;">Pelayanan Mandiri</h2>
            <p class="text-muted mb-4">Temukan informasi layanan yang Anda butuhkan melalui tautan di bawah ini.</p>
            <div class="row g-3 mb-5">
                <div class="col-md-4">
                    <a href="#" class="btn btn-primary w-100 p-3 fs-5 rounded-3">Info Bantuan</a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="btn btn-outline-primary w-100 p-3 fs-5 rounded-3">Cek Status DTKS</a>
                </div>
                <div class="col-md-4">
                    <a href="#pusat-bantuan" class="btn btn-outline-primary w-100 p-3 fs-5 rounded-3">Pusat Bantuan</a>
                </div>
            </div>

            <!-- Pusat Bantuan / FAQ (Sesuai LAYANAN PUBLIK.jpg) -->
            <h3 id="pusat-bantuan" class="fw-bold mb-4">Pusat Bantuan</h3>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Bagaimana cara mendaftar Bantuan Sosial?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Pendaftaran Bantuan Sosial dilakukan melalui Data Terpadu Kesejahteraan Sosial (DTKS). Silakan mendaftar ke kantor desa/lurah setempat...
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Apa saja syarat untuk mendapatkan rehabilitasi sosial?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Syarat utama adalah...
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Bagaimana cara melaporkan pengaduan?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Anda dapat menggunakan formulir pengaduan di samping, atau menghubungi kami melalui kontak yang tertera.
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- === KOLOM KANAN DIPERBARUI === -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Hubungi Kami</h4>
                    
                    <a href="{{ route('public.kontak') }}" class="contact-card-link mb-3">
                        <i class="bi bi-pencil-square"></i>
                        <span>Masukan</span>
                    </a>
                    
                    <a href="mailto:info@dinsos.riau.go.id" class="contact-card-link">
                        <i class="bi bi-envelope-fill"></i>
                        <span>Email Kontak</span>
                    </a>

                </div>
            </div>
        </div>
        {{-- === AKHIR KOLOM KANAN === --}}

    </div>
</div>

@endsection