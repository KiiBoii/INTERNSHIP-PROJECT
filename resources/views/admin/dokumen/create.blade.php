@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Unggah Dokumen Baru</h3>

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
            {{-- Tambahkan ID ke Form untuk JS --}}
            <form id="dokumenForm" action="{{ route('admin.dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Dokumen</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan Singkat</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" placeholder="Contoh: RKA 2024 KUA PPAS">
                </div>
                
                <div class="mb-3">
                    <label for="dokumen_file" class="form-label">File Dokumen (PDF/DOC/XLS/ZIP)</label>
                    <input type="file" class="form-control" id="dokumen_file" name="dokumen_file" required accept=".pdf,.doc,.docx,.xls,.xlsx,.zip">
                    <small class="text-muted">Ukuran maksimal file adalah 50MB.</small>
                </div>

                {{-- Tambahkan ID ke tombol submit --}}
                <button type="submit" id="submitButton" class="btn btn-primary">Unggah Dokumen</button>
                <a href="{{ route('admin.dokumen.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('dokumenForm').addEventListener('submit', function() {
        const button = document.getElementById('submitButton');
        // Menonaktifkan tombol submit saat form dikirim
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengunggah...';
    });
</script>
@endpush