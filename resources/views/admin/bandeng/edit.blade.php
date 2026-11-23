@extends('admin.layout')

@section('title', 'Edit Bandeng - Bandeng Samudra')

@section('content')
@php
    $item = $produk ?? $bandeng;
    $daftarSatuan = $daftarSatuan ?? ['kg', 'pack', 'pcs', 'ekor'];
    $satuanDipilih = old('satuan', $item->satuan ?? 'kg');
@endphp

<div class="container-fluid px-0">

    <div class="card p-4 rounded-4 border border-secondary mb-4" style="background: rgba(11, 25, 44, 0.88); border-color: rgba(13, 202, 240, 0.25) !important;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-info text-dark mb-2 px-3 py-1 fw-bold">Data Bandeng</span>
                <h4 class="fw-bold text-white mb-0">Edit Data Bandeng ({{ $item->id_bandeng }})</h4>
            </div>
            <a href="{{ route('admin.bandeng.index') }}" class="btn btn-outline-light btn-sm px-3">
                Kembali ke Lihat Data
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger bg-danger bg-opacity-25 border-0 text-white mb-4 rounded-4 p-3">
            <div class="fw-bold mb-1">Terjadi kesalahan input:</div>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.bandeng.update', $item->id_bandeng) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card p-4 rounded-4 border border-secondary h-100" style="background: rgba(11, 25, 44, 0.88);">
                    <div class="mb-3">
                        <label class="form-label text-secondary small">ID Bandeng</label>
                        <input type="text" class="form-control bg-dark text-secondary border-secondary" value="{{ $item->id_bandeng }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small">Nama Bandeng</label>
                        <input type="text" name="nama_bandeng" class="form-control bg-dark text-white border-secondary" value="{{ old('nama_bandeng', $item->nama_bandeng) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Satuan</label>
                            <select name="satuan" class="form-select bg-dark text-white border-secondary" required>
                                @foreach ($daftarSatuan as $satuan)
                                    <option value="{{ $satuan }}" {{ $satuanDipilih === $satuan ? 'selected' : '' }}>
                                        {{ $satuan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Stok</label>
                            <input type="number" name="stok" min="0" class="form-control bg-dark text-white border-secondary" value="{{ old('stok', $item->stok) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small">Harga (Rp)</label>
                        <input type="number" name="harga" min="0" step="any" class="form-control bg-dark text-white border-secondary" value="{{ old('harga', $item->harga) }}" required>
                    </div>

                    <div class="mb-0">
                        <label class="form-label text-secondary small">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="form-control bg-dark text-white border-secondary">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card p-4 rounded-4 border border-secondary h-100 d-flex flex-column justify-content-between" style="background: rgba(11, 25, 44, 0.88);">
                    <div>
                        <label class="form-label text-secondary small d-block">Foto Produk</label>
                        <input type="file" name="foto" class="form-control bg-dark text-white border-secondary mb-3" accept="image/*">

                        @if (!empty($item->foto) && file_exists(public_path('uploads/bandeng/' . $item->foto)))
                            <div class="text-center">
                                <img src="{{ asset('uploads/bandeng/' . $item->foto) }}" alt="{{ $item->nama_bandeng }}" class="img-fluid rounded-3" style="max-height: 180px; object-fit: cover;">
                                <div class="text-secondary small mt-2">Foto saat ini</div>
                            </div>
                        @else
                            <div class="text-center text-secondary small fst-italic py-4 border border-secondary rounded-3">
                                {{ $item->foto ?: 'Belum ada foto produk' }}
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-info text-dark fw-bold w-100 mt-4 py-2">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection