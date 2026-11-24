@extends('layouts.app')

@section('title', 'Pembayaran Offline - Kasir')

@section('content')
<div class="space-y-6" x-data="paymentForm({{ $totalSemua }})">
    <h3 class="text-lg font-bold text-white tracking-wide">Transaksi Offline - Pembayaran</h3>

    <form action="{{ route('kasir.offline.pembayaran.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf

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

        <div class="p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/70 backdrop-blur-xl flex flex-col justify-between space-y-5">
            <div class="space-y-4">
                <h4 class="text-base font-bold text-white border-b border-gray-800 pb-3">Pembayaran</h4>
                
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Metode Pembayaran</label>
                    <select name="metode_pembayaran" x-model="metode" required class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-teal-500 focus:outline-none">
                        <option value="Cash">Tunai</option>
                        <option value="QRIS">QRIS</option>
                        <option value="Transfer">Transfer</option>
                    </select>
                </div>

                <template x-if="metode === 'Cash'">
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Uang Diterima</label>
                            
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-bold text-teal-400">Rp</span>
                                <input type="text"
                                       inputmode="numeric"
                                       :value="uangDiterima > 0 ? formatRupiah(uangDiterima) : ''"
                                       @input="updateUangDiterima($event.target.value)"
                                       placeholder="0"
                                       class="w-full bg-gray-950 border border-gray-800 rounded-xl pl-11 pr-4 py-2.5 text-sm text-white font-semibold focus:border-teal-500 focus:outline-none">
                            </div>

                            <input type="hidden" name="uang_diterima" :value="uangDiterima">

                            <div class="flex flex-wrap gap-1.5 pt-1">
                                <button type="button" @click="setUang(totalTagihan)"
                                        class="px-2.5 py-1 bg-teal-900/60 hover:bg-teal-700 text-teal-200 border border-teal-700/60 rounded-lg text-[11px] font-semibold transition">
                                    Uang Pas
                                </button>
                                <button type="button" @click="tambahUang(10000)"
                                        class="px-2.5 py-1 bg-gray-800 hover:bg-gray-700 text-gray-200 border border-gray-700 rounded-lg text-[11px] font-semibold transition">
                                    +10.000
                                </button>
                                <button type="button" @click="tambahUang(20000)"
                                        class="px-2.5 py-1 bg-gray-800 hover:bg-gray-700 text-gray-200 border border-gray-700 rounded-lg text-[11px] font-semibold transition">
                                    +20.000
                                </button>
                                <button type="button" @click="tambahUang(50000)"
                                        class="px-2.5 py-1 bg-gray-800 hover:bg-gray-700 text-gray-200 border border-gray-700 rounded-lg text-[11px] font-semibold transition">
                                    +50.000
                                </button>
                                <button type="button" @click="tambahUang(100000)"
                                        class="px-2.5 py-1 bg-gray-800 hover:bg-gray-700 text-gray-200 border border-gray-700 rounded-lg text-[11px] font-semibold transition">
                                    +100.000
                                </button>
                                <button type="button" @click="setUang(0)"
                                        class="px-2.5 py-1 bg-red-950/60 hover:bg-red-900/80 text-red-300 border border-red-800/60 rounded-lg text-[11px] font-semibold transition">
                                    Reset
                                </button>
                            </div>

                            <p x-show="uangDiterima > 0 && uangDiterima < totalTagihan" class="text-[11px] text-amber-400">
                                Kurang Rp <span x-text="formatRupiah(totalTagihan - uangDiterima)"></span>
                            </p>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Kembalian</label>
                            <input type="text" readonly :value="'Rp ' + formatRupiah(kembalian)" class="w-full bg-gray-950/60 border border-gray-800 rounded-xl px-4 py-2.5 text-sm text-emerald-400 font-bold focus:outline-none">
                        </div>
                        <input type="hidden" name="kembalian" :value="kembalian">
                    </div>
                </template>

                <template x-if="metode === 'QRIS'">
                    <div class="p-4 bg-gray-950/80 rounded-xl border border-gray-800 text-center space-y-3">
                        <p class="text-xs text-gray-400">Scan QR Code di bawah ini untuk membayar:</p>
                        <div class="flex justify-center">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=BANDENG-SAMUDERA-POS" alt="QRIS" class="w-32 h-32 bg-white p-2 rounded-lg">
                        </div>
                        <span class="text-[11px] text-teal-300 font-semibold block">Total: Rp {{ number_format($totalSemua, 0, ',', '.') }}</span>
                    </div>
                </template>

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
                <button type="submit" 
                        :disabled="metode === 'Cash' && uangDiterima < totalTagihan"
                        :class="(metode === 'Cash' && uangDiterima < totalTagihan) ? 'opacity-50 cursor-not-allowed bg-gray-700' : 'bg-emerald-600 hover:bg-emerald-500'"
                        class="w-full py-3 text-white text-xs font-bold rounded-xl shadow-lg transition uppercase tracking-wider">
                    Simpan Pembayaran
                </button>

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
        totalTagihan: Number(totalTagihan) || 0,
        metode: 'Cash',
        uangDiterima: 0,
        kembalian: 0,

        updateUangDiterima(rawValue) {
            const angkaBersih = parseInt(String(rawValue).replace(/\D/g, ''), 10) || 0;
            this.uangDiterima = angkaBersih;
            this.hitungKembalian();
        },

        setUang(nominal) {
            this.uangDiterima = nominal;
            this.hitungKembalian();
        },

        tambahUang(nominal) {
            this.uangDiterima = (Number(this.uangDiterima) || 0) + nominal;
            this.hitungKembalian();
        },

        hitungKembalian() {
            this.kembalian = this.uangDiterima >= this.totalTagihan ? this.uangDiterima - this.totalTagihan : 0;
        },

        formatRupiah(val) {
            return new Intl.NumberFormat('id-ID').format(val || 0);
        }
    }
}
</script>
@endpush
@endsection