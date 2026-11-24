<?php $__env->startSection('title', 'Tambah Pegawai - Bandeng Samudra'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">

    <div class="p-4 rounded-4 card-glass-admin mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-info text-dark mb-2 px-3 py-1 fw-bold">Data Pegawai</span>
                <h4 class="fw-bold text-white mb-0">Tambah Pegawai Baru</h4>
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

    <form action="<?php echo e(route('admin.pegawai.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="p-4 rounded-4 card-glass-admin">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-secondary small">Jabatan / Role</label>
                    <select name="jabatan" id="selectJabatan" class="form-select text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" required>
                        <option value="karyawan" <?php echo e(old('jabatan', 'karyawan') === 'karyawan' ? 'selected' : ''); ?>>Kurir / Karyawan</option>
                        <option value="kasir" <?php echo e(old('jabatan') === 'kasir' ? 'selected' : ''); ?>>Kasir</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-secondary small">ID Pegawai</label>
                    <input type="text" name="id_pegawai" id="inputIdPegawai" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" value="<?php echo e(old('id_pegawai', $nextIdKaryawan ?? 'KR001')); ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-secondary small">Status Pegawai</label>
                    <select name="status" class="form-select text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" required>
                        <option value="Aktif" <?php echo e(old('status', 'Aktif') === 'Aktif' ? 'selected' : ''); ?>>Aktif</option>
                        <option value="Cuti" <?php echo e(old('status') === 'Cuti' ? 'selected' : ''); ?>>Cuti</option>
                        <option value="Tidak Aktif" <?php echo e(old('status') === 'Tidak Aktif' ? 'selected' : ''); ?>>Tidak Aktif</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" placeholder="Contoh: Budi Santoso" value="<?php echo e(old('nama')); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Email</label>
                    <input type="email" name="email" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" placeholder="contoh@gmail.com" value="<?php echo e(old('email')); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">No. Telp</label>
                    <input type="text" name="no_telp" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" placeholder="081234567890" value="<?php echo e(old('no_telp')); ?>">
                </div>

                <div class="col-md-6" id="fieldAlamat" style="display: <?php echo e(old('jabatan') === 'kasir' ? 'block' : 'none'); ?>;">
                    <label class="form-label text-secondary small">Alamat (Khusus Kasir)</label>
                    <input type="text" name="alamat" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" placeholder="Alamat tempat tinggal" value="<?php echo e(old('alamat')); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Username</label>
                    <input type="text" name="username" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" placeholder="username_pegawai" value="<?php echo e(old('username')); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary small">Password</label>
                    <input type="password" name="password" class="form-control text-white border-secondary" style="background: rgba(3, 19, 31, 0.75);" placeholder="Minimal 4 karakter" required>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top border-secondary d-flex justify-content-end gap-2">
                <a href="<?php echo e(route('admin.pegawai.index')); ?>" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" class="btn text-white fw-bold px-4" style="background: linear-gradient(90deg, #0d9488 0%, #115e59 100%);">Simpan Pegawai</button>
            </div>
        </div>
    </form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectJabatan = document.getElementById('selectJabatan');
        const inputId = document.getElementById('inputIdPegawai');
        const fieldAlamat = document.getElementById('fieldAlamat');
        const nextIdKasir = <?php echo json_encode($nextIdKasir ?? 'KS001', 15, 512) ?>;
        const nextIdKaryawan = <?php echo json_encode($nextIdKaryawan ?? 'KR001', 15, 512) ?>;

        selectJabatan.addEventListener('change', function () {
            if (this.value === 'kasir') {
                inputId.value = nextIdKasir;
                fieldAlamat.style.display = 'block';
            } else {
                inputId.value = nextIdKaryawan;
                fieldAlamat.style.display = 'none';
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Projek-Bandeng\resources\views/admin/pegawai/create.blade.php ENDPATH**/ ?>