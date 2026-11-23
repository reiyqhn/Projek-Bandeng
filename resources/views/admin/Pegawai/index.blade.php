@extends('admin.layout')

@section('title', 'Data Pegawai - Bandeng Samudra')

@section('content')
<div class="container-fluid px-0">

    @if (session('success'))
        <div class="alert alert-success bg-success bg-opacity-25 border-0 text-white mb-4 rounded-4 p-3">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger bg-danger bg-opacity-25 border-0 text-white mb-4 rounded-4 p-3">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card p-4 rounded-4 border border-secondary" style="background: rgba(11, 25, 44, 0.88); border-color: rgba(13, 202, 240, 0.25) !important;">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold text-white mb-1">Data Pegawai</h4>
                <p class="text-secondary small mb-0">Kelola data pegawai yang tersimpan di tabel karyawan</p>
            </div>
            <a href="{{ route('admin.pegawai.create') }}" class="btn btn-info text-dark fw-bold px-3 py-2" style="border-radius: 10px;">
                + Tambah Pegawai
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="--bs-table-bg: transparent;">
                <thead>
                    <tr class="text-secondary border-bottom border-secondary">
                        <th style="width: 60px;">No</th>
                        <th>ID Pegawai</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Username</th>
                        <th class="text-end" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pegawais as $index => $pegawai)
                        <tr class="border-bottom border-secondary border-opacity-25">
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge bg-info text-dark fw-bold">{{ $pegawai->id_karyawan }}</span></td>
                            <td class="fw-semibold text-white">{{ $pegawai->nama }}</td>
                            <td class="text-light">{{ $pegawai->email }}</td>
                            <td class="text-light">{{ $pegawai->no_telp }}</td>
                            <td class="text-info">{{ $pegawai->username }}</td>
                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.pegawai.edit', $pegawai->id_karyawan) }}" class="btn btn-sm btn-primary px-3">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.pegawai.destroy', $pegawai->id_karyawan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pegawai {{ $pegawai->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-3">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-secondary py-4">
                                Belum ada data pegawai di database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection