@extends('layouts.app')

@section('title', 'Konfirmasi Pengiriman - Bandeng Samudra')

@section('content')
<div class="space-y-6">

    @if (session('success'))
        <div class="auto-hide-alert rounded-xl px-4 py-3 text-sm bg-emerald-500/20 border border-emerald-400/50 text-emerald-200">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Konfirmasi Pengiriman</h1>
            <p class="text-xs text-gray-400 mt-1">Perbarui status paket yang telah berhasil Anda kirim ke penerima.</p>
        </div>

        <form action="{{ route('karyawan.semuaSelesai') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-teal-600/80 hover:bg-teal-500 border border-teal-400/40 text-white text-xs font-semibold shadow transition flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-check-double"></i>
                <span>Konfirmasi Semua Paket</span>
            </button>
        </form>
    </div>

    <div class="card-glass rounded-2xl p-4">
        <div class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" id="filterSearch" value="{{ request('nomor') }}"
                       placeholder="Cari berdasarkan No. Pengiriman, Nama Penerima, atau Wilayah..."
                       class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-[#041929]/80 border border-teal-800/60 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-teal-400">
            </div>

            <select id="filterWilayah"
                    class="md:w-72 px-3.5 py-2.5 rounded-xl bg-[#041929]/80 border border-teal-800/60 text-xs text-gray-200 focus:outline-none focus:border-teal-400">
                <option value="">Semua Wilayah</option>
                @foreach (($daftarWilayah ?? \App\Models\Dikirim::daftarWilayah()) as $wilayahOpsi)
                    <option value="{{ strtolower($wilayahOpsi) }}" {{ strtolower(request('wilayah', '')) === strtolower($wilayahOpsi) ? 'selected' : '' }}>
                        {{ $wilayahOpsi }}
                    </option>
                @endforeach
            </select>
        </div>
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
                        <th class="py-3.5 px-4 font-semibold">Status Saat Ini</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Aksi Konfirmasi</th>
                    </tr>
                </thead>
                <tbody id="tabelKonfirmasiBody" class="text-xs divide-y divide-teal-900/20 text-gray-200">
                    @forelse ($pengiriman ?? [] as $index => $item)
                        @php
                            $statusRaw = $item->status_pengiriman ?? 'Diproses';
                            $isDikirim = in_array($statusRaw, ['Di Perjalanan', 'Sedang Dikirim', 'Dikirim']);
                            $pillClass = $isDikirim
                                ? 'bg-sky-500/20 text-sky-300 border-sky-400/40'
                                : 'bg-amber-500/20 text-amber-300 border-amber-400/40';
                            $statusLabel = $isDikirim ? 'Sedang Dikirim' : 'Baru Diproses';
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
                        @endphp
                        <tr class="row-paket hover:bg-white/5 transition"
                            data-search="{{ strtolower(($item->no_pengiriman ?? '') . ' ' . $penerima . ' ' . $wilayahTampil . ' ' . $alamat) }}"
                            data-wilayah="{{ strtolower(trim($wilayahTampil)) }}">
                            <td class="py-4 px-4">{{ $index + 1 }}</td>
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
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $pillClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <form action="{{ route('karyawan.prosesSelesai', $item->no_pengiriman) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs shadow transition inline-flex items-center gap-1.5 cursor-pointer">
                                        <i class="fa-solid fa-check"></i>
                                        <span>Selesai Dikirim</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr id="rowKosongServer">
                            <td colspan="7" class="text-center py-6 text-gray-400">Tidak ada paket yang menunggu konfirmasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 bg-teal-950/40 border-t border-teal-900/40 flex justify-between items-center text-xs text-gray-400">
            <div id="infoJumlahData">Menampilkan {{ count($pengiriman ?? []) }} data paket</div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    (function () {
        const searchInput = document.getElementById('filterSearch');
        const wilayahSelect = document.getElementById('filterWilayah');
        const tbody = document.getElementById('tabelKonfirmasiBody');
        const rows = Array.from(tbody.querySelectorAll('.row-paket'));
        const infoText = document.getElementById('infoJumlahData');

        const existingValues = new Set(Array.from(wilayahSelect.options).map(opt => opt.value));
        const extraWilayah = new Set();
        rows.forEach(function (row) {
            const w = (row.getAttribute('data-wilayah') || '').trim();
            if (w && w !== '-' && !existingValues.has(w)) {
                extraWilayah.add(w);
            }
        });
        Array.from(extraWilayah).sort().forEach(function (w) {
            const opt = document.createElement('option');
            opt.value = w;
            opt.textContent = w;
            wilayahSelect.appendChild(opt);
        });

        let emptyFilterRow = document.getElementById('rowKosongFilter');
        if (!emptyFilterRow) {
            emptyFilterRow = document.createElement('tr');
            emptyFilterRow.id = 'rowKosongFilter';
            emptyFilterRow.style.display = 'none';
            emptyFilterRow.innerHTML = '<td colspan="7" class="text-center py-6 text-gray-400">Tidak ada paket yang cocok dengan filter.</td>';
            tbody.appendChild(emptyFilterRow);
        }

        function terapkanFilter() {
            const keyword = (searchInput.value || '').toLowerCase().trim();
            const selectedWilayah = (wilayahSelect.value || '').toLowerCase().trim();
            let visibleCount = 0;

            rows.forEach(function (row) {
                const searchData = row.getAttribute('data-search') || '';
                const rowWilayah = row.getAttribute('data-wilayah') || '';

                const matchSearch = !keyword || searchData.includes(keyword);
                const matchWilayah = !selectedWilayah || rowWilayah === selectedWilayah;

                if (matchSearch && matchWilayah) {
                    row.style.display = '';
                    visibleCount++;
                    const noCell = row.querySelector('td:first-child');
                    if (noCell) {
                        noCell.textContent = visibleCount;
                    }
                } else {
                    row.style.display = 'none';
                }
            });

            if (rows.length > 0) {
                emptyFilterRow.style.display = visibleCount === 0 ? '' : 'none';
            }

            if (infoText) {
                infoText.textContent = 'Menampilkan ' + visibleCount + ' data paket';
            }
        }

        searchInput.addEventListener('input', terapkanFilter);
        wilayahSelect.addEventListener('change', terapkanFilter);
        terapkanFilter();
    })();
</script>
@endpush
@endsection