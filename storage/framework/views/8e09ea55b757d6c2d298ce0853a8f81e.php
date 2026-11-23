<?php $__env->startSection('title', 'Dashboard - Bandeng Samudra'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $urlLaporan = \Illuminate\Support\Facades\Route::has('admin.laporan.index')
        ? route('admin.laporan.index')
        : url('/admin/laporan');
?>

<div class="container-fluid px-0">

    <!-- 4 Kartu Statistik -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card p-4 rounded-4 border border-secondary h-100" style="background: rgba(11, 25, 44, 0.88);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-secondary small mb-2">Total Produk Bandeng</div>
                        <div class="text-info fw-bold fs-2"><?php echo e($totalProduk ?? 0); ?></div>
                    </div>
                    <div class="fs-2">🐟</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card p-4 rounded-4 border border-secondary h-100" style="background: rgba(11, 25, 44, 0.88);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-secondary small mb-2">Total Pesanan</div>
                        <div class="text-success fw-bold fs-2"><?php echo e($totalPesanan ?? 0); ?></div>
                    </div>
                    <div class="fs-2">🛒</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card p-4 rounded-4 border border-secondary h-100" style="background: rgba(11, 25, 44, 0.88);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-secondary small mb-2">Pendapatan Bulan Ini</div>
                        <div class="text-warning fw-bold fs-3">Rp <?php echo e(number_format($pendapatanBulanIni ?? 0, 0, ',', '.')); ?></div>
                    </div>
                    <div class="fs-2">💰</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card p-4 rounded-4 border border-secondary h-100" style="background: rgba(11, 25, 44, 0.88);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-secondary small mb-2">Total Customer</div>
                        <div class="text-primary fw-bold fs-2"><?php echo e($totalCustomer ?? 0); ?></div>
                    </div>
                    <div class="fs-2">👥</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi Penjualan Terbaru -->
    <div class="card p-4 rounded-4 border border-secondary" style="background: rgba(11, 25, 44, 0.88); border-color: rgba(13, 202, 240, 0.25) !important;">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h5 class="fw-bold text-white mb-0">
                <i class="fa-solid fa-clock-rotate-left text-info me-2"></i>Transaksi Penjualan Terbaru
            </h5>
            <a href="<?php echo e($urlLaporan); ?>" class="btn btn-outline-info btn-sm px-3">
                Lihat Semua Laporan
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="--bs-table-bg: transparent;">
                <thead>
                    <tr class="text-secondary border-bottom border-secondary">
                        <th style="width: 60px;">No</th>
                        <th>Tanggal</th>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Total Harga</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $transaksiTerbaru ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-bottom border-secondary border-opacity-25">
                            <td><?php echo e($index + 1); ?></td>
                            <td><?php echo e(!empty($trx->tanggal_penjualan) ? date('d-m-Y', strtotime($trx->tanggal_penjualan)) : '-'); ?></td>
                            <td class="text-info fw-semibold"><?php echo e($trx->no_faktur ?? '-'); ?></td>
                            <td class="text-white"><?php echo e($trx->nama_customer ?? '-'); ?></td>
                            <td class="text-light fw-semibold">Rp <?php echo e(number_format($trx->total_harga ?? 0, 0, ',', '.')); ?></td>
                            <td class="text-center">
                                <?php $status = $trx->status_pembayaran ?? '-'; ?>
                                <span class="badge <?php echo e($status == 'Lunas' ? 'bg-success' : ($status == 'Batal' ? 'bg-danger' : 'bg-warning text-dark')); ?> px-3 py-1">
                                    <?php echo e($status); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-4">
                                Belum ada data transaksi penjualan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Projek-Bandeng\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>