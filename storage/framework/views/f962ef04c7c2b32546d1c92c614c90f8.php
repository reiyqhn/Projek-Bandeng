<?php $__env->startSection('title', 'Riwayat Pesanan - Kasir'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <h3 class="text-lg font-bold text-white tracking-wide">Riwayat Pesanan</h3>

    <!-- KARTU DAFTAR TRANSAKSI -->
    <div class="p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/70 backdrop-blur-xl space-y-5">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-800 pb-4">
            <h4 class="text-base font-bold text-white">Daftar Transaksi</h4>

            <!-- Form Filter Dropdown -->
            <form method="GET" action="<?php echo e(route('kasir.riwayat')); ?>" id="filterForm" class="flex flex-wrap items-center gap-3">
                <?php if(request('lihat')): ?>
                    <input type="hidden" name="lihat" value="<?php echo e(request('lihat')); ?>">
                <?php endif; ?>

                <!-- Dropdown Jenis Transaksi -->
                <div class="relative">
                    <select name="jenis" onchange="document.getElementById('filterForm').submit()"
                        class="appearance-none bg-blue-950/90 hover:bg-blue-900 text-white text-xs font-semibold border border-teal-700/50 rounded-lg pl-3.5 pr-8 py-2 focus:outline-none focus:border-teal-400 cursor-pointer transition">
                        <option value="semua" <?php echo e($jenisTransaksi === 'semua' ? 'selected' : ''); ?>>Semua Transaksi</option>
                        <option value="online" <?php echo e($jenisTransaksi === 'online' ? 'selected' : ''); ?>>Transaksi Online</option>
                        <option value="offline" <?php echo e($jenisTransaksi === 'offline' ? 'selected' : ''); ?>>Transaksi Offline</option>
                    </select>
                    <span class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center text-xs text-teal-300">▼</span>
                </div>

                <!-- Dropdown Metode Pembayaran -->
                <div class="relative">
                    <select name="metode" onchange="document.getElementById('filterForm').submit()"
                        class="appearance-none bg-blue-950/90 hover:bg-blue-900 text-white text-xs font-semibold border border-teal-700/50 rounded-lg pl-3.5 pr-8 py-2 focus:outline-none focus:border-teal-400 cursor-pointer transition">
                        <option value="semua" <?php echo e($metodePembayaran === 'semua' ? 'selected' : ''); ?>>Semua Metode Pembayaran</option>
                        <option value="Tunai" <?php echo e($metodePembayaran === 'Tunai' ? 'selected' : ''); ?>>Tunai</option>
                        <option value="QRIS" <?php echo e($metodePembayaran === 'QRIS' ? 'selected' : ''); ?>>QRIS</option>
                        <option value="Transfer" <?php echo e($metodePembayaran === 'Transfer' ? 'selected' : ''); ?>>Transfer</option>
                    </select>
                    <span class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center text-xs text-teal-300">▼</span>
                </div>
            </form>
        </div>

        <!-- Tabel Riwayat -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-200 border-collapse">
                <thead>
                    <tr class="bg-blue-950/90 text-white uppercase tracking-wider border-b border-teal-800/50">
                        <th class="py-3 px-3">No</th>
                        <th class="py-3 px-3">Waktu</th>
                        <th class="py-3 px-3">No Faktur</th>
                        <th class="py-3 px-3">Customer</th>
                        <th class="py-3 px-3">Pembayaran</th>
                        <th class="py-3 px-3">Pemesanan</th>
                        <th class="py-3 px-3">Total</th>
                        <th class="py-3 px-3 text-center">Status</th>
                        <th class="py-3 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/80">
                    <?php $__empty_1 = true; $__currentLoopData = $transaksis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $isOnline = in_array($trx->metode_pemesanan, ['Delivery', 'Online']);
                            $labelPemesanan = $isOnline ? 'Online' : 'Offline';
                            $waktuFormat = $trx->tanggal_penjualan
                                ? \Carbon\Carbon::parse($trx->tanggal_penjualan)->format('H:i')
                                : '-';
                        ?>
                        <tr class="hover:bg-teal-950/30 transition <?php echo e(request('lihat') === $trx->no_faktur ? 'bg-teal-900/30' : ''); ?>">
                            <td class="py-3 px-3"><?php echo e($index + 1); ?></td>
                            <td class="py-3 px-3 font-mono"><?php echo e($waktuFormat); ?></td>
                            <td class="py-3 px-3 font-mono font-semibold text-teal-300"><?php echo e($trx->no_faktur); ?></td>
                            <td class="py-3 px-3"><?php echo e($trx->customer->nama ?? ($trx->nama_customer ?? '-')); ?></td>
                            <td class="py-3 px-3"><?php echo e($trx->metode_pembayaran ?? '-'); ?></td>
                            <td class="py-3 px-3"><?php echo e($labelPemesanan); ?></td>
                            <td class="py-3 px-3 font-semibold text-white">Rp <?php echo e(number_format($trx->subtotal, 0, ',', '.')); ?></td>
                            <td class="py-3 px-3 text-center">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-600/80 text-white border border-emerald-400/40">
                                    <?php echo e($trx->status_pembayaran); ?>

                                </span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <a href="<?php echo e(route('kasir.riwayat', ['jenis' => $jenisTransaksi, 'metode' => $metodePembayaran, 'lihat' => $trx->no_faktur])); ?>#detail-transaksi"
                                   class="px-3.5 py-1.5 rounded-lg bg-slate-700/80 hover:bg-teal-600 text-white text-[11px] font-semibold border border-gray-600/60 transition inline-block">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="py-8 text-center text-gray-400">
                                Tidak ada transaksi lunas yang sesuai dengan filter saat ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- KARTU DETAIL TRANSAKSI (MUNCUL SAAT KLIK LIHAT) -->
    <?php if($detailTransaksi): ?>
        <?php
            $detailIsOnline = in_array($detailTransaksi->metode_pemesanan, ['Delivery', 'Online']);
            $detailPemesanan = $detailIsOnline ? 'Online' : 'Offline';
        ?>
        <div id="detail-transaksi" class="p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/75 backdrop-blur-xl space-y-5">
            <h4 class="text-base font-bold text-white border-b border-gray-800 pb-3">Detail Transaksi</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 rounded-xl bg-slate-800/70 border border-gray-700/60">
                    <div class="text-xs text-gray-400">No Faktur</div>
                    <div class="text-sm font-bold text-white mt-1 font-mono"><?php echo e($detailTransaksi->no_faktur); ?></div>
                </div>

                <div class="p-4 rounded-xl bg-slate-800/70 border border-gray-700/60">
                    <div class="text-xs text-gray-400">Tanggal</div>
                    <div class="text-sm font-bold text-white mt-1">
                        <?php echo e($detailTransaksi->tanggal_penjualan ? \Carbon\Carbon::parse($detailTransaksi->tanggal_penjualan)->translatedFormat('d F Y') : '-'); ?>

                    </div>
                </div>

                <div class="p-4 rounded-xl bg-slate-800/70 border border-gray-700/60">
                    <div class="text-xs text-gray-400">Customer</div>
                    <div class="text-sm font-bold text-white mt-1"><?php echo e($detailTransaksi->customer->nama ?? ($detailTransaksi->nama_customer ?? '-')); ?></div>
                </div>

                <div class="p-4 rounded-xl bg-slate-800/70 border border-gray-700/60">
                    <div class="text-xs text-gray-400">Metode Pembayaran</div>
                    <div class="text-sm font-bold text-white mt-1"><?php echo e($detailTransaksi->metode_pembayaran ?? '-'); ?></div>
                </div>

                <div class="p-4 rounded-xl bg-slate-800/70 border border-gray-700/60">
                    <div class="text-xs text-gray-400">Jenis Pemesanan</div>
                    <div class="text-sm font-bold text-white mt-1"><?php echo e($detailPemesanan); ?></div>
                </div>

                <div class="p-4 rounded-xl bg-slate-800/70 border border-gray-700/60">
                    <div class="text-xs text-gray-400">Status</div>
                    <div class="text-sm font-bold text-emerald-400 mt-1"><?php echo e($detailTransaksi->status_pembayaran); ?></div>
                </div>
            </div>

            <!-- Rincian Item Produk (jika ada detail penjualan) -->
            <?php if($detailTransaksi->detailPenjualans && $detailTransaksi->detailPenjualans->count() > 0): ?>
                <div class="overflow-x-auto rounded-xl border border-gray-800">
                    <table class="w-full text-left text-xs text-gray-200">
                        <thead class="bg-gray-950/90 text-gray-400 uppercase">
                            <tr>
                                <th class="py-2.5 px-3">Produk</th>
                                <th class="py-2.5 px-3 text-center">Jumlah</th>
                                <th class="py-2.5 px-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            <?php $__currentLoopData = $detailTransaksi->detailPenjualans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="py-2.5 px-3 text-white"><?php echo e($item->produk->nama_bandeng ?? $item->id_bandeng); ?></td>
                                    <td class="py-2.5 px-3 text-center"><?php echo e($item->jumlah); ?></td>
                                    <td class="py-2.5 px-3 text-right text-teal-300 font-semibold">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
                <a href="<?php echo e(route('kasir.riwayat', ['jenis' => $jenisTransaksi, 'metode' => $metodePembayaran])); ?>"
                   class="inline-block px-4 py-2 rounded-lg bg-rose-700/80 hover:bg-rose-600 text-white text-xs font-bold transition w-fit">
                    Tutup Detail
                </a>

                <div class="text-right">
                    <div class="text-xs text-gray-400">Total Pembayaran</div>
                    <div class="text-xl font-extrabold text-white">Rp <?php echo e(number_format($detailTransaksi->subtotal, 0, ',', '.')); ?></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Projek-Bandeng\resources\views/dashboard/kasir/riwayat_pesanan.blade.php ENDPATH**/ ?>