@extends('layouts.app')

@section('title', 'Penjualan Offline - Kasir')

@section('content')
<div class="space-y-6">
    <h3 class="text-lg font-bold text-white tracking-wide">Penjualan Offline (POS)</h3>

    @if(session('error'))
        <div class="p-4 bg-red-950/60 border border-red-800 text-red-300 rounded-xl text-sm">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="p-4 bg-teal-950/60 border border-teal-800 text-teal-300 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/70 backdrop-blur-xl space-y-5">
            <h4 class="text-base font-bold text-white border-b border-gray-800 pb-3">Input Data Pelanggan & Barang</h4>

            <form action="{{ route('kasir.offline.tambahItem') }}" method="POST" class="space-y-4">
                @csrf

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Kode Customer (Otomatis / Unik)</label>
                    <input type="text" name="id_customer" value="{{ $customerData['id_customer'] }}" readonly required
                           class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-xs text-teal-300 font-mono focus:outline-none">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Customer</label>
                    <input type="text" name="nama_customer" value="{{ $customerData['nama_customer'] }}" required
                           placeholder="Masukkan nama customer..."
                           class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-teal-500 focus:outline-none">
                </div>

                <div class="space-y-1 pt-1">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Nama / Kode Barang</label>
                    <select name="id_bandeng" required
                            class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-teal-500 focus:outline-none">
                        <option value="">-- Masukan nama atau kode barang --</option>
                        @foreach($bandengs as $b)
                            <option value="{{ $b->id_bandeng }}" {{ $b->stok <= 0 ? 'disabled' : '' }}>
                                ({{ $b->id_bandeng }}) {{ $b->nama_bandeng }} - Rp {{ number_format($b->harga, 0, ',', '.') }} (Stok: {{ $b->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Jumlah</label>
                    <input type="number" name="jumlah" value="1" min="1" required
                           class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-teal-500 focus:outline-none">
                </div>

                <div class="pt-2 flex items-center gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-xl shadow-lg transition">
                        + Tambahkan
                    </button>
            </form>

                    @if(count($keranjang) > 0)
                        <form action="{{ route('kasir.offline.batal') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="px-5 py-2.5 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl shadow-lg transition">
                                Batal
                            </button>
                        </form>
                    @endif
                </div>
        </div>

        <div class="p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/70 backdrop-blur-xl flex flex-col justify-between space-y-6">
            <div>
                <h4 class="text-base font-bold text-white border-b border-gray-800 pb-3 mb-4">Keranjang Belanja</h4>

                <div class="overflow-x-auto min-h-[180px]">
                    <table class="w-full text-left text-sm text-gray-300">
                        <thead class="bg-blue-950/60 text-gray-300 uppercase text-xs border-b border-gray-800">
                            <tr>
                                <th class="py-2.5 px-3 rounded-l-lg">Barang</th>
                                <th class="py-2.5 px-3 text-center">Jumlah</th>
                                <th class="py-2.5 px-3">Subtotal</th>
                                <th class="py-2.5 px-3 rounded-r-lg text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800/40">
                            @forelse($keranjang as $item)
                                <tr>
                                    <td class="py-3 px-3 text-white">{{ $item['nama'] }}</td>
                                    <td class="py-3 px-3 text-gray-300 text-center font-semibold">{{ $item['jumlah'] }}</td>
                                    <td class="py-3 px-3 text-teal-300 font-semibold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                    <td class="py-3 px-3 text-right">
                                        <div class="inline-flex items-center gap-1.5">
                                            <form action="{{ route('kasir.offline.updateQty') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="id_bandeng" value="{{ $item['id'] }}">
                                                <input type="hidden" name="aksi" value="minus">
                                                <button type="submit"
                                                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-gray-800 hover:bg-rose-600 text-white font-bold text-sm transition">
                                                    -
                                                </button>
                                            </form>

                                            <form action="{{ route('kasir.offline.updateQty') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="id_bandeng" value="{{ $item['id'] }}">
                                                <input type="hidden" name="aksi" value="plus">
                                                <button type="submit"
                                                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-gray-800 hover:bg-teal-600 text-white font-bold text-sm transition">
                                                    +
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500 text-xs italic">Keranjang masih kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <form action="{{ route('kasir.offline.store') }}" method="POST" class="space-y-4 pt-4 border-t border-gray-800">
                @csrf
                <input type="hidden" name="id_customer" value="{{ $customerData['id_customer'] }}">
                <input type="hidden" name="nama_customer" value="{{ $customerData['nama_customer'] }}">

                <div class="bg-blue-950/80 p-4 rounded-xl border border-blue-900/50 shadow-inner">
                    <span class="text-[10px] text-gray-400 uppercase tracking-wider block font-semibold">Total Pembayaran</span>
                    <div class="text-xl font-black text-teal-400">Rp {{ number_format($totalSemua, 0, ',', '.') }}</div>
                </div>

                <button type="submit" {{ count($keranjang) === 0 ? 'disabled' : '' }}
                        class="w-full py-3 bg-emerald-600 hover:bg-emerald-500 disabled:opacity-50 text-white text-xs font-bold rounded-xl shadow-lg transition uppercase tracking-wider">
                    Selesai Pilih Barang
                </button>
            </form>
        </div>
    </div>
</div>
@endsection