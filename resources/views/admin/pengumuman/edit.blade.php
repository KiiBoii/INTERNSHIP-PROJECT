@extends('layouts.admin')

{{-- 1. Tambahkan CSS untuk Summernote --}}
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs5.min.css" rel="stylesheet">
    <style>
        .note-editor.note-frame {
            border-radius: 0.375rem;
        }
        .note-editable {
            min-height: 250px;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Edit Pengumuman: "{{ $pengumuman->judul }}"</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm rounded-3 border-0">
        <div class="card-body">
            {{-- 2. TAMBAHKAN enctype="multipart/form-data" DI SINI --}}
            <form action="{{ route('pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Pengumuman</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $pengumuman->judul) }}" required>
                </div>

                {{-- 3. GANTI 'id="isi"' MENJADI 'id="summernote"' --}}
                <div class="mb-3">
                    <label for="summernote" class="form-label">Isi Pengumuman</label>
                    <textarea class="form-control" id="summernote" name="isi" rows="8" required>{{ old('isi', $pengumuman->isi) }}</textarea>
                </div>

                {{-- 4. TAMBAHKAN BLOK INPUT GAMBAR --}}
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar (Opsional)</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                    <small class="text-muted">Max 2MB. Biarkan kosong jika tidak ingin mengubah.</small>
                    
                    @if($pengumuman->gambar)
                        <div class="mt-2">
                            <p>Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $pengumuman->gambar) }}" alt="{{ $pengumuman->judul }}" style="max-width: 200px; border-radius: 8px;">
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary" style="background-color: #007bff; border: none; border-radius: 20px; padding: 10px 30px;">Update Pengumuman</button>
                <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary ms-2" style="border-radius: 20px; padding: 10px 30px;">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- 5. Tambahkan Script untuk Summernote --}}
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs5.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Summernote
            $('#summernote').summernote({
                placeholder: 'Tulis isi pengumuman di sini...',
                tabsize: 2,
                height: 250,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        });
    </script>
@endpush