@extends('admin.layout')

@section('title', 'Laporan Penjualan - Bandeng Samudra')

@section('content')
<div class="container-fluid px-0 laporan-page">

    <div class="p-4 mb-4 no-print card-glass-admin">
        
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3 align-items-end mb-4">
            <div class="col-md-3">
                <label class="form-label text-white small fw-semibold">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.7);" value="{{ $tanggalAwal }}">
            </div>
            <div class="col-md-3">
                <label class="form-label text-white small fw-semibold">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.7);" value="{{ $tanggalAkhir }}">
            </div>
            <div class="col-md-2">
                <label class="form-label text-white small fw-semibold">Status</label>
                <select name="status" class="form-select text-white border-secondary" style="background: rgba(3, 19, 31, 0.7);">
                    <option value="">Semua Status</option>
                    <option value="Lunas" {{ ($statusFilter ?? '') === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="Belum Lunas" {{ ($statusFilter ?? '') === 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="Batal" {{ ($statusFilter ?? '') === 'Batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn text-white fw-bold px-3 py-2" style="background: linear-gradient(90deg, #0d9488 0%, #115e59 100%); border-radius: 10px;">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary text-white px-3 py-2" style="border-radius: 10px;">
                    <i class="fa-solid fa-rotate-right me-1"></i> Reset
                </a>
            </div>
        </form>

        <div class="row g-3">
            <div class="col-md-3">
                <div class="p-3 rounded-4 d-flex align-items-center h-100" style="background: rgba(3, 19, 31, 0.55); border: 1px solid rgba(20, 184, 166, 0.25);">
                    <div class="rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px; background: rgba(245, 158, 11, 0.15); color: #fbbf24;">
                        <i class="fa-solid fa-sack-dollar fs-5"></i>
                    </div>
                    <div>
                        <div class="text-secondary small">Total Penjualan (Lunas)</div>
                        <div class="text-warning fw-bold fs-5">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded-4 d-flex align-items-center h-100" style="background: rgba(3, 19, 31, 0.55); border: 1px solid rgba(20, 184, 166, 0.25);">
                    <div class="rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px; background: rgba(16, 185, 129, 0.15); color: #34d399;">
                        <i class="fa-solid fa-chart-simple fs-5"></i>
                    </div>
                    <div>
                        <div class="text-secondary small">Transaksi Lunas</div>
                        <div class="text-white fw-bold fs-5">{{ $totalTransaksi }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded-4 d-flex align-items-center h-100" style="background: rgba(3, 19, 31, 0.55); border: 1px solid rgba(20, 184, 166, 0.25);">
                    <div class="rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px; background: rgba(20, 184, 166, 0.15); color: #2dd4bf;">
                        <i class="fa-solid fa-fish fs-5"></i>
                    </div>
                    <div>
                        <div class="text-secondary small">Bandeng Terjual</div>
                        <div class="text-info fw-bold fs-5">{{ $bandengTerjual }} Ekor</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded-4 d-flex align-items-center h-100" style="background: rgba(3, 19, 31, 0.55); border: 1px solid rgba(20, 184, 166, 0.25);">
                    <div class="rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px; background: rgba(56, 189, 248, 0.15); color: #38bdf8;">
                        <i class="fa-solid fa-users fs-5"></i>
                    </div>
                    <div>
                        <div class="text-secondary small">Customer Belanja</div>
                        <div class="text-white fw-bold fs-5">{{ $totalCustomer }} Orang</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="print-only-header" style="display: none;">
        <div class="word-doc-title">Laporan Penjualan Bandeng Samudra</div>
        <div class="word-doc-meta">
            @if($tanggalAwal && $tanggalAkhir)
                Periode Tanggal: <strong>{{ date('d-m-Y', strtotime($tanggalAwal)) }} s/d {{ date('d-m-Y', strtotime($tanggalAkhir)) }}</strong>
            @else
                Periode: <strong>Semua Data Transaksi</strong>
            @endif
            &bull; Dicetak: {{ date('d-m-Y H:i') }}
        </div>
    </div>

    <div class="p-4 laporan-card card-glass-admin">
        
        <div class="mb-3 no-print">
            <h5 class="fw-bold text-white mb-1">Daftar Laporan Penjualan Bandeng Samudra</h5>
            @if($tanggalAwal && $tanggalAkhir)
                <p class="text-info small mb-0">Periode Tanggal: {{ date('d-m-Y', strtotime($tanggalAwal)) }} s/d {{ date('d-m-Y', strtotime($tanggalAkhir)) }}</p>
            @else
                <p class="text-secondary small mb-0">Periode: Semua Data</p>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="laporanTable" style="--bs-table-bg: transparent;">
                <thead>
                    <tr class="text-secondary text-uppercase" style="font-size: 0.72rem; background: rgba(15, 23, 42, 0.75);">
                        <th class="col-no text-center py-3 border-0 rounded-start">No</th>
                        <th class="col-tgl py-3 border-0">Tanggal</th>
                        <th class="col-inv py-3 border-0">Invoice</th>
                        <th class="col-cust py-3 border-0">Customer</th>
                        <th class="col-jenis py-3 border-0">Jenis Bandeng</th>
                        <th class="col-qty text-center py-3 border-0">Qty</th>
                        <th class="col-harga text-end py-3 border-0">Harga Satuan</th>
                        <th class="col-total text-end py-3 border-0">Total</th>
                        <th class="col-status text-center py-3 border-0">Status</th>
                        <th class="col-kirim text-center py-3 border-0 rounded-end">Pengiriman</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporan as $key => $row)
                        @php
                            $statusKirim = $row->status_pengiriman ?? '-';
                            if (($row->metode_pemesanan ?? '') !== 'Delivery' && $statusKirim === '-') {
                                $statusKirim = 'Ambil di Toko';
                            }
                        @endphp
                        <tr style="border-bottom: 1px solid rgba(30, 41, 59, 0.65);">
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="nowrap text-secondary small">{{ date('d-m-Y', strtotime($row->tanggal_penjualan)) }}</td>
                            <td class="break-word fw-semibold" style="color: #5eead4;">{{ $row->no_faktur }}</td>
                            <td class="break-word text-white">{{ $row->nama_customer }}</td>
                            <td class="break-word text-light">{{ $row->nama_bandeng }}</td>
                            <td class="text-center">{{ $row->qty }}</td>
                            <td class="text-end nowrap">Rp {{ number_format($row->harga_item, 0, ',', '.') }}</td>
                            <td class="text-info fw-bold text-end nowrap">Rp {{ number_format($row->total_harga, 0, ',', '.') }}</td>
                            <td class="text-center nowrap">
                                @if($row->status_pembayaran == 'Lunas')
                                    <span class="badge rounded-pill px-3 py-1" style="background: rgba(6, 78, 59, 0.65); color: #4ade80; border: 1px solid #166534;">
                                        Lunas
                                    </span>
                                @elseif($row->status_pembayaran == 'Batal')
                                    <span class="badge rounded-pill px-3 py-1" style="background: rgba(127, 29, 29, 0.65); color: #f87171; border: 1px solid #991b1b;">
                                        Batal
                                    </span>
                                @else
                                    <span class="badge rounded-pill px-3 py-1" style="background: rgba(120, 53, 15, 0.65); color: #fbbf24; border: 1px solid #92400e;">
                                        {{ $row->status_pembayaran }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center nowrap">
                                @if(in_array($statusKirim, ['Terkirim', 'Selesai']))
                                    <span class="badge rounded-pill px-2.5 py-1" style="background: rgba(6, 78, 59, 0.65); color: #4ade80; border: 1px solid #166534;">
                                        {{ $statusKirim }}
                                    </span>
                                @elseif(in_array($statusKirim, ['Diproses', 'Di Perjalanan']))
                                    <span class="badge rounded-pill px-2.5 py-1" style="background: rgba(14, 116, 144, 0.45); color: #7dd3fc; border: 1px solid #0369a1;">
                                        {{ $statusKirim }}
                                    </span>
                                @else
                                    <span class="text-secondary small">{{ $statusKirim }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-secondary py-4">Tidak ada data transaksi pada rentang tanggal tersebut.</td>
                        </tr>
                    @endforelse
                    
                    @if($laporan->count() > 0)
                        <tr class="fw-bold text-white border-top border-secondary total-row-print" style="background: rgba(15, 23, 42, 0.75);">
                            <td colspan="5" class="text-end">Total Penjualan Lunas :</td>
                            <td class="text-center">{{ $bandengTerjual }}</td>
                            <td class="text-end">-</td>
                            <td class="text-warning text-end nowrap">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4 no-print">
            <button type="button" onclick="exportPdf()" class="btn btn-danger text-white fw-bold px-3 py-2" style="border-radius: 10px; font-size: 0.9rem;">
                <i class="fa-solid fa-file-pdf me-1"></i> Export PDF
            </button>
            <button type="button" onclick="exportExcel()" class="btn btn-success text-white fw-bold px-3 py-2" style="border-radius: 10px; font-size: 0.9rem;">
                <i class="fa-solid fa-file-excel me-1"></i> Export Excel
            </button>
            <button type="button" onclick="cetakLaporan()" class="btn btn-primary text-white fw-bold px-3 py-2" style="border-radius: 10px; font-size: 0.9rem;">
                <i class="fa-solid fa-print me-1"></i> Cetak Laporan
            </button>
        </div>

    </div>

</div>

<script>
function toggleOutsideElements(hide) {
    const reportEl = document.querySelector('.laporan-page');
    if (!reportEl) return;

    let current = reportEl;
    while (current && current !== document.body) {
        let sibling = current.parentElement ? current.parentElement.firstElementChild : null;
        while (sibling) {
            if (sibling !== current && sibling.tagName !== 'SCRIPT' && sibling.tagName !== 'STYLE') {
                if (hide) {
                    sibling.setAttribute('data-prev-display', sibling.style.display || '');
                    sibling.style.setProperty('display', 'none', 'important');
                } else {
                    const prev = sibling.getAttribute('data-prev-display');
                    if (prev !== null) {
                        sibling.style.display = prev;
                        sibling.removeAttribute('data-prev-display');
                    }
                }
            }
            sibling = sibling.nextElementSibling;
        }
        current = current.parentElement;
    }
}

function exportPdf() {
    let judulAsli = document.title;
    let periode = "{{ ($tanggalAwal && $tanggalAkhir) ? date('d-m-Y', strtotime($tanggalAwal)) . '_sd_' . date('d-m-Y', strtotime($tanggalAkhir)) : 'Semua_Data' }}";
    document.title = "Laporan_Penjualan_Bandeng_Samudra_" + periode;
    toggleOutsideElements(true);
    window.print();
    toggleOutsideElements(false);
    document.title = judulAsli;
}

function cetakLaporan() {
    toggleOutsideElements(true);
    window.print();
    toggleOutsideElements(false);
}

window.addEventListener('afterprint', function () {
    toggleOutsideElements(false);
});

function exportExcel() {
    let table = document.getElementById("laporanTable").outerHTML;
    let periodeText = "{{ ($tanggalAwal && $tanggalAkhir) ? 'Periode: ' . date('d-m-Y', strtotime($tanggalAwal)) . ' s/d ' . date('d-m-Y', strtotime($tanggalAkhir)) : 'Periode: Semua Data' }}";
    let namaFile = "Laporan-Penjualan-{{ ($tanggalAwal && $tanggalAkhir) ? date('d-m-Y', strtotime($tanggalAwal)) . '-sd-' . date('d-m-Y', strtotime($tanggalAkhir)) : 'Semua' }}.xls";

    let templateExcel = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
        <head><meta charset="UTF-8"></head>
        <body>
            <h3>LAPORAN PENJUALAN BANDENG SAMUDRA</h3>
            <p>${periodeText}</p>
            <br>
            ${table}
        </body>
        </html>
    `;

    let url = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(templateExcel);
    let downloadLink = document.createElement("a");
    downloadLink.href = url;
    downloadLink.download = namaFile;
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>

<style>
@media print {
    @page {
        size: A4 portrait;
        margin: 15mm;
    }

    html, body, .admin-shell, .admin-main {
        background: #ffffff !important;
        background-image: none !important;
        color: #111111 !important;
        font-family: "Calibri", "Arial", sans-serif !important;
        font-size: 9.5pt !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        height: auto !important;
        overflow: visible !important;
        display: block !important;
    }

    .admin-shell::before {
        display: none !important;
    }

    .no-print,
    aside,
    nav,
    header,
    footer,
    .sidebar,
    .role-pill {
        display: none !important;
    }

    .laporan-page {
        position: static !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
        background: #ffffff !important;
    }

    .print-only-header {
        display: block !important;
        margin-bottom: 10px !important;
        padding-bottom: 6px !important;
        border-bottom: 1.5px solid #111111 !important;
    }

    .word-doc-title {
        font-size: 13.5pt !important;
        font-weight: 700 !important;
        color: #111111 !important;
        text-transform: uppercase !important;
        margin: 0 0 2px 0 !important;
    }

    .word-doc-meta {
        font-size: 9pt !important;
        color: #444444 !important;
        margin: 0 !important;
    }

    .laporan-card,
    .card-glass-admin,
    .table-responsive {
        background: #ffffff !important;
        backdrop-filter: none !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
        overflow: visible !important;
        width: 100% !important;
    }

    #laporanTable {
        width: 100% !important;
        table-layout: fixed !important;
        border-collapse: collapse !important;
        background: #ffffff !important;
        color: #111111 !important;
        font-family: "Calibri", "Arial", sans-serif !important;
        font-size: 8.5pt !important;
    }

    #laporanTable .col-no     { width: 4%; }
    #laporanTable .col-tgl    { width: 10%; }
    #laporanTable .col-inv    { width: 15%; }
    #laporanTable .col-cust   { width: 14%; }
    #laporanTable .col-jenis  { width: 13%; }
    #laporanTable .col-qty    { width: 5%; }
    #laporanTable .col-harga  { width: 11%; }
    #laporanTable .col-total  { width: 11%; }
    #laporanTable .col-status { width: 8%; }
    #laporanTable .col-kirim  { width: 9%; }

    #laporanTable th {
        background-color: #f2f2f2 !important;
        color: #111111 !important;
        font-weight: 700 !important;
        border: 1px solid #666666 !important;
        padding: 5px 4px !important;
        line-height: 1.2 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    #laporanTable td {
        background-color: #ffffff !important;
        color: #111111 !important;
        border: 1px solid #666666 !important;
        padding: 5px 4px !important;
        line-height: 1.25 !important;
        vertical-align: middle !important;
    }

    #laporanTable td.nowrap,
    #laporanTable th.nowrap {
        white-space: nowrap !important;
    }

    #laporanTable td.break-word {
        word-break: break-word !important;
        overflow-wrap: anywhere !important;
    }

    .text-info, .text-warning {
        color: #111111 !important;
    }

    .total-row-print td {
        background-color: #f2f2f2 !important;
        color: #111111 !important;
        font-weight: 700 !important;
        border-top: 1.5px solid #111111 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .badge {
        background: transparent !important;
        color: #111111 !important;
        border: none !important;
        padding: 0 !important;
        font-weight: 600 !important;
        white-space: nowrap !important;
    }
}
</style>
@endsection