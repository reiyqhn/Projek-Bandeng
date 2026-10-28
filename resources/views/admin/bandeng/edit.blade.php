@extends('admin.layout')

@section('title', 'Edit Bandeng - Projek Bandeng')

@section('content')
<div class="create-bandeng-page">

    <div class="create-heading">
        <div>
            <h2>✏️ Edit Bandeng</h2>
            <p>Perbarui informasi produk bandeng yang dipilih.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <strong>Periksa kembali data yang kamu masukkan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('admin.bandeng.update', $produk->id_bandeng) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="create-form-layout">

            <div class="create-form-card">
                <div class="create-form-grid">

                    <div class="create-form-group create-full-width">
                        <label for="nama_bandeng">Nama Bandeng</label>
                        <input
                            type="text"
                            id="nama_bandeng"
                            name="nama_bandeng"
                            value="{{ old('nama_bandeng', $produk->nama_bandeng) }}"
                            required
                        >
                    </div>

                    <div class="create-form-group">
                        <label for="satuan">Berat / Satuan</label>
                        <input
                            type="text"
                            id="satuan"
                            name="satuan"
                            value="{{ old('satuan', $produk->satuan) }}"
                            placeholder="Contoh: 400 - 600 gr"
                            required
                        >
                    </div>

                    <div class="create-form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input
                            type="number"
                            id="harga"
                            name="harga"
                            value="{{ old('harga', $produk->harga) }}"
                            min="0"
                            required
                        >
                    </div>

                    <div class="create-form-group">
                        <label for="stok">Stok</label>
                        <input
                            type="number"
                            id="stok"
                            name="stok"
                            value="{{ old('stok', $produk->stok) }}"
                            min="0"
                            required
                        >
                    </div>

                    <div class="create-form-group create-full-width">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            rows="5"
                        >{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    </div>

                </div>

                <div class="create-form-actions">
                    <a
                        href="{{ route('admin.bandeng.index') }}"
                        class="create-btn-cancel"
                    >
                        Batal
                    </a>

                    <button type="submit" class="create-btn-save">
                        Simpan Perubahan
                    </button>
                </div>
            </div>

            <div class="create-upload-card">
                <h3>Foto Bandeng</h3>

                @if ($produk->foto)
                    <div class="create-foto-preview">
                        <img
                            src="{{ asset('uploads/bukti/' . basename($produk->foto)) }}"
                            alt="Foto {{ $produk->nama_bandeng }}"
                            style="width: 100%; max-width: 250px; height: auto; object-fit: cover;"
                        >
                    </div>
                @else
                    <div class="create-upload-placeholder">
                        Belum ada foto
                    </div>
                @endif

                <div class="create-form-group">
                    <label for="foto">Pilih Foto Baru (Opsional)</label>
                    <input
                        type="file"
                        id="foto"
                        name="foto"
                        class="create-file-input"
                        accept="image/jpeg,image/png,image/webp"
                    >
                    <small>Kosongkan jika tidak ingin mengganti foto.</small>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection