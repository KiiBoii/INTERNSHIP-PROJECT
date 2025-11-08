@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Pengelolaan Dokumen Publikasi</h3>
        <a href="{{ route('admin.dokumen.create') }}" class="btn btn-primary">
            Tambah Dokumen
        </a>
    </div>

    {{-- Hapus duplikasi notifikasi di sini. Layout utama sudah menangani notifikasi --}}
    

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dokumenTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Dokumen</th>
                            <th>Keterangan</th>
                            <th>Nama File</th>
                            <th>Tanggal Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokumens as $dokumen)
                        <tr id="dokumen-{{ $dokumen->id }}"> {{-- Tambahkan ID untuk JS --}}
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dokumen->judul }}</td>
                            <td>{{ $dokumen->keterangan }}</td>
                            <td>{{ $dokumen->file_name }}</td>
                            <td>{{ $dokumen->created_at->format('d M Y') }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.dokumen.edit', $dokumen->id) }}" class="btn btn-sm btn-info text-white">Edit</a>
                                <a href="{{ $dokumen->download_url }}" class="btn btn-sm btn-success" target="_blank">Download</a>
                                
                                {{-- Pastikan form memiliki ID unik jika menggunakan JS --}}
                                <form action="{{ route('admin.dokumen.destroy', $dokumen->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus dokumen ini? File akan dihapus permanen.')" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada dokumen yang diunggah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Anda mungkin perlu menginisialisasi DataTables jika Anda menggunakannya --}}
{{-- 
<script>
    $(document).ready(function() {
        $('#dokumenTable').DataTable();
    });
</script> 
--}}
@endpush