@extends('layouts.public')

@push('styles')
<style>
    /* Style untuk filter sidebar */
    .filter-sidebar .list-group-item {
        border: none;
        padding: 0.75rem 0;
    }
    .filter-sidebar .list-group-item a {
        text-decoration: none;
        transition: all 0.2s ease;
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
</style>
@endpush

@section('content')

<!-- 1. Header Halaman (Tidak berubah) -->
<div class="container-fluid" style="background: url('https://placehold.co/1920x400/17a2b8/white?text=Galeri+Kegiatan') center center; background-size: cover;">
    <div class="row align-items-center" style="min-height: 300px; background-color: rgba(0, 0, 0, 0.4);">
        <div class="col-12 text-center">
            <h1 class="display-3 fw-bold text-white">GALERI</h1>
            <p class="lead text-white-50">Dokumentasi kegiatan Dinas Sosial Provinsi Riau.</p>
        </div>
    </div>
</div>

<!-- 2. Konten Galeri (Layout Diperbarui) -->
<div class="container my-5">
    <div class="row">

        <!-- A. Sidebar Filter (Kiri) -->
        <div class="col-lg-3">
            <div class="card shadow-sm border-0" style="border-radius: 12px; top: 100px;">
                <div class="card-body p-4 filter-sidebar">
                    <h5 class="fw-bold mb-3" style="color: var(--dark-blue);">Filter Bidang</h5>
                    <ul class="list-group list-group-flush">
                        
                        <!-- Link untuk 'Semua' -->
                        <li class="list-group-item">
                            <a href="{{ route('public.galeri') }}" 
                               class="d-flex justify-content-between align-items-center {{ !request('bidang') ? 'active' : '' }}">
                                <span>Seluruh Kegiatan Bidang</span>
                                @if(!request('bidang'))
                                    <i class="bi bi-check"></i>
                                @endif
                            </a>
                        </li>

                        <!-- Loop untuk setiap bidang dari database -->
                        @foreach($bidangList ?? [] as $bidang)
                        <li class="list-group-item">
                            <a href="{{ route('public.galeri', ['bidang' => $bidang]) }}" 
                               class="d-flex justify-content-between align-items-center {{ request('bidang') == $bidang ? 'active' : '' }}">
                                <span>{{ $bidang }}</span>
                                @if(request('bidang') == $bidang)
                                    <i class="bi bi-check"></i>
                                @endif
                            </a>
                        </li>
                        @endforeach
                        
                        {{-- Contoh Dummy jika $bidangList kosong --}}
                        @if(!isset($bidangList) || $bidangList->isEmpty())
                            <li class="list-group-item"><a href="#" class="text-dark">Bidang Infrastruktur TIK</a></li>
                            <li class="list-group-item"><a href="#" class="text-dark">Bidang Statistik</a></li>
                            <li class="list-group-item"><a href="#" class="text-dark">Bidang Aptika</a></li>
                            <li class="list-group-item"><a href="#" class="text-dark">Bidang IKP</a></li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>

        <!-- B. Grid Galeri (Kanan) -->
        <div class="col-lg-9">
            <h2 class="section-title">
                {{ request('bidang') ?? 'Semua Kegiatan' }}
            </h2>
            
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
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
                            {{-- Tampilkan nama bidang (opsional) --}}
                            <p class="text-center text-muted small mb-0">{{ $foto->bidang }}</p>
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
                {!! $galeris->links() !!}
            </div>

        </div> <!-- Penutup col-lg-9 -->

    </div> <!-- Penutup .row -->
</div>

@endsection