@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- PASTIKAN VARIABEL $dokumen ADA DULU SEBELUM MENGGUNAKANNYA --}}
    <h3 class="mb-4">Edit Dokumen: {{ $dokumen->judul ?? 'Loading...' }}</h3> 

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            {{-- PERBAIKAN UTAMA: Secara eksplisit tentukan 'dokumen' => $dokumen --}}
            {{-- Ini memastikan parameter {dokumen} terisi, menghindari kebingungan Laravel --}}
            <form action="{{ route('admin.dokumen.update', ['dokumen' => $dokumen]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Dokumen</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $dokumen->judul) }}" required>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan Singkat</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ old('keterangan', $dokumen->keterangan) }}" placeholder="Contoh: RKA 2024 KUA PPAS">
                </div>
                
                <div class="mb-3">
                    <label for="dokumen_file" class="form-label">Ganti File Dokumen (Opsional)</label>
                    <input type="file" class="form-control" id="dokumen_file" name="dokumen_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip">
                    <small class="text-muted d-block">File saat ini: **{{ $dokumen->file_name }}** (Diunggah pada: {{ $dokumen->created_at->format('d M Y') }})</small>
                    <small class="text-danger">Kosongkan jika tidak ingin mengganti file.</small>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.dokumen.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection