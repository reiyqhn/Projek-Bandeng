<?php $__env->startSection('content'); ?>
<div style="max-width: 820px; width: 100%; margin: 0 auto;">
    
    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="font-size: 2.2rem; letter-spacing: 0.5px; background: linear-gradient(90deg, #ffffff 15%, #ffd1a9 50%, #f97316 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block; filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, 0.3);">
            Notifikasi
        </h1>
        <p class="text-white-50 mb-0" style="font-size: 0.9rem;">Pemberitahuan status transaksi dan tagihan pembayaran kamu</p>
    </div>

    <div class="d-flex flex-column gap-3 pb-5">
        <?php $__empty_1 = true; $__currentLoopData = $notifikasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="p-3 p-md-4 rounded-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3" 
                 style="background: rgba(255, 255, 255, 0.08); 
                        backdrop-filter: blur(16px); 
                        -webkit-backdrop-filter: blur(16px); 
                        border: 1.5px solid <?php echo e($item->status_pembayaran == 'Belum Lunas' && !$item->bukti_pembayaran && $item->metode_pembayaran != 'Cash' ? 'rgba(255, 183, 77, 0.6)' : 'rgba(255, 255, 255, 0.18)'); ?>; 
                        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.25);">
                
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                        <strong class="text-white" style="font-size: 1.05rem;">Pesanan #<?php echo e($item->no_faktur); ?></strong>
                        
                        <?php if($item->metode_pembayaran == 'Cash'): ?>
                            <span class="badge bg-warning text-dark" style="font-size: 0.7rem; border-radius: 20px; padding: 5px 10px;">COD (Bayar di Tempat)</span>
                        <?php elseif($item->status_pembayaran == 'Belum Lunas'): ?>
                            <?php if($item->bukti_pembayaran): ?>
                                <span class="badge bg-info text-dark" style="font-size: 0.7rem; border-radius: 20px; padding: 5px 10px;">Menunggu Konfirmasi</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark" style="font-size: 0.7rem; border-radius: 20px; padding: 5px 10px;">Belum Lunas</span>
                            <?php endif; ?>
                        <?php elseif($item->status_pembayaran == 'Batal'): ?>
                            <span class="badge bg-danger" style="font-size: 0.7rem; border-radius: 20px; padding: 5px 10px;">Batal</span>
                        <?php else: ?>
                            <span class="badge bg-success" style="font-size: 0.7rem; border-radius: 20px; padding: 5px 10px;">Lunas</span>
                        <?php endif; ?>
                    </div>
                    
                    <small class="text-white-50" style="font-size: 0.78rem;">
                        <i class="bi bi-clock me-1"></i> <?php echo e(\Carbon\Carbon::parse($item->tanggal_penjualan)->translatedFormat('d F Y, H:i')); ?> WIB
                    </small>
                    
                    <p class="mb-0 text-white-50 mt-1" style="font-size: 0.85rem;">
                        <?php if($item->metode_pembayaran == 'Cash'): ?>
                            Pesanan berhasil dibuat. Siapkan uang tunai saat pengiriman/pengambilan barang.
                        <?php elseif($item->status_pembayaran == 'Belum Lunas'): ?>
                            <?php if($item->bukti_pembayaran): ?>
                                Bukti pembayaran telah dikirim. Menunggu verifikasi kasir.
                            <?php else: ?>
                                Selesaikan pembayaran Anda sebelum waktu habis.
                            <?php endif; ?>
                        <?php elseif($item->status_pembayaran == 'Batal'): ?>
                            Waktu pembayaran habis. Pesanan otomatis dibatalkan.
                        <?php else: ?>
                            Pembayaran berhasil dikonfirmasi! Pesananmu sedang diproses.
                        <?php endif; ?>
                    </p>
                </div>

                <div class="text-md-end d-flex flex-column align-items-md-end gap-2">
                    <span class="fw-bold" style="font-size: 1.15rem; color: #fbbf24;">
                        Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?>

                    </span>

                    <?php if($item->metode_pembayaran == 'Cash'): ?>
                        <a href="<?php echo e(route('pesanan.konfirmasi', $item->no_faktur)); ?>" class="btn btn-sm text-white fw-semibold px-3 py-2" style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; font-size: 0.82rem;">
                            <i class="bi bi-receipt me-1"></i> Lihat Detail
                        </a>
                    <?php elseif($item->status_pembayaran == 'Belum Lunas' && !$item->bukti_pembayaran): ?>
                        <a href="<?php echo e(route('pesanan.pembayaran', $item->no_faktur)); ?>" class="btn btn-sm text-white fw-semibold px-3 py-2" style="background: linear-gradient(90deg, #00b4d8 0%, #0077b6 100%); border-radius: 10px; font-size: 0.82rem;">
                            Bayar Sekarang <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    <?php elseif($item->status_pembayaran == 'Lunas'): ?>
                        <a href="<?php echo e(route('pesanan.konfirmasi', $item->no_faktur)); ?>" class="btn btn-sm text-white fw-semibold px-3 py-2" style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; font-size: 0.82rem;">
                            <i class="bi bi-receipt me-1"></i> Lihat Faktur
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="p-5 text-center rounded-4" style="background: rgba(255, 255, 255, 0.05); border: 1.5px solid rgba(255, 255, 255, 0.15); backdrop-filter: blur(16px);">
                <i class="bi bi-bell-slash fs-1 text-white-50 mb-2 d-block"></i>
                <h5 class="text-white fw-bold mb-1">Belum Ada Notifikasi</h5>
                <p class="text-white-50 mb-0" style="font-size: 0.85rem;">Pemberitahuan saat ini belum tersedia.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Projek-Bandeng\resources\views/pesanan/notifikasi.blade.php ENDPATH**/ ?>