@extends('admin.layout')

@section('title', 'Tambah Pegawai - Bandeng Samudra')

@section('content')
<div class="container-fluid px-0">

    <div class="p-4 rounded-4 card-glass-admin mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-info text-dark mb-2 px-3 py-1 fw-bold">Data Pegawai</span>
                <h4 class="fw-bold text-white mb-0">Tambah Pegawai Baru</h4>
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

    <form action="{{ route('admin.pegawai.store') }}" method="POST">
        @csrf
        <div class="p-4 rounded-4 card-glass-admin">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-secondary small">Jabatan / Role</label>
                    <select name="jabatan" id="selectJabatan" class="form-select text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" required>
                        <option value="karyawan" {{ old('jabatan', 'karyawan') === 'karyawan' ? 'selected' : '' }}>Kurir / Karyawan</option>
                        <option value="kasir" {{ old('jabatan') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-secondary small">ID Pegawai</label>
                    <input type="text" name="id_pegawai" id="inputIdPegawai" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="{{ old('id_pegawai', $nextIdKaryawan ?? 'KR001') }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-secondary small">Status Pegawai</label>
                    <select name="status" class="form-select text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" required>
                        <option value="Aktif" {{ old('status', 'Aktif') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Cuti" {{ old('status') === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                        <option value="Tidak Aktif" {{ old('status') === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" placeholder="Contoh: Budi Santoso" value="{{ old('nama') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Email</label>
                    <input type="email" name="email" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" placeholder="contoh@gmail.com" value="{{ old('email') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">No. Telp</label>
                    <input type="text" name="no_telp" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" placeholder="081234567890" value="{{ old('no_telp') }}">
                </div>

                <div class="col-md-6" id="fieldAlamat" style="display: {{ old('jabatan') === 'kasir' ? 'block' : 'none' }};">
                    <label class="form-label text-secondary small">Alamat (Khusus Kasir)</label>
                    <input type="text" name="alamat" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" placeholder="Alamat tempat tinggal" value="{{ old('alamat') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Username</label>
                    <input type="text" name="username" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" placeholder="username_pegawai" value="{{ old('username') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Password</label>
                    <input type="password" name="password" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" placeholder="Minimal 4 karakter" required>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top border-secondary d-flex justify-content-end gap-2">
                <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" class="btn text-white fw-bold px-4" style="background: linear-gradient(90deg, #0d9488 0%, #115e59 100%);">Simpan Pegawai</button>
            </div>
        </div>
    </form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectJabatan = document.getElementById('selectJabatan');
        const inputId = document.getElementById('inputIdPegawai');
        const fieldAlamat = document.getElementById('fieldAlamat');
        const nextIdKasir = @json($nextIdKasir ?? 'KS001');
        const nextIdKaryawan = @json($nextIdKaryawan ?? 'KR001');

        selectJabatan.addEventListener('change', function () {
            if (this.value === 'kasir') {
                inputId.value = nextIdKasir;
                fieldAlamat.style.display = 'block';
            } else {
                inputId.value = nextIdKaryawan;
                fieldAlamat.style.display = 'none';
            }
        });
    });
</script>
@endsection