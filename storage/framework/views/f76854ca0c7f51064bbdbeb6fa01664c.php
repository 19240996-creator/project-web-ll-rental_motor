

<?php $__env->startSection('title', 'Data Motor'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3"><i class="fas fa-motorcycle"></i> Data Motor</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?php echo e(route('motor.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Motor
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Motor</th>
                    <th>Merk</th>
                    <th>Warna</th>
                    <th>Plat Nomor</th>
                    <th>Tahun</th>
                    <th>Harga/Hari</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $motors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $motor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($key + 1); ?></td>
                        <td><strong><?php echo e($motor->Id_motor); ?></strong></td>
                        <td><?php echo e($motor->Merk_motor); ?></td>
                        <td><?php echo e($motor->Warna_motor); ?></td>
                        <td><?php echo e($motor->Plat_nomor ?? '-'); ?></td>
                        <td><?php echo e($motor->Tahun_motor); ?></td>
                        <td>Rp <?php echo e(number_format($motor->Harga, 0, ',', '.')); ?></td>
                        <td>
                            <?php if($motor->Status_motor === 'Tersedia'): ?>
                                <span class="badge badge-success">Tersedia</span>
                            <?php elseif($motor->Status_motor === 'Disewa'): ?>
                                <span class="badge badge-danger">Disewa</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Maintenance</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('motor.edit', $motor->Id_motor)); ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('motor.destroy', $motor->Id_motor)); ?>" method="POST" style="display:inline;">
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
                        <td colspan="9" class="text-center text-muted">Tidak ada data motor</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PROJECT AKHIR WEB II\project-web-ll-rental_motor\resources\views/motor/index.blade.php ENDPATH**/ ?>