

<?php $__env->startSection('title', 'Data Pengembalian'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3"><i class="fas fa-undo"></i> Data Pengembalian</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?php echo e(route('pengembalian.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Catat Pengembalian
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Pengembalian</th>
                    <th>ID Transaksi</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Tanggal Kembali Sebenarnya</th>
                    <th>Status</th>
                    <th>Biaya Keterlambatan</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pengembalians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pengembalian): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php if($pengembalian->Status_pengembalian === 'Dikembalikan_Terlambat'): ?> table-danger <?php endif; ?>">
                        <td><?php echo e($key + 1); ?></td>
                        <td><strong><?php echo e($pengembalian->Id_pengembalian); ?></strong></td>
                        <td><?php echo e($pengembalian->Id_transaksi); ?></td>
                        <td><?php echo e($pengembalian->Tanggal_pengembalian->format('d/m/Y')); ?></td>
                        <td>
                            <?php if($pengembalian->Tanggal_kembali_sebenarnya): ?>
                                <?php echo e($pengembalian->Tanggal_kembali_sebenarnya->format('d/m/Y')); ?>

                                <?php if($pengembalian->Status_pengembalian === 'Dikembalikan_Terlambat'): ?>
                                    <br><small class="text-danger"><strong>TERLAMBAT</strong></small>
                                <?php endif; ?>
                            <?php else: ?>
                                <em class="text-muted">-</em>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge bg-<?php echo e($pengembalian->getStatusColor()); ?>">
                                <?php echo e($pengembalian->getStatusText()); ?>

                            </span>
                        </td>
                        <td>
                            <?php if($pengembalian->Biaya_keterlambatan > 0): ?>
                                <strong class="text-danger">Rp <?php echo e(number_format($pengembalian->Biaya_keterlambatan, 0, ',', '.')); ?></strong>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($pengembalian->Catatan ?? '-'); ?></td>
                        <td>
                            <form action="<?php echo e(route('pengembalian.destroy', $pengembalian->Id_pengembalian)); ?>" method="POST" style="display:inline;">
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
                        <td colspan="9" class="text-center text-muted">Tidak ada data pengembalian</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PROJECT AKHIR WEB II\project-web-ll-rental_motor\resources\views/pengembalian/index.blade.php ENDPATH**/ ?>