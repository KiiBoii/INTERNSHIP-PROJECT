@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h3 class="mb-0">Pesan Kontak Masuk</h3>
    <p class="text-muted mb-4">Daftar pesan yang dikirim oleh pengunjung melalui halaman "Kontak" publik.</p>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Isi Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data $pesanKontak ini dikirim dari KontakController --}}
                        @forelse ($pesanKontak as $pesan)
                            <tr>
                                <th scope="row">{{ $loop->iteration + ($pesanKontak->currentPage() - 1) * $pesanKontak->perPage() }}</th>
                                <td>{{ $pesan->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $pesan->nama }}</td>
                                <td><a href="mailto:{{ $pesan->email }}">{{ $pesan->email }}</a></td>
                                <td>{{ Str::limit($pesan->isi_pengaduan, 100) }}</td>
                                {{-- Anda bisa tambahkan tombol "Lihat Detail" di sini jika perlu --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada pesan kontak yang masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Link Paginasi (jika datanya banyak) -->
            <div class="mt-3">
                {!! $pesanKontak->links() !!}
            </div>
            
        </div>
    </div>
</div>
@endsection

