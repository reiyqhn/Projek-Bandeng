@extends('admin.layout')

@section('title', 'Tambah Customer - Bandeng Samudra')

@section('content')
<div class="container-fluid px-0">

    <div class="card p-4 rounded-4 border border-secondary mb-4" style="background: rgba(11, 25, 44, 0.88); border-color: rgba(13, 202, 240, 0.25) !important;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-info text-dark mb-2 px-3 py-1 fw-bold">Data Customer</span>
                <h4 class="fw-bold text-white mb-0">Tambah Customer Baru</h4>
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

    <form action="{{ route('admin.customer.store') }}" method="POST">
        @csrf
        <div class="card p-4 rounded-4 border border-secondary" style="background: rgba(11, 25, 44, 0.88);">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-secondary small">ID Customer</label>
                    <input type="text" name="id_customer" class="form-control bg-dark text-white border-secondary" value="{{ old('id_customer', $nextId ?? 'CUS005') }}" required>
                </div>

                <div class="col-md-8">
                    <label class="form-label text-secondary small">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: Sinta Maharani" value="{{ old('nama') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Email</label>
                    <input type="email" name="email" class="form-control bg-dark text-white border-secondary" placeholder="contoh@gmail.com" value="{{ old('email') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">No. Telp</label>
                    <input type="text" name="no_telp" class="form-control bg-dark text-white border-secondary" placeholder="081234567890" value="{{ old('no_telp') }}">
                </div>

                <div class="col-md-12">
                    <label class="form-label text-secondary small">Alamat</label>
                    <textarea name="alamat" rows="2" class="form-control bg-dark text-white border-secondary" placeholder="Alamat lengkap customer">{{ old('alamat') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Username</label>
                    <input type="text" name="username" class="form-control bg-dark text-white border-secondary" placeholder="username_customer" value="{{ old('username') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Password</label>
                    <input type="password" name="password" class="form-control bg-dark text-white border-secondary" placeholder="Minimal 4 karakter" required>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top border-secondary d-flex justify-content-end gap-2">
                <a href="{{ route('admin.customer.index') }}" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" class="btn btn-info text-dark fw-bold px-4">Simpan Customer</button>
            </div>
        </div>
    </form>

</div>
@endsection