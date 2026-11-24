@extends('layouts.app')

@section('title', 'Profil Admin - Bandeng Samudra')

@section('content')
<div style="max-width: 760px; width: 100%; margin: 0 auto;" class="pb-5">

    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="font-size: 2rem; letter-spacing: 0.5px; color: #ffffff;">
            Profil Admin
        </h1>
        <p class="text-white-50 mb-0" style="font-size: 0.9rem;">Kelola informasi akun dan keamanan password admin</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success auto-hide-alert" style="background: rgba(16, 185, 129, 0.2); border: 1px solid #34d399; color: #d1fae5; border-radius: 12px;">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger auto-hide-alert" style="background: rgba(239, 68, 68, 0.2); border: 1px solid #f87171; color: #fecaca; border-radius: 12px;">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="p-4 p-md-5 rounded-4 text-white"
         style="background: rgba(15, 43, 72, 0.72);
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
                border: 1.5px solid rgba(255, 255, 255, 0.16);
                box-shadow: 0 12px 32px rgba(0, 0, 0, 0.35);">

        <form action="{{ route('admin.profil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label small text-white-50 fw-semibold">ID Admin</label>
                    <input type="text" value="{{ $admin->id_admin }}" readonly disabled
                           class="form-control"
                           style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.14); color: rgba(255, 255, 255, 0.65); border-radius: 10px;">
                </div>

                <div class="col-md-6">
                    <label class="form-label small text-white-50 fw-semibold">Username</label>
                    <input type="text" name="username" value="{{ old('username', $admin->username) }}" required
                           class="form-control text-white"
                           style="background: rgba(10, 28, 48, 0.75); border: 1px solid rgba(255, 255, 255, 0.22); border-radius: 10px;">
                </div>

                <div class="col-12">
                    <label class="form-label small text-white-50 fw-semibold">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $admin->nama) }}" required
                           class="form-control text-white"
                           style="background: rgba(10, 28, 48, 0.75); border: 1px solid rgba(255, 255, 255, 0.22); border-radius: 10px;">
                </div>
            </div>

            <hr style="border-color: rgba(255, 255, 255, 0.14);" class="my-4">

            <p class="small text-white-50 mb-3">
                <i class="bi bi-shield-lock me-1 text-info"></i>
                <strong>Ubah Password</strong> (Kosongkan jika tidak ingin mengubah password)
            </p>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label small text-white-50 fw-semibold">Password Baru</label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter"
                           class="form-control text-white"
                           style="background: rgba(10, 28, 48, 0.75); border: 1px solid rgba(255, 255, 255, 0.22); border-radius: 10px;">
                </div>

                <div class="col-md-6">
                    <label class="form-label small text-white-50 fw-semibold">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                           class="form-control text-white"
                           style="background: rgba(10, 28, 48, 0.75); border: 1px solid rgba(255, 255, 255, 0.22); border-radius: 10px;">
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-2 gap-3 flex-wrap">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm text-white px-4 py-2"
                   style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.22); border-radius: 10px;">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>

                <button type="submit" class="btn btn-sm text-white fw-semibold px-4 py-2"
                        style="background: linear-gradient(90deg, #00b4d8 0%, #0077b6 100%); border-radius: 10px;">
                    <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection