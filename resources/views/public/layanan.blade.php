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
</style>
@endpush

@section('content')

<!-- 1. Header Halaman (DIGANTI DENGAN SLIDER) -->
<div class="container my-5">
    
    <div id="heroSlider" class="carousel slide news-slider" data-bs-ride="carousel" data-bs-pause="false" data-bs-interval="3000" 
         style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
        
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            {{-- Ini adalah placeholder slider dari home.blade.php --}}
            {{-- Idealnya, Anda mengirim data dinamis dari PageController@layanan --}}
            <div class="carousel-item active">
                <img src="https://placehold.co/1920x600/6610f2/white?text=Layanan+Publik" class="d-block w-100" alt="Slider 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>LAYANAN PUBLIK</h5>
                    <p>Informasi layanan, pusat bantuan, dan formulir pengaduan.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://placehold.co/1920x600/007bff/white?text=Program+Bantuan+Sosial" class="d-block w-100" alt="Slider 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Program Bantuan Sosial</h5>
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

        <!-- Kolom Kanan: Form Pengaduan (Sesuai LAYANAN PUBLIK.jpg) -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0" style="top: -50px;">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">Hubungi Kami</h4>
                    <p class="text-muted small">Silakan sampaikan masukan atau pengaduan Anda melalui formulir di bawah ini.</p>
                    
                    {{-- FORM DUMMY (TIDAK ADA ACTION POST) --}}
                    <form>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="isi_pengaduan" class="form-label">Isi Pesan/Pengaduan</label>
                            <textarea class="form-control" id="isi_pengaduan" name="isi_pengaduan" rows="5" required></textarea>
                        </div>
                        <button type="button" class="btn btn-primary w-100 rounded-pill">Kirim Pesan <i class="bi bi-send ms-1"></i></button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection