<?php $__env->startSection('title', 'Beranda - Admin'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $urlLaporan = \Illuminate\Support\Facades\Route::has('admin.laporan.index')
        ? route('admin.laporan.index')
        : url('/admin/laporan');
?>

<div class="container-fluid px-0">

    <!-- 4 Kartu Statistik -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-4 rounded-4 card-glass-admin h-100 d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-secondary small mb-1">Bulan Ini (Lunas)</div>
                    <div class="fw-black fs-4 text-warning" style="font-weight: 800;">
                        Rp <?php echo e(number_format($pendapatanBulanIni ?? 0, 0, ',', '.')); ?>

                    </div>
                    <div class="text-secondary text-uppercase mt-1" style="font-size: 0.7rem; letter-spacing: 0.8px;">
                        Pendapatan Bulan Ini
                    </div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: rgba(245, 158, 11, 0.15); color: #fbbf24;">
                    <i class="fa-solid fa-sack-dollar fs-5"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-4 rounded-4 card-glass-admin h-100 d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-secondary small mb-1">Aktif / Sukses</div>
                    <div class="fw-black fs-3 text-white" style="font-weight: 800;">
                        <?php echo e($totalPesanan ?? 0); ?>

                    </div>
                    <div class="text-secondary text-uppercase mt-1" style="font-size: 0.7rem; letter-spacing: 0.8px;">
                        Total Pesanan
                    </div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: rgba(16, 185, 129, 0.15); color: #34d399;">
                    <i class="fa-solid fa-cart-shopping fs-5"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-4 rounded-4 card-glass-admin h-100 d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-secondary small mb-1">Katalog Tersedia</div>
                    <div class="fw-black fs-3 text-info" style="font-weight: 800;">
                        <?php echo e($totalProduk ?? 0); ?>

                    </div>
                    <div class="text-secondary text-uppercase mt-1" style="font-size: 0.7rem; letter-spacing: 0.8px;">
                        Total Produk Bandeng
                    </div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: rgba(20, 184, 166, 0.15); color: #2dd4bf;">
                    <i class="fa-solid fa-fish fs-5"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-4 rounded-4 card-glass-admin h-100 d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-secondary small mb-1">Akun Terdaftar</div>
                    <div class="fw-black fs-3 text-white" style="font-weight: 800;">
                        <?php echo e($totalCustomer ?? 0); ?>

                    </div>
                    <div class="text-secondary text-uppercase mt-1" style="font-size: 0.7rem; letter-spacing: 0.8px;">
                        Total Customer
                    </div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: rgba(56, 189, 248, 0.15); color: #38bdf8;">
                    <i class="fa-solid fa-users fs-5"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi Penjualan Terbaru -->
    <div class="p-4 rounded-4 card-glass-admin">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h5 class="fw-bold text-white mb-0" style="font-size: 1rem; letter-spacing: 0.3px;">
                Transaksi Terbaru
            </h5>
            <a href="<?php echo e($urlLaporan); ?>" class="btn btn-sm px-3 text-info fw-semibold" style="background: rgba(20, 184, 166, 0.14); border: 1px solid rgba(20, 184, 166, 0.35); border-radius: 10px;">
                Lihat Semua Laporan
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="--bs-table-bg: transparent;">
                <thead>
                    <tr class="text-secondary text-uppercase" style="font-size: 0.72rem; background: rgba(15, 23, 42, 0.75);">
                        <th class="py-3 px-3 border-0 rounded-start">Waktu</th>
                        <th class="py-3 px-3 border-0">No Faktur</th>
                        <th class="py-3 px-3 border-0">Nama</th>
                        <th class="py-3 px-3 border-0">Pembayaran</th>
                        <th class="py-3 px-3 border-0">Pemesanan</th>
                        <th class="py-3 px-3 border-0">Total</th>
                        <th class="py-3 px-3 border-0 rounded-end">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $transaksiTerbaru ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr style="border-bottom: 1px solid rgba(30, 41, 59, 0.65);">
                            <td class="py-3 px-3 text-secondary small">
                                <?php echo e(!empty($trx->tanggal_penjualan) ? \Carbon\Carbon::parse($trx->tanggal_penjualan)->format('d/m/Y H:i') : '-'); ?>

                            </td>
                            <td class="py-3 px-3 fw-semibold" style="color: #5eead4;">
                                <?php echo e($trx->no_faktur ?? '-'); ?>

                            </td>
                            <td class="py-3 px-3 text-white fw-medium">
                                <?php echo e($trx->nama_customer ?? '-'); ?>

                            </td>
                            <td class="py-3 px-3 text-light small">
                                <?php echo e($trx->metode_pembayaran ?? '-'); ?>

                            </td>
                            <td class="py-3 px-3 text-light small">
                                <?php echo e($trx->metode_pemesanan ?? '-'); ?>

                            </td>
                            <td class="py-3 px-3 text-white fw-semibold">
                                Rp <?php echo e(number_format($trx->total_harga ?? 0, 0, ',', '.')); ?>

                            </td>
                            <td class="py-3 px-3">
                                <?php $status = $trx->status_pembayaran ?? '-'; ?>
                                <?php if($status === 'Lunas'): ?>
                                    <span class="badge rounded-pill px-3 py-1" style="background: rgba(6, 78, 59, 0.65); color: #4ade80; border: 1px solid #166534;">
                                        Lunas
                                    </span>
                                <?php elseif($status === 'Batal'): ?>
                                    <span class="badge rounded-pill px-3 py-1" style="background: rgba(127, 29, 29, 0.65); color: #f87171; border: 1px solid #991b1b;">
                                        Batal
                                    </span>
                                <?php else: ?>
                                    <span class="badge rounded-pill px-3 py-1" style="background: rgba(120, 53, 15, 0.65); color: #fbbf24; border: 1px solid #92400e;">
                                        <?php echo e($status); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-secondary py-4">
                                Belum ada data transaksi terbaru.
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