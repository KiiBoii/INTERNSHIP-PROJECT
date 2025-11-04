@extends('layouts.public')

@section('content')

<!-- 1. Header Halaman (Sesuai GALERRY.jpg) -->
<div class="container-fluid" style="background: url('https://placehold.co/1920x400/17a2b8/white?text=Galeri+Kegiatan') center center; background-size: cover;">
    <div class="row align-items-center" style="min-height: 300px; background-color: rgba(0, 0, 0, 0.4);">
        <div class="col-12 text-center">
            <h1 class="display-3 fw-bold text-white">GALERI</h1>
            <p class="lead text-white-50">Dokumentasi kegiatan Dinas Sosial Provinsi Riau.</p>
        </div>
    </div>
</div>

<!-- 2. Konten Galeri (Sesuai GALERRY.jpg) -->
<div class="container my-5">
    <h2 class="section-title">Gallery Kegiatan</h2>
    
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @forelse($galeris as $foto)
        <div class="col">
            <div class="card card-news h-100">
                @if($foto->foto_path)
                    <img src="{{ asset('storage/' . $foto->foto_path) }}" class="card-img-top" alt="{{ $foto->judul_kegiatan }}" style="height: 250px; object-fit: cover;">
                @else
                    <img src="https://placehold.co/300x250/e0e0e0/999?text=Foto" class="card-img-top" alt="Placeholder" style="height: 250px; object-fit: cover;">
                @endif
                <div class="card-body p-3">
                    <h6 class="card-title fw-bold text-center">
                        <a href="#" class="text-decoration-none text-dark stretched-link">
                            {{ $foto->judul_kegiatan }}
                        </a>
                    </h6>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-secondary text-center">
                Belum ada foto kegiatan di galeri.
            </div>
        </div>
        @endforelse
    </div>

    <!-- Paginasi -->
    <div class="d-flex justify-content-center mt-4">
        {!! $galeris->links() !!}
    </div>
</div>

@endsection
