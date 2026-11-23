<?php $__env->startSection('title', 'Penjualan Offline - Kasir'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <h3 class="text-lg font-bold text-white tracking-wide">Penjualan Offline (POS)</h3>

    <?php if(session('error')): ?>
        <div class="p-4 bg-red-950/60 border border-red-800 text-red-300 rounded-xl text-sm">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="p-4 bg-teal-950/60 border border-teal-800 text-teal-300 rounded-xl text-sm">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- KOTAK KIRI: FORM INPUT CUSTOMER & TAMBAH BARANG -->
        <div class="p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/70 backdrop-blur-xl space-y-5">
            <h4 class="text-base font-bold text-white border-b border-gray-800 pb-3">Input Data Pelanggan & Barang</h4>

            <form action="<?php echo e(route('kasir.offline.tambahItem')); ?>" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Kode Customer (Otomatis / Unik)</label>
                    <input type="text" name="id_customer" value="<?php echo e($customerData['id_customer']); ?>" readonly required
                           class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-xs text-teal-300 font-mono focus:outline-none">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Customer</label>
                    <input type="text" name="nama_customer" value="<?php echo e($customerData['nama_customer']); ?>" required
                           placeholder="Masukkan nama customer..."
                           class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-teal-500 focus:outline-none">
                </div>

                <div class="space-y-1 pt-1">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Nama / Kode Barang</label>
                    <select name="id_bandeng" required
                            class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-teal-500 focus:outline-none">
                        <option value="">-- Masukan nama atau kode barang --</option>
                        <?php $__currentLoopData = $bandengs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($b->id_bandeng); ?>" <?php echo e($b->stok <= 0 ? 'disabled' : ''); ?>>
                                (<?php echo e($b->id_bandeng); ?>) <?php echo e($b->nama_bandeng); ?> - Rp <?php echo e(number_format($b->harga, 0, ',', '.')); ?> (Stok: <?php echo e($b->stok); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Jumlah</label>
                    <input type="number" name="jumlah" value="1" min="1" required
                           class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-teal-500 focus:outline-none">
                </div>

                <div class="pt-2 flex items-center gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-xl shadow-lg transition">
                        + Tambahkan
                    </button>
            </form>

                    <?php if(count($keranjang) > 0): ?>
                        <form action="<?php echo e(route('kasir.offline.batal')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    class="px-5 py-2.5 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl shadow-lg transition">
                                Batal
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
        </div>

        <!-- KOTAK KANAN: KERANJANG BELANJA -->
        <div class="p-6 rounded-2xl card-glass shadow-2xl border border-teal-900/40 bg-gray-900/70 backdrop-blur-xl flex flex-col justify-between space-y-6">
            <div>
                <h4 class="text-base font-bold text-white border-b border-gray-800 pb-3 mb-4">Keranjang Belanja</h4>

                <div class="overflow-x-auto min-h-[180px]">
                    <table class="w-full text-left text-sm text-gray-300">
                        <thead class="bg-blue-950/60 text-gray-300 uppercase text-xs border-b border-gray-800">
                            <tr>
                                <th class="py-2.5 px-3 rounded-l-lg">Barang</th>
                                <th class="py-2.5 px-3 text-center">Jumlah</th>
                                <th class="py-2.5 px-3">Subtotal</th>
                                <th class="py-2.5 px-3 rounded-r-lg text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800/40">
                            <?php $__empty_1 = true; $__currentLoopData = $keranjang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="py-3 px-3 text-white"><?php echo e($item['nama']); ?></td>
                                    <td class="py-3 px-3 text-gray-300 text-center font-semibold"><?php echo e($item['jumlah']); ?></td>
                                    <td class="py-3 px-3 text-teal-300 font-semibold">Rp <?php echo e(number_format($item['subtotal'], 0, ',', '.')); ?></td>
                                    <td class="py-3 px-3 text-right">
                                        <div class="inline-flex items-center gap-1.5">
                                            <form action="<?php echo e(route('kasir.offline.updateQty')); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="id_bandeng" value="<?php echo e($item['id']); ?>">
                                                <input type="hidden" name="aksi" value="minus">
                                                <button type="submit"
                                                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-gray-800 hover:bg-rose-600 text-white font-bold text-sm transition">
                                                    -
                                                </button>
                                            </form>

                                            <form action="<?php echo e(route('kasir.offline.updateQty')); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="id_bandeng" value="<?php echo e($item['id']); ?>">
                                                <input type="hidden" name="aksi" value="plus">
                                                <button type="submit"
                                                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-gray-800 hover:bg-teal-600 text-white font-bold text-sm transition">
                                                    +
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500 text-xs italic">Keranjang masih kosong</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bagian Total & Tombol Selesai Pilih Barang -->
            <form action="<?php echo e(route('kasir.offline.store')); ?>" method="POST" class="space-y-4 pt-4 border-t border-gray-800">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id_customer" value="<?php echo e($customerData['id_customer']); ?>">
                <input type="hidden" name="nama_customer" value="<?php echo e($customerData['nama_customer']); ?>">

                <div class="bg-blue-950/80 p-4 rounded-xl border border-blue-900/50 shadow-inner">
                    <span class="text-[10px] text-gray-400 uppercase tracking-wider block font-semibold">Total Pembayaran</span>
                    <div class="text-xl font-black text-teal-400">Rp <?php echo e(number_format($totalSemua, 0, ',', '.')); ?></div>
                </div>

                <button type="submit" <?php echo e(count($keranjang) === 0 ? 'disabled' : ''); ?>

                        class="w-full py-3 bg-emerald-600 hover:bg-emerald-500 disabled:opacity-50 text-white text-xs font-bold rounded-xl shadow-lg transition uppercase tracking-wider">
                    Selesai Pilih Barang
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Projek-Bandeng\resources\views/dashboard/kasir/transaksi_offline/index.blade.php ENDPATH**/ ?>