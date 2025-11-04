@extends('layouts.public')

@section('content')

<!-- 1. Header Halaman (Sesuai PROFIL.jpg) -->
<div class="container-fluid" style="background: url('https://placehold.co/1920x500/333/fff?text=Tentang+Kami') center center; background-size: cover;">
    <div class="row align-items-center" style="min-height: 400px; background-color: rgba(0, 0, 0, 0.5);">
        <div class="col-12 text-center">
            <h1 class="display-3 fw-bold text-white">PROFIL</h1>
            <p class="lead text-white-50">Visi, Misi, dan Struktur Organisasi Dinas Sosial Provinsi Riau.</p>
        </div>
    </div>
</div>

<!-- 2. Konten Sejarah (Sesuai PROFIL.jpg) -->
<div class="container my-5">
    <div class="row align-items-center">
        <div class="col-lg-7">
            <small class="text-primary fw-bold text-uppercase">Tentang Kami</small>
            <h2 class="section-title text-start ps-0" style="margin-left: 0; margin-bottom: 1.5rem;">Dinas Sosial Provinsi Riau</h2>
            <p class="text-muted">
                Dinas Sosial Provinsi Riau merupakan unsur pelaksana urusan pemerintahan di bidang sosial yang menjadi kewenangan Daerah. 
                Dinas Sosial mempunyai tugas membantu Gubernur melaksanakan urusan pemerintahan bidang sosial yang menjadi kewenangan Daerah dan 
                Tugas Pembantuan yang diberikan kepada Daerah Provinsi.
            </p>
            <p class="text-muted">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse potenti. Nulla facilisi. Praesent sed felis metus. 
                Vestibulum ac mauris pretium, consequat eros vitae, volutpat neque. Mauris pretium, nisl sed facilisis eleifend.
            </p>
            <ul class="list-unstyled text-muted">
                <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Melaksanakan program rehabilitasi sosial.</li>
                <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Melaksanakan program perlindungan dan jaminan sosial.</li>
                <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Melaksanakan program pemberdayaan sosial dan penanganan fakir miskin.</li>
            </ul>
        </div>
        <div class="col-lg-5">
            <img src="https://placehold.co/600x400/e0e0e0/999?text=Foto+Gedung" class="img-fluid rounded-3 shadow-sm" alt="Gedung Dinas Sosial Riau">
        </div>
    </div>
</div>

<!-- 3. Visi & Misi (Sesuai PROFIL.jpg) -->
<div class="py-5" style="background-color: #ffffff;">
    <div class="container">
        <h2 class="section-title">Visi dan Misi</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-5">
                <div class="card h-100 shadow-sm border-0" style="border-top: 4px solid var(--primary-color);">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-eye-fill display-4 text-primary mb-3"></i>
                        <h4 class="fw-bold">VISI</h4>
                        <p class="text-muted">"Terwujudnya Kesejahteraan Sosial Masyarakat di Provinsi Riau yang Berkeadilan dan Merata."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card h-100 shadow-sm border-0" style="border-top: 4px solid var(--primary-color);">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-bullseye display-4 text-primary mb-3"></i>
                        <h4 class="fw-bold">MISI</h4>
                        <ul class="list-unstyled text-muted text-start">
                            <li>1. Meningkatkan kualitas pelayanan sosial.</li>
                            <li>2. Mengembangkan program pemberdayaan sosial.</li>
                            <li>3. Memperkuat jaring pengaman sosial.</li>
                            <li>4. Meningkatkan partisipasi masyarakat dalam pembangunan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4. Struktur Organisasi (Sesuai PROFIL.jpg) -->
<div class="container my-5">
    <h2 class="section-title">Struktur Organisasi</h2>
    <div class="text-center">
        <!--  -->
        <img src="https://placehold.co/1200x800/e0e0e0/999?text=Struktur+Organisasi+Placeholder" class="img-fluid rounded-3 shadow-sm" alt="Struktur Organisasi Dinas Sosial Riau">
        <p class="text-muted mt-2">Bagan Struktur Organisasi Dinas Sosial Provinsi Riau Tahun 2025</p>
    </div>
</div>

@endsection
