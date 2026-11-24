@extends('admin.layout')

@section('title', 'Edit Bandeng - Bandeng Samudra')

@section('content')
@php
    $item = $produk ?? $bandeng;
    $daftarSatuan = $daftarSatuan ?? ['kg', 'pack', 'pcs', 'ekor'];
    $satuanDipilih = old('satuan', $item->satuan ?? 'kg');

    $namaFileFoto = !empty($item->foto) ? basename($item->foto) : null;
    if ($namaFileFoto && file_exists(public_path('uploads/bandeng/' . $namaFileFoto))) {
        $urlFotoEdit = asset('uploads/bandeng/' . $namaFileFoto);
    } elseif ($namaFileFoto && file_exists(public_path('uploads/bukti/' . $namaFileFoto))) {
        $urlFotoEdit = asset('uploads/bukti/' . $namaFileFoto);
    } elseif (!empty($item->foto) && file_exists(public_path($item->foto))) {
        $urlFotoEdit = asset($item->foto);
    } else {
        $urlFotoEdit = null;
    }
@endphp

<div class="container-fluid px-0">

    <div class="card p-4 rounded-4 border border-secondary mb-4 card-glass-admin">
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
                <div class="card p-4 rounded-4 border border-secondary h-100 card-glass-admin">
                    <div class="mb-3">
                        <label class="form-label text-secondary small">ID Bandeng</label>
                        <input type="text" class="form-control text-secondary border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="{{ $item->id_bandeng }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small">Nama Bandeng</label>
                        <input type="text" name="nama_bandeng" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="{{ old('nama_bandeng', $item->nama_bandeng) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Satuan</label>
                            <select name="satuan" class="form-select text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" required>
                                @foreach ($daftarSatuan as $satuan)
                                    <option value="{{ $satuan }}" {{ $satuanDipilih === $satuan ? 'selected' : '' }}>
                                        {{ $satuan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Stok</label>
                            <input type="number" name="stok" min="0" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="{{ old('stok', $item->stok) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small">Harga (Rp)</label>
                        <input type="number" name="harga" min="0" step="any" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="{{ old('harga', $item->harga) }}" required>
                    </div>

                    <div class="mb-0">
                        <label class="form-label text-secondary small">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card p-4 rounded-4 border border-secondary h-100 d-flex flex-column justify-content-between card-glass-admin">
                    <div>
                        <label class="form-label text-secondary small d-block">Foto Produk</label>
                        <input type="file" name="foto" class="form-control text-white border-secondary mb-3" style="background: rgba(3, 19, 31, 0.75);" accept="image/*">

                        @if ($urlFotoEdit)
                            <div class="text-center">
                                <img src="{{ $urlFotoEdit }}" alt="{{ $item->nama_bandeng }}" class="img-fluid rounded-3" style="max-height: 180px; object-fit: cover;">
                                <div class="text-secondary small mt-2">Foto saat ini</div>
                            </div>
                        @else
                            <div class="text-center text-secondary small fst-italic py-4 border border-secondary rounded-3">
                                {{ $item->foto ?: 'Belum ada foto produk' }}
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn text-white fw-bold w-100 mt-4 py-2" style="background: linear-gradient(90deg, #0d9488 0%, #115e59 100%);">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection