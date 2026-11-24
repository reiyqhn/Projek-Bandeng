@extends('layouts.app')

@section('title', 'Riwayat Pengiriman - Bandeng Samudra')

@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-white">Riwayat Pengiriman</h1>
        <p class="text-xs text-gray-400 mt-1">Daftar paket yang telah selesai dikirim berdasarkan nomor, wilayah, dan alamat.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="card-glass rounded-2xl p-4">
            <span class="text-xs text-gray-400 block mb-1">Total Selesai</span>
            <strong class="text-2xl font-bold text-emerald-300">{{ $totalSelesai ?? 0 }}</strong>
        </div>
        <div class="card-glass rounded-2xl p-4">
            <span class="text-xs text-gray-400 block mb-1">Penyelesaian Bulan Ini</span>
            <strong class="text-2xl font-bold text-teal-300">{{ $penyelesaianBulanIni ?? 0 }}</strong>
        </div>
    </div>

    <div class="card-glass rounded-2xl p-4">
        <form action="{{ route('karyawan.riwayat') }}" method="GET" class="flex flex-wrap gap-3 items-center">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Pengiriman, Wilayah, atau Alamat..."
                   class="flex-1 min-w-[200px] px-3.5 py-2 rounded-xl bg-[#041929]/85 border border-teal-800/60 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-teal-400">

            <select name="wilayah" class="px-3.5 py-2 rounded-xl bg-[#041929]/85 border border-teal-800/60 text-xs text-gray-200 focus:outline-none focus:border-teal-400">
                <option value="">Semua Wilayah</option>
                @foreach (($daftarWilayah ?? \App\Models\Dikirim::daftarWilayah()) as $wilayahOpsi)
                    <option value="{{ $wilayahOpsi }}" {{ request('wilayah') === $wilayahOpsi ? 'selected' : '' }}>
                        {{ $wilayahOpsi }}
                    </option>
                @endforeach
            </select>

            <input type="month" name="bulan" value="{{ request('bulan', $bulanDipilih ?? '') }}"
                   class="px-3.5 py-2 rounded-xl bg-[#041929]/85 border border-teal-800/60 text-xs text-gray-200 focus:outline-none focus:border-teal-400">

            <button type="submit" class="px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-semibold cursor-pointer">Filter</button>
            <a href="{{ route('karyawan.riwayat') }}" class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 text-gray-300 text-xs">Reset</a>
        </form>
    </div>

    <div class="card-glass rounded-2xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-teal-950/60 text-teal-300 text-xs uppercase tracking-wider border-b border-teal-900/50">
                        <th class="py-3.5 px-4 font-semibold">No</th>
                        <th class="py-3.5 px-4 font-semibold">No. Pengiriman</th>
                        <th class="py-3.5 px-4 font-semibold">Penerima</th>
                        <th class="py-3.5 px-4 font-semibold">Wilayah</th>
                        <th class="py-3.5 px-4 font-semibold">Alamat</th>
                        <th class="py-3.5 px-4 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="text-xs divide-y divide-teal-900/20 text-gray-200">
                    @forelse ($riwayat ?? [] as $index => $item)
                        @php
                            $penerima = $item->transaksi->customer->nama_customer
                                ?? $item->transaksi->customer->nama
                                ?? '-';
                            $alamat = $item->alamat_pengiriman ?? '-';

                            if (!empty($item->wilayah)) {
                                $wilayahTampil = trim($item->wilayah);
                            } elseif ($alamat !== '' && $alamat !== '-') {
                                $teksAlamat = strtolower($alamat);
                                $mapWilayah = [
                                    'Temanggung / Parakan / Bulu (Rp 7.000)'            => ['temanggung', 'parakan', 'bulu'],
                                    'Kedu / Kranggan / Tlogomulyo (Rp 10.000)'           => ['kedu', 'kranggan', 'tlogomulyo'],
                                    'Ngadirejo / Selopampang / Pringsurat (Rp 15.000)' => ['ngadirejo', 'selopampang', 'pringsurat'],
                                    'Candiroto / Kaloran / Jumo (Rp 18.000)'           => ['candiroto', 'kaloran', 'jumo'],
                                    'Tretep / Bejen / Gemawang / Wonoboyo (Rp 25.000)' => ['tretep', 'bejen', 'gemawang', 'wonoboyo'],
                                ];
                                $wilayahTampil = 'Luar Kab. Temanggung via J&T (Rp 20.000)';
                                foreach ($mapWilayah as $label => $keywords) {
                                    foreach ($keywords as $kw) {
                                        if (str_contains($teksAlamat, $kw)) {
                                            $wilayahTampil = $label;
                                            break 2;
                                        }
                                    }
                                }
                            } else {
                                $wilayahTampil = '-';
                            }

                            $noUrut = method_exists($riwayat, 'firstItem')
                                ? ($riwayat->firstItem() + $index)
                                : ($index + 1);
                        @endphp
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-4 px-4">{{ $noUrut }}</td>
                            <td class="py-4 px-4 font-bold text-teal-300">#{{ $item->no_pengiriman }}</td>
                            <td class="py-4 px-4 font-medium">{{ $penerima }}</td>
                            <td class="py-4 px-4">
                                @if ($wilayahTampil !== '-')
                                    <span class="px-2.5 py-1 rounded-lg text-[11px] font-medium bg-teal-500/15 text-teal-300 border border-teal-400/30">
                                        {{ $wilayahTampil }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">{{ $alamat }}</td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/40">
                                    {{ $item->status_pengiriman ?? 'Terkirim' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-400">Belum ada riwayat pengiriman selesai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 bg-teal-950/40 border-t border-teal-900/40 flex justify-between items-center text-xs text-gray-400">
            <div>Menampilkan {{ method_exists($riwayat, 'count') ? $riwayat->count() : count($riwayat ?? []) }} data</div>
            <div>
                @if (method_exists($riwayat, 'links'))
                    {{ $riwayat->links() }}
                @endif
            </div>
        </div>
    </div>

</div>
@endsection