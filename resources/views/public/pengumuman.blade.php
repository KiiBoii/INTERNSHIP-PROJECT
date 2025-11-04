@extends('layouts.public')

@section('content')

<!-- 1. Header Halaman -->
<div class="container-fluid" style="background: url('https://placehold.co/1920x400/ffc107/333?text=Pengumuman') center center; background-size: cover;">
    <div class="row align-items-center" style="min-height: 300px; background-color: rgba(0, 0, 0, 0.4);">
        <div class="col-12 text-center">
            <h1 class="display-3 fw-bold text-white">PENGUMUMAN</h1>
            <p class="lead text-white-50">Informasi penting dan pengumuman resmi dari Dinas Sosial Provinsi Riau.</p>
        </div>
    </div>
</div>

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
