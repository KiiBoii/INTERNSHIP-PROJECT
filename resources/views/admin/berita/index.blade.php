@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4">Page Berita</h3>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">List Berita</h4>
        <a href="{{ route('berita.create') }}" class="btn btn-primary">
            <i class="bi bi-upload me-1"></i> Upload Berita
        </a>
    </div>

    {{-- ▼▼▼ PERBARUAN: FILTER SEKARANG BERFUNGSI ▼▼▼ --}}
    <div class="d-flex mb-3">
        <div class="dropdown me-2">
            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuTanggal" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-calendar3 me-1"></i> 
                {{-- Tampilkan filter aktif atau teks default --}}
                {{ request('tanggal') ? ucwords(str_replace('_', ' ', request('tanggal'))) : 'Tanggal' }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuTanggal">
                {{-- array_merge mempertahankan filter lain (cth: tag) saat mengganti tanggal --}}
                <li><a class="dropdown-item" href="{{ route('berita.index', array_merge(request()->query(), ['tanggal' => 'hari_ini'])) }}">Hari Ini</a></li>
                <li><a class="dropdown-item" href="{{ route('berita.index', array_merge(request()->query(), ['tanggal' => '7_hari'])) }}">7 Hari Terakhir</a></li>
                <li><a class="dropdown-item" href="{{ route('berita.index', array_merge(request()->query(), ['tanggal' => 'bulan_ini'])) }}">Bulan Ini</a></li>
            </ul>
        </div>
        <div class="dropdown me-2">
            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuTag" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-tag me-1"></i> 
                {{-- Tampilkan tag aktif atau teks default --}}
                {{ request('tag') ? ucfirst(request('tag')) : 'Tag Berita' }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuTag">
                <li><a class="dropdown-item" href="{{ route('berita.index', array_merge(request()->query(), ['tag' => 'info'])) }}">Info</a></li>
                <li><a class="dropdown-item" href="{{ route('berita.index', array_merge(request()->query(), ['tag' => 'layanan'])) }}">Layanan</a></li>
                <li><a class="dropdown-item" href="{{ route('berita.index', array_merge(request()->query(), ['tag' => 'kegiatan'])) }}">Kegiatan</a></li>
            </ul>
        </div>
        
        {{-- Tombol Reset hanya muncul jika ada filter aktif --}}
        @if(request('tanggal') || request('tag'))
        <a href="{{ route('berita.index') }}" class="btn btn-light">
            <i class="bi bi-x-circle"></i> Reset Filter
        </a>
        @endif
    </div>
    {{-- ▲▲▲ AKHIR PERBARUAN ▲▲▲ --}}

    <div class="row">
        @forelse ($beritas as $berita)
        <div class="col-md-4 mb-4">
            <div class="card h-100"> 
                
                @if($berita->gambar)
                    <img src="{{ asset('storage/'. $berita->gambar) }}" class="card-img-top" alt="{{ $berita->judul }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                        <span class="text-muted"><i class="bi bi-image-fill fs-3"></i></span>
                    </div>
                @endif
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $berita->judul }}</h5>
                    
                    {{-- ▼▼▼ PERBARUAN: TAMPILKAN TAG JIKA ADA ▼▼▼ --}}
                    @if($berita->tag)
                        <span class="badge 
                            @if($berita->tag == 'info') bg-info text-dark
                            @elseif($berita->tag == 'layanan') bg-success
                            @elseif($berita->tag == 'kegiatan') bg-warning text-dark
                            @endif
                            align-self-start mb-2">
                            Topik: {{ ucfirst($berita->tag) }}
                        </span>
                    @endif
                    {{-- ▲▲▲ AKHIR PERBARUAN ▲▲▲ --}}
                    
                    <small class="text-muted d-block text-end">{{ $berita->created_at->format('Y/m/d') }}</small>
                    
                    {{-- Ganti $berita->isi menjadi strip_tags() agar HTML tidak merusak layout --}}
                    <p class="card-text text-muted mt-2">{{ Str::limit(strip_tags($berita->isi), 100) }}</p>
                    
                    <hr class="mt-auto"> 
                    
                    <div class="d-flex justify-content-between">
                        <form action="{{ route('berita.destroy', $berita->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>
                        </form>
                        <a href="{{ route('berita.edit', $berita->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        {{-- Pesan jika tidak ada berita --}}
        <div class="col-12">
            <div class="alert alert-secondary text-center" role="alert">
                Tidak ada berita yang ditemukan.
                {{-- Tampilkan link reset jika sedang memfilter --}}
                @if(request('tanggal') || request('tag'))
                    <a href="{{ route('berita.index') }}" class="alert-link">Reset filter</a>
                @else
                    Belum ada berita yang dipublikasikan.
                @endif
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection