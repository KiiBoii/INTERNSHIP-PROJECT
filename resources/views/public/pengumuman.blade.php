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
    <div id="pengumumanHeader" class="carousel slide news-slider" data-bs-ride="false"
         style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
        
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://placehold.co/1920x400/ffc107/333?text=Pengumuman" class="d-block w-100" alt="Pengumuman Header">
                
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="text-white">PENGUMUMAN</h1>
                    <p class="text-white-50">Informasi penting dan pengumuman resmi dari Dinas Sosial Provinsi Riau.</p>
                </div>
            </div>
        </div>
        
    </div>

</div> <!-- Penutup container slider -->


<!-- 2. Konten Pengumuman -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h2 class="section-title">Daftar Pengumuman</h2>
            
            @forelse($pengumumans as $item)
            <div class="card card-news mb-4">
                <div class="card-body p-4">
                    <h4 class="card-title fw-bold">{{ $item->judul }}</h4>
                    <p class="card-date text-muted"><i class="bi bi-calendar3 me-2"></i>Diposting pada: {{ $item->created_at->format('d F Y') }}</p>
                    <hr>
                    <div class="card-text">
                        {!! nl2br(e($item->isi)) !!} {{-- nl2br untuk menghargai baris baru, e() untuk keamanan --}}
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-secondary text-center">
                Belum ada pengumuman terbaru.
            </div>
            @endforelse

            <!-- Paginasi -->
            <div class="d-flex justify-content-center mt-4">
                {!! $pengumumans->links() !!}
            </div>
        </div>
    </div>
</div>

@endsection