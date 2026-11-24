@extends('admin.layout')

@section('title', 'Edit Pegawai - Bandeng Samudra')

@section('content')
<div class="container-fluid px-0">

    <div class="p-4 rounded-4 card-glass-admin mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-info text-dark mb-2 px-3 py-1 fw-bold">
                    {{ $pegawai->jabatan === 'kasir' ? 'Kasir' : 'Kurir / Karyawan' }}
                </span>
                <h4 class="fw-bold text-white mb-0">Edit Pegawai ({{ $pegawai->id_pegawai }})</h4>
            </div>
            <a href="{{ route('admin.pegawai.index') }}" class="btn btn-outline-light btn-sm px-3">
                Kembali
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

    <form action="{{ route('admin.pegawai.update', $pegawai->id_pegawai) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="p-4 rounded-4 card-glass-admin">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-secondary small">Jabatan / Role</label>
                    <input type="text" class="form-control text-secondary border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="{{ $pegawai->jabatan === 'kasir' ? 'Kasir' : 'Kurir / Karyawan' }}" readonly>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-secondary small">ID Pegawai</label>
                    <input type="text" class="form-control text-secondary border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="{{ $pegawai->id_pegawai }}" readonly>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-secondary small">Status Pegawai</label>
                    <select name="status" class="form-select text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" required>
                        <option value="Aktif" {{ old('status', $pegawai->status) === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Cuti" {{ old('status', $pegawai->status) === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                        <option value="Tidak Aktif" {{ old('status', $pegawai->status) === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="{{ old('nama', $pegawai->nama) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Email</label>
                    <input type="email" name="email" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="{{ old('email', $pegawai->email) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">No. Telp</label>
                    <input type="text" name="no_telp" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="{{ old('no_telp', $pegawai->no_telp) }}">
                </div>

                @if ($pegawai->jabatan === 'kasir')
                    <div class="col-md-6">
                        <label class="form-label text-secondary small">Alamat</label>
                        <input type="text" name="alamat" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="{{ old('alamat', $pegawai->alamat) }}">
                    </div>
                @endif

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Username</label>
                    <input type="text" name="username" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="{{ old('username', $pegawai->username) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Password Baru <span class="text-secondary">(Kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" placeholder="Isi hanya jika ingin mengganti password">
                </div>
            </div>

            <div class="mt-4 pt-3 border-top border-secondary d-flex justify-content-end gap-2">
                <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" class="btn text-white fw-bold px-4" style="background: linear-gradient(90deg, #0d9488 0%, #115e59 100%);">Simpan Perubahan</button>
            </div>
        </div>
    </form>

</div>
@endsection