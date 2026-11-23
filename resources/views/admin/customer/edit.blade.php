@extends('admin.layout')

@section('title', 'Edit Customer - Bandeng Samudra')

@section('content')
<div class="container-fluid px-0">

    <div class="card p-4 rounded-4 border border-secondary mb-4" style="background: rgba(11, 25, 44, 0.88); border-color: rgba(13, 202, 240, 0.25) !important;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-info text-dark mb-2 px-3 py-1 fw-bold">Data Customer</span>
                <h4 class="fw-bold text-white mb-0">Edit Customer ({{ $customer->id_customer }})</h4>
            </div>
            <a href="{{ route('admin.customer.index') }}" class="btn btn-outline-light btn-sm px-3">
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

    <form action="{{ route('admin.customer.update', $customer->id_customer) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card p-4 rounded-4 border border-secondary" style="background: rgba(11, 25, 44, 0.88);">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-secondary small">ID Customer</label>
                    <input type="text" class="form-control bg-dark text-secondary border-secondary" value="{{ $customer->id_customer }}" readonly>
                </div>

                <div class="col-md-8">
                    <label class="form-label text-secondary small">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control bg-dark text-white border-secondary" value="{{ old('nama', $customer->nama) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Email</label>
                    <input type="email" name="email" class="form-control bg-dark text-white border-secondary" value="{{ old('email', $customer->email) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">No. Telp</label>
                    <input type="text" name="no_telp" class="form-control bg-dark text-white border-secondary" value="{{ old('no_telp', $customer->no_telp) }}">
                </div>

                <div class="col-md-12">
                    <label class="form-label text-secondary small">Alamat</label>
                    <textarea name="alamat" rows="2" class="form-control bg-dark text-white border-secondary">{{ old('alamat', $customer->alamat) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Username</label>
                    <input type="text" name="username" class="form-control bg-dark text-white border-secondary" value="{{ old('username', $customer->username) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Password Baru <span class="text-secondary">(Kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="form-control bg-dark text-white border-secondary" placeholder="Isi hanya jika ingin mengganti password">
                </div>
            </div>

            <div class="mt-4 pt-3 border-top border-secondary d-flex justify-content-end gap-2">
                <a href="{{ route('admin.customer.index') }}" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" class="btn btn-info text-dark fw-bold px-4">Simpan Perubahan</button>
            </div>
        </div>
    </form>

</div>
@endsection