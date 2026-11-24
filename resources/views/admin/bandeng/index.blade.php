@extends('admin.layout')

@section('title', 'Lihat Data Bandeng - Bandeng Samudra')

@section('content')
<div class="container-fluid px-0">

    <div class="card p-4 rounded-4 border border-secondary card-glass-admin">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold text-white mb-1">Daftar Data Bandeng</h4>
                <p class="text-secondary small mb-0">Kelola semua data bandeng yang tersedia</p>
            </div>
            <a href="{{ route('admin.bandeng.create') }}" class="btn text-white fw-bold px-3 py-2" style="background: linear-gradient(90deg, #0d9488 0%, #115e59 100%); border-radius: 10px;">
                + Tambah Bandeng
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="--bs-table-bg: transparent;">
                <thead>
                    <tr class="text-secondary border-bottom border-secondary">
                        <th style="width: 55px;">No</th>
                        <th style="width: 90px;">ID</th>
                        <th style="width: 105px;">Foto</th>
                        <th>Nama Bandeng</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Deskripsi</th>
                        <th class="text-end" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produks as $index => $item)
                        @php
                            $namaFileFoto = !empty($item->foto) ? basename($item->foto) : null;
                            if ($namaFileFoto && file_exists(public_path('uploads/bandeng/' . $namaFileFoto))) {
                                $urlFoto = asset('uploads/bandeng/' . $namaFileFoto);
                            } elseif ($namaFileFoto && file_exists(public_path('uploads/bukti/' . $namaFileFoto))) {
                                $urlFoto = asset('uploads/bukti/' . $namaFileFoto);
                            } elseif (!empty($item->foto) && file_exists(public_path($item->foto))) {
                                $urlFoto = asset($item->foto);
                            } else {
                                $urlFoto = null;
                            }
                        @endphp
                        <tr class="border-bottom border-secondary border-opacity-25">
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge bg-info text-dark fw-bold">{{ $item->id_bandeng }}</span></td>
                            <td>
                                @if ($urlFoto)
                                    <img src="{{ $urlFoto }}"
                                         alt="{{ $item->nama_bandeng }}"
                                         class="rounded-3"
                                         style="width: 72px; height: 52px; object-fit: cover;">
                                @else
                                    <span class="text-secondary small">{{ $item->nama_bandeng }}</span>
                                @endif
                            </td>
                            <td class="fw-semibold text-white">{{ $item->nama_bandeng }}</td>
                            <td class="text-light">{{ $item->satuan }}</td>
                            <td class="text-info fw-semibold">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="text-light">{{ $item->stok }}</td>
                            <td class="text-secondary small" style="max-width: 240px;">{{ $item->deskripsi }}</td>
                            <td class="text-end">
                                <div class="d-flex flex-column gap-2 align-items-end">
                                    <a href="{{ route('admin.bandeng.edit', $item->id_bandeng) }}" class="btn btn-sm btn-primary px-3 w-100">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.bandeng.destroy', $item->id_bandeng) }}" method="POST" class="w-100" onsubmit="return confirm('Yakin ingin menghapus {{ $item->nama_bandeng }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-3 w-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-secondary py-4">
                                Belum ada data bandeng di database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection