<?php $__env->startSection('title', 'Edit Pegawai - Bandeng Samudra'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">

    <div class="card p-4 rounded-4 border border-secondary mb-4" style="background: rgba(11, 25, 44, 0.88); border-color: rgba(13, 202, 240, 0.25) !important;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-info text-dark mb-2 px-3 py-1 fw-bold">Data Pegawai</span>
                <h4 class="fw-bold text-white mb-0">Edit Pegawai (<?php echo e($pegawai->id_karyawan); ?>)</h4>
            </div>
            <a href="<?php echo e(route('admin.pegawai.index')); ?>" class="btn btn-outline-light btn-sm px-3">
                Kembali
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

    <form action="<?php echo e(route('admin.pegawai.update', $pegawai->id_karyawan)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="card p-4 rounded-4 border border-secondary" style="background: rgba(11, 25, 44, 0.88);">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-secondary small">ID Karyawan</label>
                    <input type="text" class="form-control bg-dark text-secondary border-secondary" value="<?php echo e($pegawai->id_karyawan); ?>" readonly>
                </div>

                <div class="col-md-8">
                    <label class="form-label text-secondary small">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control bg-dark text-white border-secondary" value="<?php echo e(old('nama', $pegawai->nama)); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Email</label>
                    <input type="email" name="email" class="form-control bg-dark text-white border-secondary" value="<?php echo e(old('email', $pegawai->email)); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">No. Telp</label>
                    <input type="text" name="no_telp" class="form-control bg-dark text-white border-secondary" value="<?php echo e(old('no_telp', $pegawai->no_telp)); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Username</label>
                    <input type="text" name="username" class="form-control bg-dark text-white border-secondary" value="<?php echo e(old('username', $pegawai->username)); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Password Baru <span class="text-secondary">(Kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="form-control bg-dark text-white border-secondary" placeholder="Isi hanya jika ingin mengganti password">
                </div>
            </div>

            <div class="mt-4 pt-3 border-top border-secondary d-flex justify-content-end gap-2">
                <a href="<?php echo e(route('admin.pegawai.index')); ?>" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" class="btn btn-info text-dark fw-bold px-4">Simpan Perubahan</button>
            </div>
        </div>
    </form>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Projek-Bandeng\resources\views/admin/pegawai/edit.blade.php ENDPATH**/ ?>