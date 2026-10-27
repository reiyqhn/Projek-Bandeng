@extends('layouts.app')

@section('title', 'Verifikasi Pembayaran Online')

@section('content')
<div class="space-y-6">

    <!-- Card Atas: Daftar Pembayaran Masuk -->
    <div class="rounded-2xl p-6 shadow-2xl" style="background: rgba(8, 35, 54, 0.6); backdrop-filter: blur(10px); border: 1px solid rgba(20, 90, 120, 0.4);">
        <h3 class="text-base font-bold mb-4 text-white">Daftar Pembayaran Masuk</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-teal-950/60 text-teal-300 text-xs uppercase tracking-wider border-b border-teal-900/50">
                        <th class="py-3 px-4 rounded-l-lg font-semibold">No</th>
                        <th class="py-3 px-4 font-semibold">Customer</th>
                        <th class="py-3 px-4 font-semibold">No Faktur</th>
                        <th class="py-3 px-4 font-semibold">Total</th>
                        <th class="py-3 px-4 font-semibold">Status</th>
                        <th class="py-3 px-4 rounded-r-lg font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-teal-900/20 text-gray-200">
                    @forelse($pembayarans as $index => $item)
                    <tr class="hover:bg-white/5 transition {{ request('id') == $item->no_faktur ? 'bg-teal-900/30' : '' }}">
                        <td class="py-4 px-4">{{ $index + 1 }}</td>
                        <td class="py-4 px-4 font-medium">{{ $item->id_customer }}</td>
                        <td class="py-4 px-4 font-medium text-teal-300">{{ $item->no_faktur }}</td>
                        <td class="py-4 px-4">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-amber-500/80 text-amber-950 shadow-sm">
                                Menunggu Verifikasi
                            </span>
                        </td>
                        <td class="py-4 px-4 text-right">
                            <a href="{{ route('kasir.online.pembayaran', ['id' => $item->no_faktur]) }}" class="px-4 py-1.5 rounded-lg bg-teal-600 hover:bg-teal-500 text-white font-medium text-xs shadow transition">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-400">Tidak ada antrean pembayaran online yang perlu diverifikasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card Bawah: Detail Pesanan Customer -->
    @if(isset($selectedTransaction))
    <div class="rounded-2xl p-6 shadow-2xl relative" style="background: rgba(8, 35, 54, 0.6); backdrop-filter: blur(10px); border: 1px solid rgba(20, 90, 120, 0.4);">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-base font-bold text-white">Detail Pesanan Customer</h3>
            <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-amber-500/80 text-amber-950 shadow-sm">
                Menunggu Verifikasi
            </span>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <!-- Informasi Detail Pesanan -->
            <div class="col-span-2 grid grid-cols-2 gap-4">
                <div class="p-4 rounded-xl bg-teal-950/40 border border-teal-900/30">
                    <span class="text-[11px] text-gray-400 block mb-1">Nama Customer</span>
                    <span class="font-bold text-sm text-white">{{ $selectedTransaction->id_customer }}</span>
                </div>
                <div class="p-4 rounded-xl bg-teal-950/40 border border-teal-900/30">
                    <span class="text-[11px] text-gray-400 block mb-1">No Pesanan / Faktur</span>
                    <span class="font-bold text-sm text-white">{{ $selectedTransaction->no_faktur }}</span>
                </div>
                <div class="p-4 rounded-xl bg-teal-950/40 border border-teal-900/30">
                    <span class="text-[11px] text-gray-400 block mb-1">Produk</span>
                    <span class="font-bold text-sm text-white">Bandeng Samudera</span>
                </div>
                <div class="p-4 rounded-xl bg-teal-950/40 border border-teal-900/30">
                    <span class="text-[11px] text-gray-400 block mb-1">Total</span>
                    <span class="font-bold text-sm text-orange-400">Rp {{ number_format($selectedTransaction->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="p-4 rounded-xl bg-teal-950/40 border border-teal-900/30 col-span-2">
                    <span class="text-[11px] text-gray-400 block mb-1">Pembayaran</span>
                    <span class="font-bold text-sm text-white">{{ $selectedTransaction->metode_pembayaran }}</span>
                </div>

                <!-- Tombol Aksi Terima & Tolak -->
                <div class="col-span-2 flex gap-4 mt-2">
                    <form action="{{ route('kasir.online.terima', $selectedTransaction->no_faktur) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 font-bold text-sm shadow-lg transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-check"></i> Terima
                        </button>
                    </form>

                    <form action="{{ route('kasir.online.tolak', $selectedTransaction->no_faktur) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-3 rounded-xl bg-red-600 hover:bg-red-500 font-bold text-sm shadow-lg transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-xmark"></i> Tolak
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bagian Bukti Transfer -->
            <div class="p-5 rounded-2xl bg-teal-950/40 border border-teal-900/30 flex flex-col justify-between">
                <div>
                    <h4 class="font-bold text-sm mb-1 text-white">Bukti Transfer</h4>
                    <p class="text-xs text-gray-400 mb-4">Customer telah mengunggah bukti pembayaran</p>
                </div>
                
                <div class="text-center my-auto">
                    @if($selectedTransaction->bukti_pembayaran)
                        <a href="{{ route('kasir.online.bukti', $selectedTransaction->bukti_pembayaran) }}" target="_blank" class="block py-3 px-4 rounded-xl bg-teal-700 hover:bg-teal-600 text-xs font-semibold text-white transition shadow">
                            <i class="fa-solid fa-image mr-1"></i> Lihat Bukti Pembayaran
                        </a>
                    @else
                        <span class="text-xs text-amber-400 italic">Belum ada file bukti</span>
                    @endif
                </div>

                <div class="text-[10px] text-gray-400 text-center mt-4">
                    Verifikasi bukti transfer sebelum menerima pesanan.
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection