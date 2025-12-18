

<?php $__env->startSection('title', 'Data Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3"><i class="fas fa-user-tie"></i> Data Admin</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?php echo e(route('admin.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Admin
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Admin</th>
                    <th>Nama</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($key + 1); ?></td>
                        <td><strong><?php echo e($admin->Id_admin_rental_motor); ?></strong></td>
                        <td><?php echo e($admin->Nama_admin); ?></td>
                        <td><?php echo e($admin->No_telp); ?></td>
                        <td><?php echo e($admin->Alamat); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.edit', $admin->Id_admin_rental_motor)); ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('admin.destroy', $admin->Id_admin_rental_motor)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada data admin</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PROJECT AKHIR WEB II\project-web-ll-rental_motor\resources\views/admin/index.blade.php ENDPATH**/ ?>