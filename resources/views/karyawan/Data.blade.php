@extends('layouts.app')

@section('title', 'Data Pengiriman - Bandeng Samudra')

@section('content')
<div class="space-y-6">

    @if (session('success'))
        <div class="auto-hide-alert rounded-xl px-4 py-3 text-sm bg-emerald-500/20 border border-emerald-400/50 text-emerald-200">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="auto-hide-alert rounded-xl px-4 py-3 text-sm bg-red-500/20 border border-red-400/50 text-red-200">
            <i class="fa-solid fa-circle-exclamation mr-2"></i>{{ $errors->first() }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Data Pengiriman</h1>
            <p class="text-xs text-gray-400 mt-1">Kelola seluruh data manifes, wilayah pengiriman, dan status paket.</p>
        </div>

        <div class="flex gap-2.5 flex-wrap">
            <a href="{{ route('karyawan.data.export') . (request()->query() ? '?' . http_build_query(request()->query()) : '') }}"
               class="px-4 py-2.5 rounded-xl bg-teal-950/80 hover:bg-teal-900 border border-teal-500/40 text-white text-xs font-semibold transition inline-flex items-center gap-2">
                <i class="fa-solid fa-file-export text-teal-300"></i> Export CSV
            </a>
            <button type="button" onclick="toggleFormTambah()"
                    class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow transition inline-flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-plus"></i> Tambah Pengiriman
            </button>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card-glass rounded-2xl p-4">
            <span class="text-xs text-gray-400 block mb-1">Total Manifes</span>
            <strong class="text-2xl font-bold text-white">{{ $totalManifes ?? 0 }}</strong>
        </div>
        <div class="card-glass rounded-2xl p-4">
            <span class="text-xs text-gray-400 block mb-1">Diproses</span>
            <strong class="text-2xl font-bold text-amber-300">{{ $totalDiproses ?? 0 }}</strong>
        </div>
        <div class="card-glass rounded-2xl p-4">
            <span class="text-xs text-gray-400 block mb-1">Di Perjalanan</span>
            <strong class="text-2xl font-bold text-sky-300">{{ $totalDikirim ?? 0 }}</strong>
        </div>
        <div class="card-glass rounded-2xl p-4">
            <span class="text-xs text-gray-400 block mb-1">Terkirim</span>
            <strong class="text-2xl font-bold text-emerald-300">{{ $totalSelesai ?? 0 }}</strong>
        </div>
    </div>

    <div id="formTambahCard" class="card-glass rounded-2xl p-5 {{ $errors->any() ? '' : 'hidden' }}">
        <form action="{{ route('karyawan.data.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs text-gray-300 mb-1.5">No. Pengiriman</label>
                    <input type="text" name="no_pengiriman" value="{{ old('no_pengiriman') }}" placeholder="Contoh: M-008" required
                           class="w-full px-3.5 py-2 rounded-xl bg-[#041929]/90 border border-teal-800/60 text-xs text-white focus:outline-none focus:border-teal-400">
                </div>

                <div>
                    <label class="block text-xs text-gray-300 mb-1.5">Wilayah Pengiriman</label>
                    <select name="wilayah" class="w-full px-3.5 py-2 rounded-xl bg-[#041929]/90 border border-teal-800/60 text-xs text-white focus:outline-none focus:border-teal-400">
                        <option value="">Otomatis dari Alamat / Pilih Wilayah</option>
                        @foreach (($daftarWilayah ?? \App\Models\Dikirim::daftarWilayah()) as $wilayahOpsi)
                            <option value="{{ $wilayahOpsi }}" {{ old('wilayah') === $wilayahOpsi ? 'selected' : '' }}>
                                {{ $wilayahOpsi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs text-gray-300 mb-1.5">Alamat Pengiriman</label>
                    <input type="text" name="alamat_pengiriman" value="{{ old('alamat_pengiriman') }}" placeholder="Contoh: Jl. Pemuda No. 10, Parakan" required
                           class="w-full px-3.5 py-2 rounded-xl bg-[#041929]/90 border border-teal-800/60 text-xs text-white focus:outline-none focus:border-teal-400">
                </div>

                <div>
                    <label class="block text-xs text-gray-300 mb-1.5">Status Pengiriman</label>
                    <select name="status_pengiriman" required class="w-full px-3.5 py-2 rounded-xl bg-[#041929]/90 border border-teal-800/60 text-xs text-white focus:outline-none focus:border-teal-400">
                        <option value="Diproses" {{ old('status_pengiriman') === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Di Perjalanan" {{ old('status_pengiriman') === 'Di Perjalanan' ? 'selected' : '' }}>Di Perjalanan</option>
                        <option value="Terkirim" {{ old('status_pengiriman') === 'Terkirim' ? 'selected' : '' }}>Terkirim</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-semibold cursor-pointer">
                Simpan Data
            </button>
        </form>
    </div>

    <div class="card-glass rounded-2xl p-4">
        <form action="{{ route('karyawan.data') }}" method="GET" class="flex flex-wrap gap-3 items-center">
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

            <select name="status" class="px-3.5 py-2 rounded-xl bg-[#041929]/85 border border-teal-800/60 text-xs text-gray-200 focus:outline-none focus:border-teal-400">
                <option value="Semua Status">Semua Status</option>
                <option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Di Perjalanan" {{ request('status') === 'Di Perjalanan' ? 'selected' : '' }}>Di Perjalanan</option>
                <option value="Terkirim" {{ request('status') === 'Terkirim' ? 'selected' : '' }}>Terkirim</option>
            </select>

            @if (!empty($tanggalTersedia) && count($tanggalTersedia) > 0)
                <select name="tanggal" class="px-3.5 py-2 rounded-xl bg-[#041929]/85 border border-teal-800/60 text-xs text-gray-200 focus:outline-none focus:border-teal-400">
                    <option value="">Semua Tanggal</option>
                    @foreach ($tanggalTersedia as $tgl)
                        <option value="{{ $tgl }}" {{ request('tanggal') === $tgl ? 'selected' : '' }}>{{ $tgl }}</option>
                    @endforeach
                </select>
            @endif

            <button type="submit" class="px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-semibold cursor-pointer">Filter</button>
            <a href="{{ route('karyawan.data') }}" class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 text-gray-300 text-xs">Reset</a>
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
                    @forelse ($pengiriman ?? [] as $index => $item)
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

                            $noUrut = method_exists($pengiriman, 'firstItem')
                                ? ($pengiriman->firstItem() + $index)
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
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-sky-500/20 text-sky-300 border border-sky-400/35">
                                    {{ $item->status_pengiriman ?? '-' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-400">Belum ada data pengiriman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 bg-teal-950/40 border-t border-teal-900/40 flex justify-between items-center text-xs text-gray-400">
            <div>Menampilkan {{ method_exists($pengiriman, 'count') ? $pengiriman->count() : count($pengiriman ?? []) }} data</div>
            <div>
                @if (method_exists($pengiriman, 'links'))
                    {{ $pengiriman->links() }}
                @endif
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function toggleFormTambah() {
        const el = document.getElementById('formTambahCard');
        if (el) {
            el.classList.toggle('hidden');
        }
    }
</script>
@endpush
@endsection