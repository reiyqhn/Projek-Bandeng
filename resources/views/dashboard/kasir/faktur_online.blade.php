@extends('layouts.app')

@section('title', 'Faktur Penjualan - Kasir')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="auto-hide-alert rounded-xl px-4 py-3 text-sm bg-emerald-500/20 border border-emerald-400/50 text-emerald-200 no-print">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/70 backdrop-blur-xl no-print">
        <h3 class="text-base font-bold text-white mb-4 tracking-wide">Daftar Pembayaran Masuk</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-300">
                <thead class="bg-gray-800/80 text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="py-3 px-4 rounded-l-lg">No</th>
                        <th class="py-3 px-4">Customer</th>
                        <th class="py-3 px-4">No Faktur</th>
                        <th class="py-3 px-4">Total</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 rounded-r-lg text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($fakturs as $index => $item)
                    <tr class="hover:bg-gray-800/40 transition {{ (isset($selectedFaktur) && $selectedFaktur->no_faktur == $item->no_faktur) ? 'bg-teal-900/30' : '' }}">
                        <td class="py-3 px-4 text-gray-400">{{ $index + 1 }}</td>
                        
                        <td class="py-3 px-4 font-medium text-white">
                            {{ $item->customer->nama ?? '-' }}
                        </td>

                        <td class="py-3 px-4 font-medium text-teal-300">{{ $item->no_faktur }}</td>

                        <td class="py-3 px-4 font-semibold text-white">Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}</td>
                        
                        <td class="py-3 px-4">
                            <span class="px-3 py-0.5 text-xs font-bold text-green-400 bg-green-950/60 border border-green-800 rounded-full">
                                Lunas
                            </span>
                        </td>

                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('kasir.transaksi-online.faktur', ['no_faktur' => $item->no_faktur]) }}#area-faktur" class="px-4 py-1 text-xs font-bold text-white bg-teal-600/80 hover:bg-teal-600 border border-teal-500/50 rounded-lg shadow-md transition inline-block">
                                Buat Faktur
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-400">Semua faktur pembayaran masuk sudah dikirim.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($selectedFaktur))
    <div id="area-faktur" class="scroll-mt-6 p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/80 backdrop-blur-xl relative">
        
        <div class="flex justify-between items-start border-b border-gray-800 pb-5 mb-5">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-ikan.png') }}" alt="Logo" class="w-12 h-12 object-contain drop-shadow-[0_0_8px_rgba(20,184,166,0.5)]">
                <div>
                    <h2 class="text-xl font-black tracking-wider text-white">Bandeng Samudera</h2>
                    <p class="text-xs text-gray-400">Temanggung</p>
                </div>
            </div>
            <div class="text-right">
                <h4 class="text-lg font-black tracking-widest text-white uppercase">FAKTUR PENJUALAN</h4>
                <p class="text-xs text-gray-300 mt-1">No : <span class="font-bold text-teal-300">{{ $selectedFaktur->no_faktur }}</span></p>
                <p class="text-xs text-gray-300">Tanggal : {{ \Carbon\Carbon::parse($selectedFaktur->tanggal_penjualan ?? now())->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="bg-gray-950/50 border border-gray-800/80 rounded-xl p-4 mb-5 space-y-1.5 text-sm">
            <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Data Customer</h5>
            
            <p class="text-gray-200">
                <span class="text-gray-400">Nama :</span> 
                <strong class="text-white">{{ $selectedFaktur->customer->nama ?? '-' }}</strong>
            </p>
            <p class="text-gray-200">
                <span class="text-gray-400">Metode Pesanan :</span> 
                <strong class="text-white">{{ $selectedFaktur->metode_pemesanan ?? 'Delivery' }}</strong>
            </p>
            <p class="text-gray-200">
                <span class="text-gray-400">Pembayaran :</span> 
                <strong class="text-white">{{ $selectedFaktur->metode_pembayaran ?? '-' }}</strong>
            </p>
        </div>

        <div class="mb-6">
            <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Detail Pesanan</h5>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-300">
                    <thead class="bg-gray-800/60 text-gray-400 uppercase text-xs">
                        <tr>
                            <th class="py-2.5 px-4 rounded-l-lg w-16">No</th>
                            <th class="py-2.5 px-4">Produk</th>
                            <th class="py-2.5 px-4">Jumlah</th>
                            <th class="py-2.5 px-4">Harga</th>
                            <th class="py-2.5 px-4 rounded-r-lg">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/40">
                        @forelse($selectedDetails ?? [] as $idx => $det)
                        <tr class="hover:bg-gray-800/20">
                            <td class="py-3 px-4 text-gray-400">{{ $idx + 1 }}</td>
                            <td class="py-3 px-4 font-medium text-white">{{ $det->nama_bandeng }}</td>
                            <td class="py-3 px-4">{{ $det->jumlah }} Porsi / Kg</td>
                            <td class="py-3 px-4">Rp {{ number_format($det->harga_item, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 font-semibold text-white">Rp {{ number_format($det->jumlah * $det->harga_item, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr class="hover:bg-gray-800/20">
                            <td class="py-3 px-4 text-gray-400">1</td>
                            <td class="py-3 px-4 font-medium text-white">Produk Bandeng</td>
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Rp {{ number_format($selectedFaktur->subtotal, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 font-semibold text-white">Rp {{ number_format($selectedFaktur->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforelse
                        @if(($selectedFaktur->ongkir ?? 0) > 0)
                        <tr class="hover:bg-gray-800/20">
                            <td class="py-3 px-4 text-gray-400">-</td>
                            <td class="py-3 px-4 font-medium text-teal-300" colspan="3">Ongkos Kirim</td>
                            <td class="py-3 px-4 font-semibold text-white">Rp {{ number_format($selectedFaktur->ongkir, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center pt-2 gap-4">
            <div class="w-full sm:w-auto"></div>
            
            <div class="flex items-center gap-4 w-full sm:w-auto justify-end">
                <div class="bg-gray-950/70 border border-teal-900/50 px-6 py-2.5 rounded-xl text-right">
                    <span class="block text-[10px] uppercase tracking-wider text-gray-400 font-medium">Total Pembayaran</span>
                    <span class="text-lg font-black text-amber-400">Rp {{ number_format($selectedFaktur->subtotal, 0, ',', '.') }}</span>
                </div>

                <div class="no-print flex gap-2">
                    <button onclick="window.print()" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold rounded-xl border border-gray-700 transition flex items-center gap-2 shadow cursor-pointer">
                        <i class="fa-solid fa-print"></i> Cetak
                    </button>
                    
                    <form action="{{ route('kasir.online.kirimFaktur', $selectedFaktur->no_faktur) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-bold rounded-xl border border-emerald-600 transition flex items-center gap-2 shadow cursor-pointer">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Faktur
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    @endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pathParts = window.location.pathname.split('/').filter(Boolean);
    const hasFakturParam = pathParts.length > 3 || window.location.hash === '#area-faktur';
    if (hasFakturParam) {
        const areaFaktur = document.getElementById('area-faktur');
        if (areaFaktur) {
            areaFaktur.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
});
</script>
@endpush

<style>
@media print {

    body * {
        visibility: hidden;
    }
    
    #area-faktur, #area-faktur * {
        visibility: visible;
    }
    
    #area-faktur {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        margin: 0;
        padding: 20px;
        box-shadow: none !important;
        border: none !important;
        background: white !important;
        color: black !important;
    }

    #area-faktur h2, 
    #area-faktur h4, 
    #area-faktur h5, 
    #area-faktur strong, 
    #area-faktur span, 
    #area-faktur td, 
    #area-faktur th {
        color: #111827 !important;
    }

    #area-faktur .text-teal-300 {
        color: #0d9488 !important;
    }

    #area-faktur .text-amber-400 {
        color: #d97706 !important;
    }

    .no-print {
        display: none !important;
    }
}
</style>
@endsection