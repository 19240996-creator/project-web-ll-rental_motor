

<?php $__env->startSection('title', 'Data Transaksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3"><i class="fas fa-exchange-alt"></i> Data Transaksi</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?php echo e(route('transaksi.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Buat Transaksi
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>User</th>
                    <th>Motor</th>
                    <th>Admin</th>
                    <th>Tgl Sewa</th>
                    <th>Tgl Kembali</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $transaksis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $transaksi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($key + 1); ?></td>
                        <td><strong><?php echo e($transaksi->Id_transaksi); ?></strong></td>
                        <td><?php echo e($transaksi->user->name ?? '-'); ?></td>
                        <td><?php echo e($transaksi->motor->Merk_motor ?? '-'); ?> - <?php echo e($transaksi->motor->Warna_motor ?? '-'); ?></td>
                        <td><?php echo e($transaksi->admin->Nama_admin ?? '-'); ?></td>
                        <td><?php echo e($transaksi->Tanggal_sewa); ?></td>
                        <td><?php echo e($transaksi->Tanggal_kembali); ?></td>
                        <td>Rp <?php echo e(number_format($transaksi->Total_biaya, 0, ',', '.')); ?></td>
                        <td>
                            <?php if($transaksi->Status_sewa === 'Proses'): ?>
                                <span class="badge badge-secondary">Proses</span>
                            <?php elseif($transaksi->Status_sewa === 'Aktif'): ?>
                                <span class="badge badge-info">Aktif</span>
                            <?php elseif($transaksi->Status_sewa === 'Selesai'): ?>
                                <span class="badge badge-success">Selesai</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Batal</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('transaksi.edit', $transaksi->Id_transaksi)); ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('transaksi.destroy', $transaksi->Id_transaksi)); ?>" method="POST" style="display:inline;">
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
                        <td colspan="10" class="text-center text-muted">Tidak ada data transaksi</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PROJECT AKHIR WEB II\project-web-ll-rental_motor\resources\views/transaksi/index.blade.php ENDPATH**/ ?>