<?php $__env->startSection('title', 'Data Customer - Bandeng Samudra'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">

    <?php if(session('success')): ?>
        <div class="alert alert-success bg-success bg-opacity-25 border-0 text-white mb-4 rounded-4 p-3">
            <i class="fa-solid fa-circle-check me-2"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger bg-danger bg-opacity-25 border-0 text-white mb-4 rounded-4 p-3">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="card p-4 rounded-4 border border-secondary" style="background: rgba(11, 25, 44, 0.88); border-color: rgba(13, 202, 240, 0.25) !important;">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold text-white mb-1">Data Customer</h4>
                <p class="text-secondary small mb-0">Kelola data customer yang tersimpan di tabel customer</p>
            </div>
            <a href="<?php echo e(route('admin.customer.create')); ?>" class="btn btn-info text-dark fw-bold px-3 py-2" style="border-radius: 10px;">
                + Tambah Customer
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="--bs-table-bg: transparent;">
                <thead>
                    <tr class="text-secondary border-bottom border-secondary">
                        <th style="width: 55px;">No</th>
                        <th>ID Customer</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Alamat</th>
                        <th>Username</th>
                        <th class="text-end" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-bottom border-secondary border-opacity-25">
                            <td><?php echo e($index + 1); ?></td>
                            <td><span class="badge bg-info text-dark fw-bold"><?php echo e($customer->id_customer); ?></span></td>
                            <td class="fw-semibold text-white"><?php echo e($customer->nama); ?></td>
                            <td class="text-light"><?php echo e($customer->email); ?></td>
                            <td class="text-light"><?php echo e($customer->no_telp ?? '-'); ?></td>
                            <td class="text-secondary small" style="max-width: 200px;"><?php echo e($customer->alamat ?? '-'); ?></td>
                            <td class="text-info"><?php echo e($customer->username); ?></td>
                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="<?php echo e(route('admin.customer.edit', $customer->id_customer)); ?>" class="btn btn-sm btn-primary px-3">
                                        Edit
                                    </a>
                                    <form action="<?php echo e(route('admin.customer.destroy', $customer->id_customer)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus customer <?php echo e($customer->nama); ?>?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger px-3">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center text-secondary py-4">
                                Belum ada data customer di database.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Projek-Bandeng\resources\views/admin/customer/index.blade.php ENDPATH**/ ?>