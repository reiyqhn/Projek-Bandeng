@extends('layouts.app')

@section('title', 'Beranda Kurir - Bandeng Samudra')

@section('content')
<div class="space-y-6">

    @if (session('success'))
        <div class="auto-hide-alert rounded-xl px-4 py-3 text-sm bg-emerald-500/20 border border-emerald-400/50 text-emerald-200">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card-glass rounded-2xl p-6 shadow-xl flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-teal-500/20 border border-teal-400/40 flex items-center justify-center text-teal-300 text-2xl shrink-0">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">Tugas Hari Ini</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-3xl font-bold text-white">{{ $totalTugas ?? 0 }}</span>
                    <span class="text-xs text-teal-300">Pengiriman</span>
                </div>
            </div>
        </div>

        <div class="card-glass rounded-2xl p-6 shadow-xl flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-amber-500/20 border border-amber-400/40 flex items-center justify-center text-amber-300 text-2xl shrink-0">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">Dalam Proses</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-3xl font-bold text-white">{{ $dalamProses ?? 0 }}</span>
                    <span class="text-xs text-amber-300">Pengiriman</span>
                </div>
            </div>
        </div>

        <div class="card-glass rounded-2xl p-6 shadow-xl flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 border border-emerald-400/40 flex items-center justify-center text-emerald-300 text-2xl shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">Selesai</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-3xl font-bold text-white">{{ $selesai ?? 0 }}</span>
                    <span class="text-xs text-emerald-300">Pengiriman</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 card-glass rounded-2xl p-6 shadow-xl">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-teal-900/40">
                <h2 class="text-base font-bold text-white">Pengiriman Hari Ini</h2>
                <a href="{{ route('karyawan.data') }}" class="text-xs font-semibold text-teal-300 hover:text-teal-200 transition">
                    Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="divide-y divide-teal-900/30">
                @forelse ($pengiriman as $item)
                    @php
                        $noKirim = $item->no_pengiriman ?? ($item['nomor'] ?? '');
                        $alamat  = $item->alamat_pengiriman ?? ($item['alamat'] ?? '-');
                        $status  = $item->status_pengiriman ?? ($item['status'] ?? 'Diproses');
                        $namaCus = $item->transaksi->customer->nama_customer
                            ?? $item->transaksi->customer->nama
                            ?? ($item['nama'] ?? '-');

                        $badgeClass = match ($status) {
                            'Terkirim', 'Selesai' => 'bg-emerald-500/20 text-emerald-300 border-emerald-400/40',
                            'Di Perjalanan', 'Dikirim' => 'bg-sky-500/20 text-sky-300 border-sky-400/40',
                            default => 'bg-amber-500/20 text-amber-300 border-amber-400/40',
                        };
                    @endphp

                    <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1 min-w-0">
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <span class="font-bold text-sm text-teal-300">#{{ $noKirim }}</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $badgeClass }}">
                                    {{ $status }}
                                </span>
                            </div>
                            <p class="text-sm font-semibold text-white">{{ $namaCus }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $alamat }}</p>
                        </div>

                        <div class="shrink-0">
                            @if (!in_array($status, ['Terkirim', 'Selesai']))
                                <form action="{{ route('karyawan.prosesSelesai', $noKirim) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-semibold shadow transition cursor-pointer">
                                        <i class="fa-solid fa-check mr-1"></i> Konfirmasi
                                    </button>
                                </form>
                            @else
                                <span class="px-3 py-1.5 rounded-xl bg-emerald-500/20 text-emerald-300 text-xs font-semibold">
                                    <i class="fa-solid fa-circle-check mr-1"></i> Terkirim
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-sm text-gray-400">
                        Belum ada data pengiriman hari ini.
                    </div>
                @endforelse
            </div>
        </div>

        <div>
            <div class="card-glass rounded-2xl p-6 shadow-xl">
                <h2 class="text-base font-bold text-white mb-1">Konfirmasi Cepat</h2>
                <p class="text-xs text-gray-400 mb-4">Cari nomor resi untuk konfirmasi pengiriman paket.</p>

                <form action="{{ route('karyawan.konfirmasi') }}" method="GET" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-300 mb-2">Masukkan No. Pengiriman</label>
                        <input type="text"
                               name="nomor"
                               placeholder="Contoh: KRM240524001"
                               required
                               class="w-full px-4 py-2.5 rounded-xl bg-[#041929]/80 border border-teal-800/60 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-teal-400">
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-400 hover:to-cyan-400 text-[#031c2b] font-bold text-sm shadow-lg transition cursor-pointer">
                        <i class="fa-solid fa-magnifying-glass mr-1"></i> Cari & Konfirmasi
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection