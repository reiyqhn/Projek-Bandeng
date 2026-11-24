@extends('layouts.app')

@section('title', 'Profil Kasir - Bandeng Samudra')

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-amber-400">Profil Kasir</h2>
        <p class="text-sm text-gray-400 mt-1">Perbarui informasi pribadi dan akun kasir Anda</p>
    </div>

    @if(session('success'))
        <div class="auto-hide-alert p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-sm flex items-center gap-3 shadow-lg">
            <i class="fa-solid fa-circle-check text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="auto-hide-alert p-4 rounded-2xl bg-red-500/20 border border-red-500/40 text-red-300 text-sm shadow-lg">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="p-6 md:p-8 rounded-2xl card-glass bg-gray-900/75 border border-teal-900/40 shadow-2xl">
        <form action="{{ route('kasir.profil.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">ID Kasir (Otomatis)</label>
                    <div class="flex items-center rounded-xl bg-white/5 border border-white/10 overflow-hidden">
                        <span class="px-3.5 py-2.5 text-teal-400 bg-white/5">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input type="text"
                               value="{{ $kasir->id_kasir }}"
                               readonly
                               disabled
                               class="w-full px-3.5 py-2.5 bg-transparent text-gray-400 text-sm font-semibold cursor-not-allowed focus:outline-none">
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1.5">ID dibuat otomatis oleh sistem dan tidak dapat diubah.</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Username</label>
                    <input type="text"
                           name="username"
                           value="{{ old('username', $kasir->username) }}"
                           required
                           class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/15 text-white text-sm focus:outline-none focus:border-teal-400">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Nama Lengkap</label>
                    <input type="text"
                           name="nama"
                           value="{{ old('nama', $kasir->nama) }}"
                           required
                           class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/15 text-white text-sm focus:outline-none focus:border-teal-400">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Email</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email', $kasir->email) }}"
                           placeholder="contoh@gmail.com"
                           class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/15 text-white text-sm placeholder-gray-400 focus:outline-none focus:border-teal-400">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">No. Telepon / WhatsApp</label>
                    <input type="text"
                           name="no_telp"
                           value="{{ old('no_telp', $kasir->no_telp) }}"
                           placeholder="Contoh: 081234567890"
                           class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/15 text-white text-sm placeholder-gray-400 focus:outline-none focus:border-teal-400">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Alamat Lengkap</label>
                    <input type="text"
                           name="alamat"
                           value="{{ old('alamat', $kasir->alamat) }}"
                           placeholder="Masukkan alamat lengkap"
                           class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/15 text-white text-sm placeholder-gray-400 focus:outline-none focus:border-teal-400">
                </div>
            </div>

            <div class="pt-4 border-t border-white/10">
                <p class="text-xs text-gray-300 flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-teal-400"></i>
                    <span><strong class="text-white">Ubah Password</strong> <span class="text-gray-400">(Kosongkan jika tidak ingin mengganti password)</span></span>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Password Baru</label>
                    <input type="password"
                           name="password"
                           placeholder="Minimal 6 karakter"
                           class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/15 text-white text-sm placeholder-gray-400 focus:outline-none focus:border-teal-400">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Konfirmasi Password Baru</label>
                    <input type="password"
                           name="password_confirmation"
                           placeholder="Ulangi password baru"
                           class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/15 text-white text-sm placeholder-gray-400 focus:outline-none focus:border-teal-400">
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4 pt-6 border-t border-white/10">
                <a href="{{ route('kasir.dashboard') }}" class="px-5 py-2.5 rounded-full border border-white/25 text-white text-xs font-semibold hover:bg-white/10 transition flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                </a>

                <button type="submit" class="px-6 py-2.5 rounded-full bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-400 hover:to-cyan-500 text-white text-xs font-bold shadow-lg shadow-teal-900/40 transition flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection