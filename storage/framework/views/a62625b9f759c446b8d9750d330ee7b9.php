<?php $__env->startSection('title', 'Lihat Data Bandeng - Bandeng Samudra'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">

    <div class="card p-4 rounded-4 border border-secondary card-glass-admin">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold text-white mb-1">Daftar Data Bandeng</h4>
                <p class="text-secondary small mb-0">Kelola semua data bandeng yang tersedia</p>
            </div>
            <a href="<?php echo e(route('admin.bandeng.create')); ?>" class="btn text-white fw-bold px-3 py-2" style="background: linear-gradient(90deg, #0d9488 0%, #115e59 100%); border-radius: 10px;">
                + Tambah Bandeng
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="--bs-table-bg: transparent;">
                <thead>
                    <tr class="text-secondary border-bottom border-secondary">
                        <th style="width: 55px;">No</th>
                        <th style="width: 90px;">ID</th>
                        <th style="width: 105px;">Foto</th>
                        <th>Nama Bandeng</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Deskripsi</th>
                        <th class="text-end" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $produks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $namaFileFoto = !empty($item->foto) ? basename($item->foto) : null;
                            if ($namaFileFoto && file_exists(public_path('uploads/bandeng/' . $namaFileFoto))) {
                                $urlFoto = asset('uploads/bandeng/' . $namaFileFoto);
                            } elseif ($namaFileFoto && file_exists(public_path('uploads/bukti/' . $namaFileFoto))) {
                                $urlFoto = asset('uploads/bukti/' . $namaFileFoto);
                            } elseif (!empty($item->foto) && file_exists(public_path($item->foto))) {
                                $urlFoto = asset($item->foto);
                            } else {
                                $urlFoto = null;
                            }
                        ?>
                        <tr class="border-bottom border-secondary border-opacity-25">
                            <td><?php echo e($index + 1); ?></td>
                            <td><span class="badge bg-info text-dark fw-bold"><?php echo e($item->id_bandeng); ?></span></td>
                            <td>
                                <?php if($urlFoto): ?>
                                    <img src="<?php echo e($urlFoto); ?>"
                                         alt="<?php echo e($item->nama_bandeng); ?>"
                                         class="rounded-3"
                                         style="width: 72px; height: 52px; object-fit: cover;">
                                <?php else: ?>
                                    <span class="text-secondary small"><?php echo e($item->nama_bandeng); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-semibold text-white"><?php echo e($item->nama_bandeng); ?></td>
                            <td class="text-light"><?php echo e($item->satuan); ?></td>
                            <td class="text-info fw-semibold">Rp <?php echo e(number_format($item->harga, 0, ',', '.')); ?></td>
                            <td class="text-light"><?php echo e($item->stok); ?></td>
                            <td class="text-secondary small" style="max-width: 240px;"><?php echo e($item->deskripsi); ?></td>
                            <td class="text-end">
                                <div class="d-flex flex-column gap-2 align-items-end">
                                    <a href="<?php echo e(route('admin.bandeng.edit', $item->id_bandeng)); ?>" class="btn btn-sm btn-primary px-3 w-100">
                                        Edit
                                    </a>

                                    <form action="<?php echo e(route('admin.bandeng.destroy', $item->id_bandeng)); ?>" method="POST" class="w-100" onsubmit="return confirm('Yakin ingin menghapus <?php echo e($item->nama_bandeng); ?>?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger px-3 w-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center text-secondary py-4">
                                Belum ada data bandeng di database.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Projek-Bandeng\resources\views/admin/bandeng/index.blade.php ENDPATH**/ ?>