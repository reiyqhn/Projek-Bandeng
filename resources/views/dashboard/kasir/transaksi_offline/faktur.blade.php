@extends('layouts.app')

@section('title', 'Faktur Transaksi Offline - Kasir')

@section('content')
<style>
    @media print {
        /* Sembunyikan seluruh elemen halaman web (sidebar, navbar, tabel kiri, tombol cetak) */
        body * {
            visibility: hidden !important;
        }

        /* Tampilkan hanya area struk/faktur */
        #area-struk, #area-struk * {
            visibility: visible !important;
        }

        #area-struk {
            position: fixed !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 24px !important;
            background: #ffffff !important;
            color: #000000 !important;
            border: none !important;
            box-shadow: none !important;
        }

        /* Pastikan teks terlihat jelas hitam di atas kertas putih */
        #area-struk h4,
        #area-struk p,
        #area-struk span,
        #area-struk strong,
        #area-struk th,
        #area-struk td {
            color: #000000 !important;
        }

        #area-struk .kotak-info,
        #area-struk thead {
            background: #f3f4f6 !important;
            border-color: #d1d5db !important;
        }

        /* Sembunyikan tombol Cetak Faktur saat diprint */
        .no-print {
            display: none !important;
        }
    }
</style>

<div class="space-y-6">
    <h3 class="text-lg font-bold text-white tracking-wide">Faktur Transaksi Offline</h3>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- KOLOM KIRI: DAFTAR TRANSAKSI OFFLINE -->
        <div class="lg:col-span-5 p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/70 backdrop-blur-xl space-y-4">
            <h4 class="text-base font-bold text-white border-b border-gray-800 pb-3">Daftar Transaksi Offline</h4>
            
            <div class="overflow-x-auto max-h-[500px] overflow-y-auto">
                <table class="w-full text-left text-xs text-gray-300">
                    <thead class="bg-gray-950/80 text-gray-400 uppercase tracking-wider sticky top-0">
                        <tr>
                            <th class="p-3">No Faktur</th>
                            <th class="p-3">Customer</th>
                            <th class="p-3">Total</th>
                            <th class="p-3 text-center">Status</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($fakturs as $trx)
                            <tr class="hover:bg-gray-800/50 transition">
                                <td class="p-3 font-mono text-teal-400 font-semibold">{{ $trx->no_faktur }}</td>
                                <td class="p-3 text-white">{{ $trx->customer->nama ?? '-' }}</td>
                                <td class="p-3 font-semibold">Rp {{ number_format($trx->subtotal, 0, ',', '.') }}</td>
                                <td class="p-3 text-center">
                                    <span class="px-2.5 py-1 bg-emerald-950 text-emerald-400 border border-emerald-800 rounded-full text-[10px] font-bold">
                                        {{ $trx->status_pembayaran ?? 'Lunas' }}
                                    </span>
                                </td>
                                <td class="p-3 text-center">
                                    <a href="{{ route('kasir.offline.faktur', ['no_faktur' => $trx->no_faktur]) }}" 
                                       class="px-3 py-1.5 bg-teal-600/80 hover:bg-teal-500 text-white rounded-xl text-[11px] font-bold transition inline-block shadow">
                                        Detail Faktur
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">Belum ada data transaksi offline.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- KOLOM KANAN: PREVIEW / CETAK FAKTUR PENJUALAN -->
        <div id="area-struk" class="lg:col-span-7 p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/70 backdrop-blur-xl flex flex-col justify-between space-y-6">
            @if($selectedFaktur)
                <div class="space-y-4">
                    <div class="text-center border-b border-gray-800 pb-4">
                        <h4 class="text-lg font-extrabold text-white tracking-wider">BANDENG SAMUDERA TEMANGGUNG</h4>
                        <span class="text-xs text-teal-400 font-medium">Faktur Penjualan Offline</span>
                    </div>

                    <div class="kotak-info bg-gray-950/80 p-4 rounded-xl border border-gray-800 space-y-1.5 text-xs text-gray-300">
                        <p><strong class="text-white">No Faktur :</strong> <span class="font-mono text-teal-300">{{ $selectedFaktur->no_faktur }}</span></p>
                        <p><strong class="text-white">Tanggal :</strong> {{ \Carbon\Carbon::parse($selectedFaktur->tanggal_penjualan)->translatedFormat('d F Y H:i') }}</p>
                        <p><strong class="text-white">Customer :</strong> {{ $selectedFaktur->customer->nama ?? '-' }}</p>
                        <p><strong class="text-white">Metode Bayar :</strong> {{ $selectedFaktur->metode_pembayaran === 'Cash' ? 'Tunai' : $selectedFaktur->metode_pembayaran }}</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-300">
                            <thead class="bg-gray-950/80 text-gray-400 uppercase tracking-wider">
                                <tr>
                                    <th class="p-3">Produk</th>
                                    <th class="p-3 text-center">Jumlah</th>
                                    <th class="p-3 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @foreach($selectedFaktur->detailPenjualans as $detail)
                                    <tr>
                                        <td class="p-3 text-white font-medium">{{ $detail->produk->nama_bandeng ?? $detail->id_bandeng }}</td>
                                        <td class="p-3 text-center">{{ $detail->jumlah }} Kg</td>
                                        <td class="p-3 text-right text-teal-300 font-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-800 flex justify-between items-center">
                    <div class="space-y-1 text-sm">
                        <div>
                            <span class="text-gray-400">Total Tagihan :</span>
                            <span class="text-base font-bold text-teal-400 ml-2">Rp {{ number_format($selectedFaktur->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if(($selectedFaktur->kembalian ?? 0) > 0)
                            <div class="text-xs">
                                <span class="text-gray-400">Kembalian :</span>
                                <span class="font-semibold text-emerald-400 ml-2">Rp {{ number_format($selectedFaktur->kembalian, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>

                    <button onclick="window.print()" class="no-print px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl shadow-lg transition flex items-center space-x-2">
                        <i class="fa-solid fa-print"></i>
                        <span>Cetak Faktur</span>
                    </button>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-16 text-center text-gray-500">
                    <i class="fa-solid fa-receipt text-4xl mb-3 text-gray-600"></i>
                    <p class="text-sm">Pilih salah satu transaksi di sebelah kiri untuk melihat detail faktur.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection