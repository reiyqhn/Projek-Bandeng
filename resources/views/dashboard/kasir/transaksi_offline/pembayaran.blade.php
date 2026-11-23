@extends('layouts.app')

@section('title', 'Pembayaran Offline - Kasir')

@section('content')
<div class="space-y-6" x-data="paymentForm({{ $totalSemua }})">
    <h3 class="text-lg font-bold text-white tracking-wide">Transaksi Offline - Pembayaran</h3>

    <form action="{{ route('kasir.offline.pembayaran.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf

        <!-- KOTAK KIRI: RINGKASAN PESANAN -->
        <div class="p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/70 backdrop-blur-xl flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <h4 class="text-base font-bold text-white border-b border-gray-800 pb-3">Ringkasan Pesanan</h4>
                
                <div class="p-4 bg-gray-950/80 rounded-xl border border-gray-800 space-y-2 text-sm text-gray-300">
                    <p><strong class="text-white">Customer:</strong> {{ $transaksiData['nama_customer'] }} <span class="text-xs text-teal-400 font-mono">({{ $transaksiData['id_customer'] }})</span></p>
                    <div class="border-t border-gray-800 pt-2 mt-2">
                        <strong class="text-white block mb-1">Daftar Produk:</strong>
                        <ul class="space-y-1 text-xs">
                            @foreach($itemsDetail as $item)
                                <li class="flex justify-between">
                                    <span>{{ $item['nama'] }} (x{{ $item['jumlah'] }})</span>
                                    <span class="text-teal-300 font-semibold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="border-t border-gray-800 pt-2 mt-2 flex justify-between font-bold text-white text-base">
                        <span>Total :</span>
                        <span class="text-teal-400">Rp {{ number_format($totalSemua, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <a href="{{ route('kasir.offline.index') }}" class="inline-block px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-bold rounded-xl transition">
                    &larr; Kembali / Ubah Pesanan
                </a>
            </div>
        </div>

        <!-- KOTAK KANAN: PEMBAYARAN -->
        <div class="p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/70 backdrop-blur-xl flex flex-col justify-between space-y-5">
            <div class="space-y-4">
                <h4 class="text-base font-bold text-white border-b border-gray-800 pb-3">Pembayaran</h4>
                
                <!-- Metode Pembayaran -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Metode Pembayaran</label>
                    <select name="metode_pembayaran" x-model="metode" required class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-teal-500 focus:outline-none">
                        <option value="Tunai">Tunai</option>
                        <option value="QRIS">QRIS</option>
                        <option value="Transfer">Transfer</option>
                    </select>
                </div>

                <!-- JIKA TUNAI / CASH -->
                <template x-if="metode === 'Tunai'">
                    <div class="space-y-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Uang Diterima</label>
                            <input type="number" name="uang_diterima" x-model.number="uangDiterima" @input="hitungKembalian" placeholder="Masukkan jumlah uang" class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-teal-500 focus:outline-none">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Kembalian</label>
                            <input type="text" readonly :value="'Rp ' + formatRupiah(kembalian)" class="w-full bg-gray-950/60 border border-gray-800 rounded-xl px-4 py-2.5 text-sm text-emerald-400 font-bold focus:outline-none">
                        </div>
                        <input type="hidden" name="kembalian" :value="kembalian">
                    </div>
                </template>

                <!-- JIKA QRIS -->
                <template x-if="metode === 'QRIS'">
                    <div class="p-4 bg-gray-950/80 rounded-xl border border-gray-800 text-center space-y-3">
                        <p class="text-xs text-gray-400">Scan QR Code di bawah ini untuk membayar:</p>
                        <div class="flex justify-center">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=BANDENG-SAMUDERA-POS" alt="QRIS" class="w-32 h-32 bg-white p-2 rounded-lg">
                        </div>
                        <span class="text-[11px] text-teal-300 font-semibold block">Total: Rp {{ number_format($totalSemua, 0, ',', '.') }}</span>
                    </div>
                </template>

                <!-- JIKA TRANSFER -->
                <template x-if="metode === 'Transfer'">
                    <div class="p-4 bg-gray-950/80 rounded-xl border border-gray-800 space-y-3 text-xs">
                        <p class="text-gray-400">Silakan transfer melalui rekening berikut:</p>
                        <div class="p-3 bg-gray-900 rounded-xl border border-gray-800 font-mono text-teal-300 text-center space-y-1">
                            <strong>BCA : 1234-5678-9010</strong> <br>
                            <span class="text-[10px] text-gray-400">a.n Bandeng Samudera</span>
                        </div>
                    </div>
                </template>
            </div>

            <div class="space-y-3 pt-4 border-t border-gray-800">
                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl shadow-lg transition uppercase tracking-wider">
                    Simpan Pembayaran
                </button>

                <!-- Status Pembayaran Berhasil -->
                <div class="p-3 bg-emerald-950/60 border border-emerald-800 text-emerald-300 rounded-xl text-xs flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check text-emerald-400 text-sm"></i>
                    <div>
                        <strong class="block">Pembayaran Berhasil</strong>
                        <span class="text-[10px] text-emerald-400">Status : Lunas / Berhasil</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function paymentForm(totalTagihan) {
    return {
        metode: 'Tunai',
        uangDiterima: 0,
        kembalian: 0,

        hitungKembalian() {
            this.kembalian = this.uangDiterima >= totalTagihan ? this.uangDiterima - totalTagihan : 0;
        },

        formatRupiah(val) {
            return new Intl.NumberFormat('id-ID').format(val);
        }
    }
}
</script>
@endpush
@endsection