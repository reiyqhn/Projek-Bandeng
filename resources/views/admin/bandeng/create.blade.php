@extends('admin.layout')
@section('title', 'Tambah Bandeng')
@section('content')
<div class="create-bandeng-page">

    <div class="create-heading">
        <div>
            <h2>Input Data Bandeng</h2>
            <p>Masukkan informasi bandeng yang ingin ditambahkan.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Data belum berhasil disimpan.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.bandeng.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="create-form-layout">

            {{-- FORM INFORMASI BANDENG --}}
            <div class="create-form-card">

                <div class="create-card-heading">
                    <h3>📝 Informasi Bandeng</h3>
                </div>

                <div class="create-form-grid">

                    <div class="create-form-group">
                        <label for="nama_bandeng">Nama Bandeng</label>
                        <input
                            type="text"
                            id="nama_bandeng"
                            name="nama_bandeng"
                            value="{{ old('nama_bandeng') }}"
                            placeholder="Contoh: Bandeng Samudra"
                            required>
                    </div>

                    <div class="create-form-group">
                        <label for="satuan">Berat / Satuan</label>
                        <input
                            type="text"
                            id="satuan"
                            name="satuan"
                            value="{{ old('satuan') }}"
                            placeholder="Contoh: 400 - 600 gr"
                            required>
                    </div>

                    <div class="create-form-group">
                        <label for="harga">Harga</label>
                        <div class="create-price-input">
                            <span>Rp</span>
                            <input
                                type="number"
                                id="harga"
                                name="harga"
                                value="{{ old('harga') }}"
                                placeholder="Masukkan harga"
                                min="0"
                                required>
                        </div>
                    </div>

                    <div class="create-form-group">
                        <label for="stok">Stok</label>
                        <input
                            type="number"
                            id="stok"
                            name="stok"
                            value="{{ old('stok') }}"
                            placeholder="150"
                            min="0"
                            required>
                    </div>

                    <div class="create-form-group create-full-width">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            rows="4"
                            placeholder="Tuliskan deskripsi bandeng...">{{ old('deskripsi') }}</textarea>
                    </div>

                </div>

                <div class="create-form-actions">
                    <a href="{{ route('admin.bandeng.index') }}"
                       class="create-btn-cancel">
                        Batal
                    </a>

                    <button type="submit" class="create-btn-save">
                        Simpan
                    </button>
                </div>

            </div>

            {{-- FORM UPLOAD FOTO --}}
            <div class="create-upload-card">

                <div class="create-card-heading">
                    <h3>Upload Foto</h3>
                </div>

                <label for="foto" class="create-upload-area">
                    <img
                        id="create-foto-preview"
                        class="create-foto-preview"
                        alt="Pratinjau foto bandeng"
                        hidden>

                    <div id="create-upload-placeholder">
                        <span class="create-upload-icon">🖼️</span>
                        <strong>Pilih Foto</strong>
                    </div>
                </label>

                <input
                    type="file"
                    id="foto"
                    name="foto"
                    accept="image/*"
                    class="create-file-input">

                <p id="create-file-name" class="create-file-name">
                    Belum ada foto dipilih
                </p>

            </div>

        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputFoto = document.getElementById('foto');
    const preview = document.getElementById('create-foto-preview');
    const placeholder = document.getElementById('create-upload-placeholder');
    const fileName = document.getElementById('create-file-name');

    inputFoto.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            preview.removeAttribute('src');
            preview.hidden = true;
            placeholder.hidden = false;
            fileName.textContent = 'Belum ada foto dipilih';
            return;
        }

        if (!file.type.startsWith('image/')) {
            alert('Silakan pilih file gambar.');
            this.value = '';
            preview.removeAttribute('src');
            preview.hidden = true;
            placeholder.hidden = false;
            fileName.textContent = 'Belum ada foto dipilih';
            return;
        }

        preview.src = URL.createObjectURL(file);
        preview.hidden = false;
        placeholder.hidden = true;
        fileName.textContent = file.name;
    });
});
</script>
@endsection