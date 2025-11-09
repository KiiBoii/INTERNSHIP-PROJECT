@extends('layouts.public')

{{-- CSS Kustom untuk halaman detail --}}
@push('styles')
<style>
    .article-header {
        margin-bottom: 2rem;
    }
    .article-category {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--primary-color);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .article-meta {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 1.5rem;
    }
    .article-meta .author {
        font-weight: 600;
        color: #333;
    }
    .article-main-image {
        width: 100%;
        height: 450px; 
        object-fit: cover; 
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        background-color: #e0e0e0; 
    }
    .article-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #343a40;
    }
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }

    /* Sidebar Berita Terkait / Topik */
    .sidebar-card {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
    }
    /* Style untuk daftar topik (menggunakan style dari berita.blade.php) */
    .sidebar-card .list-unstyled a {
        display: flex;
        align-items: flex-start;
        text-decoration: none;
        color: #212529;
    }
    .sidebar-card .list-unstyled img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
    }
    .sidebar-card .list-unstyled h6 {
        font-size: 0.9rem;
        line-height: 1.3;
        font-weight: 600;
    }
    .sidebar-card .list-unstyled .badge {
        font-size: 0.7rem;
    }
</style>
@endpush

@section('content')

<div class="container my-5">
    <div class="row">

        <div class="col-lg-8">
            <article>
                <header class="article-header">
                    <div class="article-category">
                        {{-- PERBARUAN: Gunakan tag jika ada, jika tidak, 'Berita' --}}
                        {{ $berita->tag ? ucfirst($berita->tag) : 'Berita' }}
                    </div>
                    
                    <h1 class="display-5 fw-bold my-3" style="color: var(--dark-blue);">
                        {{ $berita->judul }}
                    </h1>
                    
                    <div class="article-meta">
                        {{-- ▼▼▼ PERBARUAN: Ambil nama user dari relasi ▼▼▼ --}}
                        By <span class="author">{{ $berita->user->name ?? 'Admin' }}</span> | 
                        {{ $berita->created_at->format('d F Y, H:i') }} WIB
                    </div>
                </header>

                @if($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" class="article-main-image" alt="{{ $berita->judul }}">
                @else
                <div class="article-main-image" style="background-color: #e9ecef; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                    <span>Gambar tidak tersedia</span>
                </div>
                @endif
                
                <div class="article-content">
                    {!! $berita->isi !!}
                </div>
            </article>
        </div>

        <div class="col-lg-4">
            {{-- 
                KELAS 'sticky-top' DAN STYLE 'top' TELAH DIHAPUS DARI DIV DI BAWAH INI
            --}}
            <div class="card sidebar-card">
                <div class="card-body">
                    {{-- ▼▼▼ PERBARUAN: Judul dan Loop diubah ▼▼▼ --}}
                    <h5 class="fw-bold mb-4" style="color: var(--dark-blue);">Topik Lainnya</h5>
                    
                    <ul class="list-unstyled">
                        {{-- Ganti $related_news menjadi $topik_lainnya --}}
                        @forelse($topik_lainnya as $topik)
                        <li class="mb-3 border-bottom pb-3">
                            <a href="{{ route('public.berita.detail', $topik->id) }}" class="d-flex text-decoration-none text-dark">
                                <img src="{{ $topik->gambar ? asset('storage/'. $topik->gambar) : 'https://placehold.co/70x70/e0e0e0/999?text=Topik' }}" 
                                     alt="{{ $topik->judul }}" 
                                     style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
                                <div class="ms-3">
                                    {{-- Tambahkan badge tag --}}
                                    <span class="badge 
                                        @if($topik->tag == 'info') bg-info text-dark
                                        @elseif($topik->tag == 'layanan') bg-success
                                        @elseif($topik->tag == 'kegiatan') bg-warning text-dark
                                        @endif
                                        mb-1">
                                        {{ ucfirst($topik->tag) }}
                                    </span>
                                    <h6 class="mb-1">
                                        {{ $topik->judul }}
                                    </h6>
                                    <small class="text-muted">{{ $topik->created_at->format('d F Y') }}</small>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li class="mb-3 text-muted small">
                            Belum ada topik lainnya.
                        </li>
                        @endforelse
                    </ul>
                    {{-- ▲▲▲ AKHIR PERBARUAN ▲▲▲ --}}
                </div>
            </div>
        </div>

    </div>
</div>

@endsection