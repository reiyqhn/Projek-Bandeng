

<?php $__env->startSection('title', 'Profil Saya - Bandeng Samudera'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #ff9f1c;">Profil Customer</h2>
        <p class="text-white-50 mb-0" style="font-size: 0.9rem;">Perbarui informasi pribadi dan detail pengiriman Anda</p>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success border-0 rounded-4 shadow-sm d-flex align-items-center gap-2 mb-4" style="background: rgba(16, 185, 129, 0.2); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.4) !important;">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div><?php echo e(session('success')); ?></div>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4" style="background: rgba(239, 68, 68, 0.2); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.4) !important;">
            <ul class="mb-0 ps-3 small">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="p-4 p-md-5 rounded-4 shadow-lg" style="background: rgba(15, 35, 58, 0.72); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.14); max-width: 820px;">
        <form action="<?php echo e(route('customer.profil.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="row g-4">
                <!-- ID Customer (Otomatis / Tidak Bisa Diubah) -->
                <div class="col-md-6">
                    <label class="form-label text-white-50 small fw-semibold text-uppercase">ID Customer (Otomatis)</label>
                    <div class="input-group">
                        <span class="input-group-text border-0 text-info" style="background: rgba(255, 255, 255, 0.08);">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="text"
                               value="<?php echo e($customer->id_customer); ?>"
                               readonly
                               disabled
                               class="form-control border-0 text-white-50 fw-semibold"
                               style="background: rgba(255, 255, 255, 0.06); cursor: not-allowed;">
                    </div>
                    <small class="text-white-50" style="font-size: 0.72rem;">ID dibuat otomatis oleh sistem dan tidak dapat diubah.</small>
                </div>

                <!-- Username -->
                <div class="col-md-6">
                    <label class="form-label text-white-50 small fw-semibold text-uppercase">Username</label>
                    <input type="text"
                           name="username"
                           value="<?php echo e(old('username', $customer->username)); ?>"
                           required
                           class="form-control border-0 text-white py-2 px-3 rounded-3"
                           style="background: rgba(255, 255, 255, 0.12);">
                </div>

                <!-- Nama Lengkap -->
                <div class="col-md-6">
                    <label class="form-label text-white-50 small fw-semibold text-uppercase">Nama Lengkap</label>
                    <input type="text"
                           name="nama"
                           value="<?php echo e(old('nama', $customer->nama)); ?>"
                           required
                           class="form-control border-0 text-white py-2 px-3 rounded-3"
                           style="background: rgba(255, 255, 255, 0.12);">
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label text-white-50 small fw-semibold text-uppercase">Email</label>
                    <input type="email"
                           name="email"
                           value="<?php echo e(old('email', $customer->email)); ?>"
                           required
                           class="form-control border-0 text-white py-2 px-3 rounded-3"
                           style="background: rgba(255, 255, 255, 0.12);">
                </div>

                <!-- No Telepon -->
                <div class="col-md-6">
                    <label class="form-label text-white-50 small fw-semibold text-uppercase">No. Telepon / WhatsApp</label>
                    <input type="text"
                           name="no_telp"
                           value="<?php echo e(old('no_telp', $customer->no_telp)); ?>"
                           placeholder="Contoh: 081234567890"
                           class="form-control border-0 text-white py-2 px-3 rounded-3"
                           style="background: rgba(255, 255, 255, 0.12);">
                </div>

                <!-- Alamat -->
                <div class="col-md-6">
                    <label class="form-label text-white-50 small fw-semibold text-uppercase">Alamat Lengkap</label>
                    <input type="text"
                           name="alamat"
                           value="<?php echo e(old('alamat', $customer->alamat)); ?>"
                           placeholder="Masukkan alamat pengiriman"
                           class="form-control border-0 text-white py-2 px-3 rounded-3"
                           style="background: rgba(255, 255, 255, 0.12);">
                </div>

                <div class="col-12">
                    <hr style="border-color: rgba(255, 255, 255, 0.12);">
                    <p class="text-white-50 small mb-0">
                        <i class="bi bi-shield-lock me-1 text-info"></i>
                        <strong>Ubah Password</strong> <span class="opacity-75">(Kosongkan jika tidak ingin mengganti password)</span>
                    </p>
                </div>

                <!-- Password Baru -->
                <div class="col-md-6">
                    <label class="form-label text-white-50 small fw-semibold text-uppercase">Password Baru</label>
                    <input type="password"
                           name="password"
                           placeholder="Minimal 6 karakter"
                           class="form-control border-0 text-white py-2 px-3 rounded-3"
                           style="background: rgba(255, 255, 255, 0.12);">
                </div>

                <!-- Konfirmasi Password Baru -->
                <div class="col-md-6">
                    <label class="form-label text-white-50 small fw-semibold text-uppercase">Konfirmasi Password Baru</label>
                    <input type="password"
                           name="password_confirmation"
                           placeholder="Ulangi password baru"
                           class="form-control border-0 text-white py-2 px-3 rounded-3"
                           style="background: rgba(255, 255, 255, 0.12);">
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top" style="border-color: rgba(255, 255, 255, 0.12) !important;">
                <a href="<?php echo e(route('pesanan.index')); ?>" class="btn btn-outline-light rounded-pill px-4 py-2 small">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                </a>

                <button type="submit" class="btn rounded-pill px-4 py-2 fw-semibold text-white shadow" style="background: linear-gradient(90deg, #00b4d8 0%, #0077b6 100%);">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Projek-Bandeng\resources\views/pesanan/profil.blade.php ENDPATH**/ ?>