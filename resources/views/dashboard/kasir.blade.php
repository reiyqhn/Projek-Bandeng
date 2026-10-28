@extends('layouts.app')

@section('title', 'Beranda - Kasir')

@section('styles')
<style>
    html, body {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
    }
</style>
@endsection

@section('content')
<div class="space-y-6" style="max-width: 100%; overflow-x: hidden;">
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-5 rounded-2xl card-glass bg-gray-900/70 border border-teal-900/40">
            <p class="text-xs text-gray-400">Hari Ini</p>
            <h3 class="text-xl font-black text-amber-400 mt-1">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-gray-400 uppercase tracking-wider mt-1">Total Penjualan</p>
        </div>
        <div class="p-5 rounded-2xl card-glass bg-gray-900/70 border border-teal-900/40">
            <h3 class="text-xl font-black text-white mt-1">{{ $transaksiOnline }}</h3>
            <p class="text-[10px] text-gray-400 uppercase tracking-wider mt-1">Transaksi Online</p>
        </div>
        <div class="p-5 rounded-2xl card-glass bg-gray-900/70 border border-teal-900/40">
            <h3 class="text-xl font-black text-white mt-1">{{ $transaksiOffline }}</h3>
            <p class="text-[10px] text-gray-400 uppercase tracking-wider mt-1">Transaksi Offline</p>
        </div>
        <div class="p-5 rounded-2xl card-glass bg-gray-900/70 border border-teal-900/40">
            <h3 class="text-xl font-black text-white mt-1">{{ $totalTransaksi }}</h3>
            <p class="text-[10px] text-gray-400 uppercase tracking-wider mt-1">Total Transaksi</p>
        </div>
    </div>

    <div class="p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/70 backdrop-blur-xl">
        <h3 class="text-base font-bold text-white mb-4 tracking-wide">Transaksi Terbaru</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-300">
                <thead class="bg-gray-800/80 text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="py-3 px-4 rounded-l-lg">Waktu</th>
                        <th class="py-3 px-4">No Faktur</th>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Pembayaran</th>
                        <th class="py-3 px-4">Pemesanan</th>
                        <th class="py-3 px-4">Total</th>
                        <th class="py-3 px-4 rounded-r-lg">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($transaksiTerbaru as $item)
                    <tr class="hover:bg-gray-800/40 transition">
                        <td class="py-3 px-4 text-gray-400 text-xs">
                            {{ \Carbon\Carbon::parse($item->tanggal_penjualan)->format('d/m/Y H:i') }}
                        </td>
                        <td class="py-3 px-4 font-medium text-teal-300">
                            {{ $item->no_faktur }}
                        </td>
                        <td class="py-3 px-4 text-white font-medium">
                            {{ $item->customer->nama ?? '-' }}
                        </td>
                        <td class="py-3 px-4 text-gray-300">
                            {{ $item->metode_pembayaran }}
                        </td>
                        <td class="py-3 px-4 text-gray-300">
                            {{ $item->metode_pemesanan }}
                        </td>
                        <td class="py-3 px-4 font-semibold text-white">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4">
                            @if($item->status_pembayaran == 'Lunas')
                                <span class="px-3 py-0.5 text-xs font-bold text-green-400 bg-green-950/60 border border-green-800 rounded-full">
                                    Lunas
                                </span>
                            @else
                                <span class="px-3 py-0.5 text-xs font-bold text-amber-400 bg-amber-950/60 border border-amber-800 rounded-full">
                                    Menunggu
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-gray-400">Belum ada transaksi terbaru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection