@extends('layouts.public')

{{-- CSS Kustom (DITAMBAHKAN STYLE SLIDER) --}}
@push('styles')
<style>
    /* === 1. CSS BARU UNTUK SLIDER (DARI BERITA) === */
    .news-slider .carousel-item {
        height: 450px; /* Atur tinggi slider */
        background-color: #555;
    }
    .news-slider .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .news-slider .carousel-item::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.7) 25%, rgba(0,0,0,0) 100%);
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
    /* === AKHIR CSS SLIDER === */

    /* 2. Style untuk filter sidebar (Tidak berubah) */
    .filter-sidebar .list-group-item {
        border: none;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .filter-sidebar .list-group-item:last-child {
        border-bottom: none;
    }
    .filter-sidebar .list-group-item a {
        text-decoration: none;
        transition: all 0.2s ease;
        font-weight: 500;
    }
    .filter-sidebar .list-group-item a.active {
        color: var(--primary-color);
        font-weight: 700;
    }
    .filter-sidebar .list-group-item a:not(.active) {
        color: #212529;
    }
    .filter-sidebar .list-group-item a:not(.active):hover {
        color: var(--primary-color);
    }

    /* 2. Style "HOT NEWS" (dari berita.blade.php) */
    .card-news-hover {
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        background-color: #e0e0e0;
    }

    /* === PENTING UNTUK MASONRY === */
    .card-news-hover .card-img-top {
        transition: transform 0.4s ease;
        width: 100%;
        height: auto; /* Biarkan tinggi gambar otomatis agar asimetris */
        object-fit: cover;
    }
    /* === AKHIR PERUBAHAN === */

    .card-news-hover:hover .card-img-top {
        transform: scale(1.05);
    }
    .card-hover-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 60%);
        display: flex;
        align-items: flex-end;
        padding: 1rem;
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    .card-news-hover:hover .card-hover-caption {
        opacity: 1;
    }
    .card-hover-caption h6 {
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 0;
        line-height: 1.4;
        font-size: 0.9rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        transform: translateY(15px);
        transition: transform 0.4s ease 0.1s;
    }
    .card-news-hover:hover .card-hover-caption h6 {
        transform: translateY(0);
    }
    .gallery-bidang-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 5;
        background-color: rgba(0, 123, 255, 0.9);
        color: white;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    /* === 3. CSS BARU UNTUK MASONRY GRID === */
    /* Menghapus padding 'g-4' dari .row agar Masonry bisa mengatur margin */
    .gallery-grid-row {
        margin-left: -1rem;
        margin-right: -1rem;
    }

    .grid-item {
        width: 33.333%; /* 3 kolom */
        padding: 1rem; /* Jarak antar gambar */
    }

    /* Penyesuaian untuk layar lebih kecil */
    @media (max-width: 991.98px) {
        .grid-item {
            width: 50%; /* 2 kolom di tablet */
        }
    }
    @media (max-width: 575.98px) {
        .grid-item {
            width: 100%; /* 1 kolom di mobile */
        }
    }
    /* === AKHIR CSS MASONRY === */
</style>
@endpush

@section('content')

<!-- 1. Header Halaman (DIGANTI DENGAN SLIDER) -->
<div class="container my-5">

    <div id="gallerySlider" class="carousel slide mb-5 news-slider" data-bs-ride="carousel" data-bs-pause="false" data-bs-interval="3000" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
        
        <div class="carousel-indicators">
            {{-- Loop sebanyak 6 item (atau kurang jika tidak ada) --}}
            @foreach($galeris->take(6) as $foto_slide)
                <button type="button" data-bs-target="#gallerySlider" data-bs-slide-to="{{ $loop->index }}" 
                        class="@if($loop->first) active @endif" 
                        aria-current="@if($loop->first) true @endif" 
                        aria-label="Slide {{ $loop->iteration }}">
                </button>
            @endforeach
        </div>

        <div class="carousel-inner">
            {{-- Loop 6 foto pertama dari galeri --}}
            @forelse($galeris->take(6) as $foto_slide)
            <div class="carousel-item @if($loop->first) active @endif">
                <img src="{{ $foto_slide->foto_path ? asset('storage/' . $foto_slide->foto_path) : 'https://placehold.co/1200x450/e0e0e0/999?text=Galeri' }}" class="d-block w-100" alt="{{ $foto_slide->judul_kegiatan }}">
                
                <div class="carousel-caption d-none d-md-block">
                    <a href="#" class="text-decoration-none text-white stretched-link">
                        <h5>{{ $foto_slide->judul_kegiatan }}</h5>
                    </a>
                    {{-- Menampilkan nama bidang di slider --}}
                    <p>{{ $foto_slide->bidang }}</p>
                </div>
            </div>
            @empty
            <!-- Fallback jika tidak ada foto sama sekali -->
            <div class="carousel-item active">
                <img src="https://placehold.co/1200x450/17a2b8/white?text=Galeri+Kegiatan" class="d-block w-100" alt="Placeholder">
                <div class="carousel-caption d-none d-md-block">
                    <h5>GALERI KEGIATAN</h5>
                    <p>Dokumentasi kegiatan Dinas Sosial Provinsi Riau.</p>
                </div>
            </div>
            @endforelse
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#gallerySlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#gallerySlider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <!-- 2. Konten Galeri (Layout Diperbarui dengan Filter List) -->
    <div class="row">

        <!-- A. Sidebar Filter (Kiri) - Tidak berubah -->
        <div class="col-lg-3">
            <div class="card shadow-sm border-0" style="border-radius: 12px; top: 100px;">
                <div class="card-body p-4 filter-sidebar">
                    <h5 class="fw-bold mb-3" style="color: var(--dark-blue);">Filter Bidang</h5>
                    
                    <ul class="list-group list-group-flush">
                        
                        <li class="list-group-item">
                            <a href="{{ route('public.galeri') }}" 
                               class="d-flex justify-content-between align-items-center {{ !request('bidang') ? 'active' : '' }}">
                                <span>Seluruh Kegiatan Bidang</span>
                                @if(!request('bidang'))
                                    <i class="bi bi-check text-primary"></i>
                                @endif
                            </a>
                        </li>

                        @foreach($bidangList as $bidang)
                        <li class="list-group-item">
                            <a href="{{ route('public.galeri', ['bidang' => $bidang]) }}" 
                               class="d-flex justify-content-between align-items-center {{ request('bidang') == $bidang ? 'active' : '' }}">
                                <span>{{ $bidang }}</span>
                                @if(request('bidang') == $bidang)
                                    <i class="bi bi-check text-primary"></i>
                                @endif
                            </a>
                        </li>
                        @endforeach
                        
                        @if($bidangList->isEmpty())
                            <li class="list-group-item"><a href="#" class="text-dark">Bidang Aptika</a></li>
                            <li class="list-group-item"><a href="#" class="text-dark">Bidang IKP</a></li>
                            <li class="list-group-item"><a href="#" class="text-dark">Bidang Statistik</a></li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>

        <!-- B. Grid Galeri (Kanan) - DIPERBARUI DENGAN MASONRY -->
        <div class="col-lg-9">
            <h2 class="section-title">
                {{ request('bidang') ?? 'Semua Kegiatan' }}
            </h2>
            
            <div class="row gallery-grid-row" data-masonry='{"percentPosition": true, "itemSelector": ".grid-item"}'>
                
                @forelse($galeris as $foto)
                {{-- 4. Mengubah 'col' menjadi 'grid-item' dengan class kolom spesifik --}}
                <div class="grid-item col-sm-6 col-md-4">
                    {{-- 5. Menghapus 'h-100' agar tinggi kartu bisa dinamis --}}
                    <div class="card card-news-hover"> 
                        @if($foto->foto_path)
                            {{-- 6. Menghapus 'style="height: 250px;"' agar tinggi gambar otomatis --}}
                            <img src="{{ asset('storage/' . $foto->foto_path) }}" class="card-img-top" alt="{{ $foto->judul_kegiatan }}">
                        @else
                            <img src="https://placehold.co/300x250/e0e0e0/999?text=Foto" class="card-img-top" alt="Placeholder">
                        @endif
                        
                        @if($foto->bidang)
                            <span class="gallery-bidang-badge">{{ $foto->bidang }}</span>
                        @endif

                        <a href="#" class="stretched-link"></a>

                        <div class="card-hover-caption">
                            <h6>{{ $foto->judul_kegiatan }}</h6>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-secondary text-center">
                        Belum ada foto kegiatan untuk bidang ini.
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Paginasi -->
            <div class="d-flex justify-content-center mt-4">
                {!! $galeris->appends(request()->query())->links() !!}
            </div>

        </div> <!-- Penutup col-lg-9 -->

    </div> <!-- Penutup .row -->
</div>

@endsection

{{-- JavaScript untuk Masonry --}}
@push('scripts')
{{-- 1. Load library Masonry.js dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" xintegrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+dOCLsfzmy4GzBWoLkmMGVwRkmRNmFisOMFacPgyC" crossorigin="anonymous" async></script>
@endpush