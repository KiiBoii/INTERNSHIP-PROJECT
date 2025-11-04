@extends('layouts.public')

@section('content')

<!-- 1. Header Halaman (Sesuai LAYANAN PUBLIK.jpg) -->
<div class="container-fluid" style="background: url('https://placehold.co/1920x400/6610f2/white?text=Layanan+Publik') center center; background-size: cover;">
    <div class="row align-items-center" style="min-height: 300px; background-color: rgba(0, 0, 0, 0.4);">
        <div class="col-12 text-center">
            <h1 class="display-3 fw-bold text-white">LAYANAN</h1>
            <p class="lead text-white-50">Informasi layanan, pusat bantuan, dan formulir pengaduan masyarakat.</p>
        </div>
    </div>
</div>

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

