@extends('admin.layout')

@section('title', 'Input Bandeng - Bandeng Samudra')

@section('content')
@php
    $daftarSatuan = $daftarSatuan ?? ['kg', 'pack', 'pcs', 'ekor'];
    $satuanDipilih = old('satuan', 'kg');
@endphp

<div class="container-fluid px-0">

    <div class="card p-4 rounded-4 border border-secondary mb-4" style="background: rgba(11, 25, 44, 0.88); border-color: rgba(13, 202, 240, 0.25) !important;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-info text-dark mb-2 px-3 py-1 fw-bold">Data Bandeng</span>
                <h4 class="fw-bold text-white mb-0">Input Data Bandeng Baru</h4>
            </div>
            <a href="{{ route('admin.bandeng.index') }}" class="btn btn-outline-light btn-sm px-3">
                Lihat Data
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

    <form action="{{ route('admin.bandeng.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card p-4 rounded-4 border border-secondary h-100" style="background: rgba(11, 25, 44, 0.88);">
                    <div class="mb-3">
                        <label class="form-label text-secondary small">ID Bandeng</label>
                        <input type="text" name="id_bandeng" class="form-control bg-dark text-white border-secondary" value="{{ old('id_bandeng', $randomId ?? 'BD004') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small">Nama Bandeng</label>
                        <input type="text" name="nama_bandeng" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: Bandeng Bakar" value="{{ old('nama_bandeng') }}" required>
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
                            <input type="number" name="stok" min="0" class="form-control bg-dark text-white border-secondary" placeholder="0" value="{{ old('stok') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small">Harga (Rp)</label>
                        <input type="number" name="harga" min="0" step="any" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: 40000" value="{{ old('harga') }}" required>
                    </div>

                    <div class="mb-0">
                        <label class="form-label text-secondary small">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: 200 gr, sedappp">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card p-4 rounded-4 border border-secondary h-100 d-flex flex-column justify-content-between" style="background: rgba(11, 25, 44, 0.88);">
                    <div>
                        <label class="form-label text-secondary small d-block">Foto Produk</label>
                        <input type="file" name="foto" class="form-control bg-dark text-white border-secondary" accept="image/*">
                        <div class="text-secondary small mt-2">Format: JPG, JPEG, PNG, WEBP (maks. 2MB).</div>
                    </div>

                    <button type="submit" class="btn btn-info text-dark fw-bold w-100 mt-4 py-2">
                        Simpan Bandeng
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection