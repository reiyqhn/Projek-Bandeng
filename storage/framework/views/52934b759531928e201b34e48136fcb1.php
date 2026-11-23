<?php $__env->startSection('title', 'Laporan Penjualan - Bandeng Samudra'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0 laporan-page">

    <!-- FILTER & STATISTIK PANEL (Otomatis hilang saat dicetak/PDF) -->
    <div class="card p-4 mb-4 no-print" style="background: rgba(11, 25, 44, 0.85); border: 1px solid rgba(13, 202, 240, 0.2); border-radius: 16px;">
        
        <!-- Form Filter Tanggal -->
        <form method="GET" action="<?php echo e(route('admin.laporan.index')); ?>" class="row g-3 align-items-end mb-4">
            <div class="col-md-3">
                <label class="form-label text-white small fw-semibold">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" class="form-control bg-dark text-white border-secondary" value="<?php echo e($tanggalAwal); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label text-white small fw-semibold">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control bg-dark text-white border-secondary" value="<?php echo e($tanggalAkhir); ?>">
            </div>
            <div class="col-md-6 d-flex gap-2">
                <button type="submit" class="btn btn-info text-white fw-bold px-3 py-2" style="border-radius: 8px;">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                </button>
                <a href="<?php echo e(route('admin.laporan.index')); ?>" class="btn btn-secondary text-white px-3 py-2" style="border-radius: 8px;">
                    <i class="fa-solid fa-rotate-right me-1"></i> Reset
                </a>
            </div>
        </form>

        <!-- KOTAK STATISTIK / RINGKASAN -->
        <div class="row g-3">
            <div class="col-md-3">
                <div class="p-3 rounded border border-secondary d-flex align-items-center" style="background: rgba(4, 12, 20, 0.6);">
                    <div class="fs-3 text-info me-3">💰</div>
                    <div>
                        <div class="text-secondary small">Total Penjualan</div>
                        <div class="text-white fw-bold fs-5">Rp <?php echo e(number_format($totalPenjualan, 0, ',', '.')); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded border border-secondary d-flex align-items-center" style="background: rgba(4, 12, 20, 0.6);">
                    <div class="fs-3 text-success me-3">📊</div>
                    <div>
                        <div class="text-secondary small">Total Transaksi</div>
                        <div class="text-white fw-bold fs-5"><?php echo e($totalTransaksi); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded border border-secondary d-flex align-items-center" style="background: rgba(4, 12, 24, 0.6);">
                    <div class="fs-3 text-warning me-3">🐟</div>
                    <div>
                        <div class="text-secondary small">Bandeng Terjual</div>
                        <div class="text-white fw-bold fs-5"><?php echo e($bandengTerjual); ?> Ekor</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded border border-secondary d-flex align-items-center" style="background: rgba(4, 12, 20, 0.6);">
                    <div class="fs-3 text-primary me-3">👥</div>
                    <div>
                        <div class="text-secondary small">Total Customer</div>
                        <div class="text-white fw-bold fs-5"><?php echo e($totalCustomer); ?> Orang</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- KOP DOKUMEN ALA WORD (Hanya muncul saat print/PDF) -->
    <div class="print-only-header" style="display: none;">
        <div class="word-doc-title">Laporan Penjualan Bandeng Samudra</div>
        <div class="word-doc-meta">
            <?php if($tanggalAwal && $tanggalAkhir): ?>
                Periode Tanggal: <strong><?php echo e(date('d-m-Y', strtotime($tanggalAwal))); ?> s/d <?php echo e(date('d-m-Y', strtotime($tanggalAkhir))); ?></strong>
            <?php else: ?>
                Periode: <strong>Semua Data Transaksi</strong>
            <?php endif; ?>
            &bull; Dicetak: <?php echo e(date('d-m-Y H:i')); ?>

        </div>
    </div>

    <!-- TABEL LAPORAN PENJUALAN -->
    <div class="card p-4 laporan-card" style="background: rgba(11, 25, 44, 0.85); border: 1px solid rgba(13, 202, 240, 0.2); border-radius: 16px;">
        
        <div class="mb-3 no-print">
            <h5 class="fw-bold text-white mb-1">Daftar Laporan Penjualan Bandeng Samudra</h5>
            <?php if($tanggalAwal && $tanggalAkhir): ?>
                <p class="text-info small mb-0">Periode Tanggal: <?php echo e(date('d-m-Y', strtotime($tanggalAwal))); ?> s/d <?php echo e(date('d-m-Y', strtotime($tanggalAkhir))); ?></p>
            <?php else: ?>
                <p class="text-secondary small mb-0">Periode: Semua Data</p>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="laporanTable">
                <thead>
                    <tr>
                        <th class="col-no text-center">No</th>
                        <th class="col-tgl">Tanggal</th>
                        <th class="col-inv">Invoice</th>
                        <th class="col-cust">Customer</th>
                        <th class="col-jenis">Jenis Bandeng</th>
                        <th class="col-qty text-center">Qty</th>
                        <th class="col-harga text-end">Harga Satuan</th>
                        <th class="col-total text-end">Total</th>
                        <th class="col-status text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center"><?php echo e($key + 1); ?></td>
                            <td class="nowrap"><?php echo e(date('d-m-Y', strtotime($row->tanggal_penjualan))); ?></td>
                            <td class="break-word"><?php echo e($row->no_faktur); ?></td>
                            <td class="break-word"><?php echo e($row->nama_customer); ?></td>
                            <td class="break-word"><?php echo e($row->nama_bandeng); ?></td>
                            <td class="text-center"><?php echo e($row->qty); ?></td>
                            <td class="text-end nowrap">Rp <?php echo e(number_format($row->harga_item, 0, ',', '.')); ?></td>
                            <td class="text-info fw-bold text-end nowrap">Rp <?php echo e(number_format($row->total_harga, 0, ',', '.')); ?></td>
                            <td class="text-center nowrap">
                                <span class="badge <?php echo e($row->status_pembayaran == 'Lunas' ? 'bg-success' : ($row->status_pembayaran == 'Batal' ? 'bg-danger' : 'bg-warning text-dark')); ?> px-3 py-1">
                                    <?php echo e($row->status_pembayaran); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center text-secondary py-4">Tidak ada data transaksi pada rentang tanggal tersebut.</td>
                        </tr>
                    <?php endif; ?>
                    
                    <!-- Baris Total Keseluruhan -->
                    <?php if($laporan->count() > 0): ?>
                        <tr class="fw-bold bg-dark text-white border-top border-secondary total-row-print">
                            <td colspan="5" class="text-end">Total Keseluruhan :</td>
                            <td class="text-center"><?php echo e($bandengTerjual); ?></td>
                            <td class="text-end">-</td>
                            <td class="text-info text-end nowrap">Rp <?php echo e(number_format($totalPenjualan, 0, ',', '.')); ?></td>
                            <td class="text-center">-</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- 3 TOMBOL AKSI TERPISAH (Export PDF, Export Excel, Cetak Laporan) -->
        <div class="d-flex justify-content-end gap-2 mt-4 no-print">
            <button type="button" onclick="exportPdf()" class="btn btn-danger text-white fw-bold px-3 py-2" style="border-radius: 8px; font-size: 0.9rem;">
                <i class="fa-solid fa-file-pdf me-1"></i> Export PDF
            </button>
            <button type="button" onclick="exportExcel()" class="btn btn-success text-white fw-bold px-3 py-2" style="border-radius: 8px; font-size: 0.9rem;">
                <i class="fa-solid fa-file-excel me-1"></i> Export Excel
            </button>
            <button type="button" onclick="cetakLaporan()" class="btn btn-primary text-white fw-bold px-3 py-2" style="border-radius: 8px; font-size: 0.9rem;">
                <i class="fa-solid fa-print me-1"></i> Cetak Laporan
            </button>
        </div>

    </div>

</div>

<!-- JAVASCRIPT UNTUK MASING-MASING AKSI -->
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
    let periode = "<?php echo e(($tanggalAwal && $tanggalAkhir) ? date('d-m-Y', strtotime($tanggalAwal)) . '_sd_' . date('d-m-Y', strtotime($tanggalAkhir)) : 'Semua_Data'); ?>";
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
    let periodeText = "<?php echo e(($tanggalAwal && $tanggalAkhir) ? 'Periode: ' . date('d-m-Y', strtotime($tanggalAwal)) . ' s/d ' . date('d-m-Y', strtotime($tanggalAkhir)) : 'Periode: Semua Data'); ?>";
    let namaFile = "Laporan-Penjualan-<?php echo e(($tanggalAwal && $tanggalAkhir) ? date('d-m-Y', strtotime($tanggalAwal)) . '-sd-' . date('d-m-Y', strtotime($tanggalAkhir)) : 'Semua'); ?>.xls";

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

<!-- CSS KHUSUS PRINT & PDF (GAYA DOKUMEN WORD A4 RAPI) -->
<style>
@media print {
    @page {
        size: A4 portrait;
        margin: 15mm;
    }

    html, body {
        background: #ffffff !important;
        color: #111111 !important;
        font-family: "Calibri", "Arial", sans-serif !important;
        font-size: 9.5pt !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }

    .no-print,
    aside,
    nav,
    header,
    footer,
    .sidebar,
    .sidenav,
    .left-sidebar,
    .topbar,
    .navbar {
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
    .table-responsive {
        background: #ffffff !important;
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
    #laporanTable .col-tgl    { width: 11%; }
    #laporanTable .col-inv    { width: 17%; }
    #laporanTable .col-cust   { width: 15%; }
    #laporanTable .col-jenis  { width: 14%; }
    #laporanTable .col-qty    { width: 5%; }
    #laporanTable .col-harga  { width: 12%; }
    #laporanTable .col-total  { width: 12%; }
    #laporanTable .col-status { width: 10%; }

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

    .text-info {
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Projek-Bandeng\resources\views/admin/laporan/index.blade.php ENDPATH**/ ?>