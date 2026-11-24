<?php $__env->startSection('title', 'Edit Bandeng - Bandeng Samudra'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $item = $produk ?? $bandeng;
    $daftarSatuan = $daftarSatuan ?? ['kg', 'pack', 'pcs', 'ekor'];
    $satuanDipilih = old('satuan', $item->satuan ?? 'kg');

    $namaFileFoto = !empty($item->foto) ? basename($item->foto) : null;
    if ($namaFileFoto && file_exists(public_path('uploads/bandeng/' . $namaFileFoto))) {
        $urlFotoEdit = asset('uploads/bandeng/' . $namaFileFoto);
    } elseif ($namaFileFoto && file_exists(public_path('uploads/bukti/' . $namaFileFoto))) {
        $urlFotoEdit = asset('uploads/bukti/' . $namaFileFoto);
    } elseif (!empty($item->foto) && file_exists(public_path($item->foto))) {
        $urlFotoEdit = asset($item->foto);
    } else {
        $urlFotoEdit = null;
    }
?>

<div class="container-fluid px-0">

    <div class="card p-4 rounded-4 border border-secondary mb-4 card-glass-admin">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-info text-dark mb-2 px-3 py-1 fw-bold">Data Bandeng</span>
                <h4 class="fw-bold text-white mb-0">Edit Data Bandeng (<?php echo e($item->id_bandeng); ?>)</h4>
            </div>
            <a href="<?php echo e(route('admin.bandeng.index')); ?>" class="btn btn-outline-light btn-sm px-3">
                Kembali ke Lihat Data
            </a>
        </div>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger bg-danger bg-opacity-25 border-0 text-white mb-4 rounded-4 p-3">
            <div class="fw-bold mb-1">Terjadi kesalahan input:</div>
            <ul class="mb-0 small">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.bandeng.update', $item->id_bandeng)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card p-4 rounded-4 border border-secondary h-100 card-glass-admin">
                    <div class="mb-3">
                        <label class="form-label text-secondary small">ID Bandeng</label>
                        <input type="text" class="form-control text-secondary border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="<?php echo e($item->id_bandeng); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small">Nama Bandeng</label>
                        <input type="text" name="nama_bandeng" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="<?php echo e(old('nama_bandeng', $item->nama_bandeng)); ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Satuan</label>
                            <select name="satuan" class="form-select text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" required>
                                <?php $__currentLoopData = $daftarSatuan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $satuan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($satuan); ?>" <?php echo e($satuanDipilih === $satuan ? 'selected' : ''); ?>>
                                        <?php echo e($satuan); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small">Stok</label>
                            <input type="number" name="stok" min="0" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="<?php echo e(old('stok', $item->stok)); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small">Harga (Rp)</label>
                        <input type="number" name="harga" min="0" step="any" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="<?php echo e(old('harga', $item->harga)); ?>" required>
                    </div>

                    <div class="mb-0">
                        <label class="form-label text-secondary small">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);"><?php echo e(old('deskripsi', $item->deskripsi)); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card p-4 rounded-4 border border-secondary h-100 d-flex flex-column justify-content-between card-glass-admin">
                    <div>
                        <label class="form-label text-secondary small d-block">Foto Produk</label>
                        <input type="file" name="foto" class="form-control text-white border-secondary mb-3" style="background: rgba(3, 19, 31, 0.75);" accept="image/*">

                        <?php if($urlFotoEdit): ?>
                            <div class="text-center">
                                <img src="<?php echo e($urlFotoEdit); ?>" alt="<?php echo e($item->nama_bandeng); ?>" class="img-fluid rounded-3" style="max-height: 180px; object-fit: cover;">
                                <div class="text-secondary small mt-2">Foto saat ini</div>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-secondary small fst-italic py-4 border border-secondary rounded-3">
                                <?php echo e($item->foto ?: 'Belum ada foto produk'); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn text-white fw-bold w-100 mt-4 py-2" style="background: linear-gradient(90deg, #0d9488 0%, #115e59 100%);">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Projek-Bandeng\resources\views/admin/bandeng/edit.blade.php ENDPATH**/ ?>