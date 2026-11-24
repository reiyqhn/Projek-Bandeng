@extends('layouts.app')

@section('title', 'Riwayat Pesanan - Kasir')

@section('content')
<div class="space-y-6">
    <h3 class="text-lg font-bold text-white tracking-wide">Riwayat Pesanan</h3>

    <div class="p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/70 backdrop-blur-xl space-y-5">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-800 pb-4">
            <h4 class="text-base font-bold text-white">Daftar Transaksi</h4>

            <form method="GET" action="{{ route('kasir.riwayat') }}" id="filterForm" class="flex flex-wrap items-center gap-3">
                @if(request('lihat'))
                    <input type="hidden" name="lihat" value="{{ request('lihat') }}">
                @endif

                <div class="relative">
                    <select name="jenis" onchange="document.getElementById('filterForm').submit()"
                        class="appearance-none bg-blue-950/90 hover:bg-blue-900 text-white text-xs font-semibold border border-teal-700/50 rounded-lg pl-3.5 pr-8 py-2 focus:outline-none focus:border-teal-400 cursor-pointer transition">
                        <option value="semua" {{ $jenisTransaksi === 'semua' ? 'selected' : '' }}>Semua Transaksi</option>
                        <option value="online" {{ $jenisTransaksi === 'online' ? 'selected' : '' }}>Transaksi Online</option>
                        <option value="offline" {{ $jenisTransaksi === 'offline' ? 'selected' : '' }}>Transaksi Offline</option>
                    </select>
                    <span class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center text-xs text-teal-300">▼</span>
                </div>

                <div class="relative">
                    <select name="metode" onchange="document.getElementById('filterForm').submit()"
                        class="appearance-none bg-blue-950/90 hover:bg-blue-900 text-white text-xs font-semibold border border-teal-700/50 rounded-lg pl-3.5 pr-8 py-2 focus:outline-none focus:border-teal-400 cursor-pointer transition">
                        <option value="semua" {{ $metodePembayaran === 'semua' ? 'selected' : '' }}>Semua Metode Pembayaran</option>
                        <option value="Tunai" {{ $metodePembayaran === 'Tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="QRIS" {{ $metodePembayaran === 'QRIS' ? 'selected' : '' }}>QRIS</option>
                        <option value="Transfer" {{ $metodePembayaran === 'Transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                    <span class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center text-xs text-teal-300">▼</span>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-200 border-collapse">
                <thead>
                    <tr class="bg-blue-950/90 text-white uppercase tracking-wider border-b border-teal-800/50">
                        <th class="py-3 px-3">No</th>
                        <th class="py-3 px-3">Waktu</th>
                        <th class="py-3 px-3">No Faktur</th>
                        <th class="py-3 px-3">Customer</th>
                        <th class="py-3 px-3">Pembayaran</th>
                        <th class="py-3 px-3">Pemesanan</th>
                        <th class="py-3 px-3">Total</th>
                        <th class="py-3 px-3 text-center">Status</th>
                        <th class="py-3 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/80">
                    @forelse($transaksis as $index => $trx)
                        @php
                            $isOnline = in_array($trx->metode_pemesanan, ['Delivery', 'Online']);
                            $labelPemesanan = $isOnline ? 'Online' : 'Offline';
                            $waktuFormat = $trx->tanggal_penjualan
                                ? \Carbon\Carbon::parse($trx->tanggal_penjualan)->format('H:i')
                                : '-';
                        @endphp
                        <tr class="hover:bg-teal-950/30 transition {{ request('lihat') === $trx->no_faktur ? 'bg-teal-900/30' : '' }}">
                            <td class="py-3 px-3">{{ $index + 1 }}</td>
                            <td class="py-3 px-3 font-mono">{{ $waktuFormat }}</td>
                            <td class="py-3 px-3 font-mono font-semibold text-teal-300">{{ $trx->no_faktur }}</td>
                            <td class="py-3 px-3">{{ $trx->customer->nama ?? ($trx->nama_customer ?? '-') }}</td>
                            <td class="py-3 px-3">{{ $trx->metode_pembayaran ?? '-' }}</td>
                            <td class="py-3 px-3">{{ $labelPemesanan }}</td>
                            <td class="py-3 px-3 font-semibold text-white">Rp {{ number_format($trx->subtotal, 0, ',', '.') }}</td>
                            <td class="py-3 px-3 text-center">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-600/80 text-white border border-emerald-400/40">
                                    {{ $trx->status_pembayaran }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <a href="{{ route('kasir.riwayat', ['jenis' => $jenisTransaksi, 'metode' => $metodePembayaran, 'lihat' => $trx->no_faktur]) }}#detail-transaksi"
                                   class="px-3.5 py-1.5 rounded-lg bg-slate-700/80 hover:bg-teal-600 text-white text-[11px] font-semibold border border-gray-600/60 transition inline-block">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-8 text-center text-gray-400">
                                Tidak ada transaksi lunas yang sesuai dengan filter saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($detailTransaksi)
        @php
            $detailIsOnline = in_array($detailTransaksi->metode_pemesanan, ['Delivery', 'Online']);
            $detailPemesanan = $detailIsOnline ? 'Online' : 'Offline';
        @endphp
        <div id="detail-transaksi" class="p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/75 backdrop-blur-xl space-y-5">
            <h4 class="text-base font-bold text-white border-b border-gray-800 pb-3">Detail Transaksi</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 rounded-xl bg-slate-800/70 border border-gray-700/60">
                    <div class="text-xs text-gray-400">No Faktur</div>
                    <div class="text-sm font-bold text-white mt-1 font-mono">{{ $detailTransaksi->no_faktur }}</div>
                </div>

                <div class="p-4 rounded-xl bg-slate-800/70 border border-gray-700/60">
                    <div class="text-xs text-gray-400">Tanggal</div>
                    <div class="text-sm font-bold text-white mt-1">
                        {{ $detailTransaksi->tanggal_penjualan ? \Carbon\Carbon::parse($detailTransaksi->tanggal_penjualan)->translatedFormat('d F Y') : '-' }}
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-slate-800/70 border border-gray-700/60">
                    <div class="text-xs text-gray-400">Customer</div>
                    <div class="text-sm font-bold text-white mt-1">{{ $detailTransaksi->customer->nama ?? ($detailTransaksi->nama_customer ?? '-') }}</div>
                </div>

                <div class="p-4 rounded-xl bg-slate-800/70 border border-gray-700/60">
                    <div class="text-xs text-gray-400">Metode Pembayaran</div>
                    <div class="text-sm font-bold text-white mt-1">{{ $detailTransaksi->metode_pembayaran ?? '-' }}</div>
                </div>

                <div class="p-4 rounded-xl bg-slate-800/70 border border-gray-700/60">
                    <div class="text-xs text-gray-400">Jenis Pemesanan</div>
                    <div class="text-sm font-bold text-white mt-1">{{ $detailPemesanan }}</div>
                </div>

                <div class="p-4 rounded-xl bg-slate-800/70 border border-gray-700/60">
                    <div class="text-xs text-gray-400">Status</div>
                    <div class="text-sm font-bold text-emerald-400 mt-1">{{ $detailTransaksi->status_pembayaran }}</div>
                </div>
            </div>

            @if($detailTransaksi->detailPenjualans && $detailTransaksi->detailPenjualans->count() > 0)
                <div class="overflow-x-auto rounded-xl border border-gray-800">
                    <table class="w-full text-left text-xs text-gray-200">
                        <thead class="bg-gray-950/90 text-gray-400 uppercase">
                            <tr>
                                <th class="py-2.5 px-3">Produk</th>
                                <th class="py-2.5 px-3 text-center">Jumlah</th>
                                <th class="py-2.5 px-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($detailTransaksi->detailPenjualans as $item)
                                <tr>
                                    <td class="py-2.5 px-3 text-white">{{ $item->produk->nama_bandeng ?? $item->id_bandeng }}</td>
                                    <td class="py-2.5 px-3 text-center">{{ $item->jumlah }}</td>
                                    <td class="py-2.5 px-3 text-right text-teal-300 font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
                <a href="{{ route('kasir.riwayat', ['jenis' => $jenisTransaksi, 'metode' => $metodePembayaran]) }}"
                   class="inline-block px-4 py-2 rounded-lg bg-rose-700/80 hover:bg-rose-600 text-white text-xs font-bold transition w-fit">
                    Tutup Detail
                </a>

                <div class="text-right">
                    <div class="text-xs text-gray-400">Total Pembayaran</div>
                    <div class="text-xl font-extrabold text-white">Rp {{ number_format($detailTransaksi->subtotal, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection