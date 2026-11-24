<?php $__env->startSection('title', 'Beranda - Kasir'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    html, body {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6" style="max-width: 100%; overflow-x: hidden;">
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-5 rounded-2xl card-glass bg-gray-900/70 border border-teal-900/40">
            <p class="text-xs text-gray-400">Hari Ini (Lunas)</p>
            <h3 class="text-xl font-black text-amber-400 mt-1">Rp <?php echo e(number_format($totalPenjualan, 0, ',', '.')); ?></h3>
            <p class="text-[10px] text-gray-400 uppercase tracking-wider mt-1">Total Penjualan Hari Ini</p>
        </div>
        <div class="p-5 rounded-2xl card-glass bg-gray-900/70 border border-teal-900/40">
            <p class="text-xs text-gray-400">Hari Ini</p>
            <h3 class="text-xl font-black text-white mt-1"><?php echo e($transaksiOnline); ?></h3>
            <p class="text-[10px] text-gray-400 uppercase tracking-wider mt-1">Transaksi Online</p>
        </div>
        <div class="p-5 rounded-2xl card-glass bg-gray-900/70 border border-teal-900/40">
            <p class="text-xs text-gray-400">Hari Ini</p>
            <h3 class="text-xl font-black text-white mt-1"><?php echo e($transaksiOffline); ?></h3>
            <p class="text-[10px] text-gray-400 uppercase tracking-wider mt-1">Transaksi Offline</p>
        </div>
        <div class="p-5 rounded-2xl card-glass bg-gray-900/70 border border-teal-900/40">
            <p class="text-xs text-gray-400">Hari Ini</p>
            <h3 class="text-xl font-black text-white mt-1"><?php echo e($totalTransaksi); ?></h3>
            <p class="text-[10px] text-gray-400 uppercase tracking-wider mt-1">Total Transaksi</p>
        </div>
    </div>

    <div class="p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/70 backdrop-blur-xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-white tracking-wide">Transaksi Terbaru</h3>
            <span class="text-[11px] text-gray-400">Klik baris transaksi untuk melihat detail</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-300">
                <thead class="bg-gray-800/80 text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="py-3 px-4 rounded-l-lg">Waktu</th>
                        <th class="py-3 px-4">No Faktur</th>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Pembayaran</th>
                        <th class="py-3 px-4">Pemesanan</th>
                        <th class="py-3 px-4">Total</th>
                        <th class="py-3 px-4 rounded-r-lg">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    <?php $__empty_1 = true; $__currentLoopData = $transaksiTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $isOffline = str_starts_with($item->no_faktur, 'TRX-OFF-') || $item->metode_pemesanan !== 'Delivery';
                        if ($isOffline) {
                            $targetUrl = route('kasir.offline.faktur', ['no_faktur' => $item->no_faktur]);
                        } elseif ($item->status_pembayaran !== 'Lunas') {
                            $targetUrl = route('kasir.online.pembayaran', ['id' => $item->no_faktur]) . '#detail-pesanan';
                        } else {
                            $targetUrl = \Illuminate\Support\Facades\Route::has('kasir.online.faktur')
                                ? route('kasir.online.faktur', ['no_faktur' => $item->no_faktur])
                                : route('kasir.online.pembayaran', ['id' => $item->no_faktur]) . '#detail-pesanan';
                        }
                    ?>
                    <tr onclick="window.location.href='<?php echo e($targetUrl); ?>'"
                        title="Klik untuk membuka detail transaksi <?php echo e($item->no_faktur); ?>"
                        class="hover:bg-teal-900/30 cursor-pointer transition group">
                        <td class="py-3 px-4 text-gray-400 text-xs">
                            <?php echo e(\Carbon\Carbon::parse($item->tanggal_penjualan)->format('d/m/Y H:i')); ?>

                        </td>
                        <td class="py-3 px-4 font-medium text-teal-300 group-hover:underline">
                            <?php echo e($item->no_faktur); ?>

                        </td>
                        <td class="py-3 px-4 text-white font-medium">
                            <?php echo e($item->customer->nama ?? '-'); ?>

                        </td>
                        <td class="py-3 px-4 text-gray-300">
                            <?php echo e($item->metode_pembayaran); ?>

                        </td>
                        <td class="py-3 px-4 text-gray-300">
                            <?php echo e($item->metode_pemesanan); ?>

                        </td>
                        <td class="py-3 px-4 font-semibold text-white">
                            Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?>

                        </td>
                        <td class="py-3 px-4">
                            <?php if($item->status_pembayaran == 'Lunas'): ?>
                                <span class="px-3 py-0.5 text-xs font-bold text-green-400 bg-green-950/60 border border-green-800 rounded-full">
                                    Lunas
                                </span>
                            <?php elseif($item->status_pembayaran == 'Batal'): ?>
                                <span class="px-3 py-0.5 text-xs font-bold text-red-400 bg-red-950/60 border border-red-800 rounded-full">
                                    Batal
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-0.5 text-xs font-bold text-amber-400 bg-amber-950/60 border border-amber-800 rounded-full">
                                    Menunggu
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="py-4 text-center text-gray-400">Belum ada transaksi terbaru.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Projek-Bandeng\resources\views/dashboard/kasir.blade.php ENDPATH**/ ?>