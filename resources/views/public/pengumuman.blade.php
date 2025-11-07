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
    
    <div id="pengumumanSlider" class="carousel slide news-slider" data-bs-ride="carousel" data-bs-pause="false" data-bs-interval="3000"
         style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
        
        <div class="carousel-indicators">
            @foreach($pengumumans->take(3) as $item) {{-- Ambil 3 untuk slider --}}
                <button type="button" data-bs-target="#pengumumanSlider" data-bs-slide-to="{{ $loop->index }}" 
                        class="@if($loop->first) active @endif" 
                        aria-current="@if($loop->first) true @endif" 
                        aria-label="Slide {{ $loop->iteration }}">
                </button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @forelse($pengumumans->take(3) as $item) {{-- Loop 3 pengumuman pertama --}}
            <div class="carousel-item @if($loop->first) active @endif">
                {{-- Gunakan gambar pengumuman jika ada, jika tidak, gunakan placeholder --}}
                <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/1920x400/ffc107/333?text=Pengumuman' }}" class="d-block w-100" alt="{{ $item->judul }}">
                
                <div class="carousel-caption d-none d-md-block">
                    <h5>{{ $item->judul }}</h5>
                    <p>{{ Str::limit(strip_tags($item->isi), 150) }}</p>
                </div>
            </div>
            @empty
            {{-- Fallback jika tidak ada pengumuman sama sekali --}}
            <div class="carousel-item active">
                <img src="https://placehold.co/1920x400/ffc107/333?text=Pengumuman" class="d-block w-100" alt="Pengumuman Header">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="text-white">PENGUMUMAN</h1>
                    <p class="text-white-50">Informasi penting dan pengumuman resmi dari Dinas Sosial Provinsi Riau.</p>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Hanya tampilkan tombol navigasi jika ada lebih dari 1 pengumuman --}}
        @if($pengumumans->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#pengumumanSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#pengumumanSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        @endif
        
    </div>

</div> <!-- Penutup container slider -->


<!-- 2. Konten Pengumuman (DIPERBARUI) -->
<div class="container my-5">
    <div class="row justify-content-center">
        {{-- Diubah ke col-lg-10 agar lebih lebar untuk 2 kolom --}}
        <div class="col-lg-10">
            <h2 class="section-title">Daftar Pengumuman</h2>
            
            {{-- Tambahkan row baru untuk grid --}}
            <div class="row">
                @forelse($pengumumans as $item)
                
                {{-- Bungkus setiap card dengan col-md-6 --}}
                <div class="col-md-6 mb-4">
                    <div class="card card-news h-100"> {{-- Tambahkan h-100 --}}
                        <div class="card-body p-4">
                            
                            {{-- Tampilkan Gambar di sini jika ada --}}
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="img-fluid rounded mb-3" alt="{{ $item->judul }}" style="width: 100%; height: 300px; object-fit: cover;">
                            @endif

                            <h4 class="card-title fw-bold">{{ $item->judul }}</h4>
                            <p class="card-date text-muted"><i class="bi bi-calendar3 me-2"></i>Diposting pada: {{ $item->created_at->format('d F Y') }}</p>
                            <hr>
                            
                            {{-- Tampilkan isi dari Summernote (menggunakan {!! !!}) --}}
                            <div class="card-text article-content">
                                {!! $item->isi !!} 
                            </div>

                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-secondary text-center">
                        Belum ada pengumuman terbaru.
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Paginasi -->
            <div class="d-flex justify-content-center mt-4">
                {!! $pengumumans->links() !!}
            </div>
        </div>
    </div>
</div>

@endsection