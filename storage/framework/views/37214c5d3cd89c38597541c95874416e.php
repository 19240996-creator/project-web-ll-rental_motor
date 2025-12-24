

<?php $__env->startSection('title', 'Edit Transaksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3"><i class="fas fa-edit"></i> Edit Transaksi</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-exchange-alt"></i> Form Edit Transaksi
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('transaksi.update', $transaksi->Id_transaksi)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="form-group mb-3">
                            <label for="Status_sewa" class="form-label">Status Sewa</label>
                            <select class="form-select <?php $__errorArgs = ['Status_sewa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="Status_sewa" name="Status_sewa" required>
                                <option value="Proses" <?php echo e($transaksi->Status_sewa === 'Proses' ? 'selected' : ''); ?>>Proses</option>
                                <option value="Aktif" <?php echo e($transaksi->Status_sewa === 'Aktif' ? 'selected' : ''); ?>>Aktif</option>
                                <option value="Selesai" <?php echo e($transaksi->Status_sewa === 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
                                <option value="Batal" <?php echo e($transaksi->Status_sewa === 'Batal' ? 'selected' : ''); ?>>Batal</option>
                            </select>
                            <?php $__errorArgs = ['Status_sewa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Informasi Transaksi</label>
                            <div class="bg-light p-3 rounded">
                                <p><strong>ID Transaksi:</strong> <?php echo e($transaksi->Id_transaksi); ?></p>
                                <p><strong>User:</strong> <?php echo e($transaksi->user->name); ?></p>
                                <p><strong>Motor:</strong> <?php echo e($transaksi->motor->Merk_motor); ?> - <?php echo e($transaksi->motor->Warna_motor); ?></p>
                                <p><strong>Tanggal Sewa:</strong> <?php echo e($transaksi->Tanggal_sewa); ?></p>
                                <p><strong>Tanggal Kembali:</strong> <?php echo e($transaksi->Tanggal_kembali); ?></p>
                                <p><strong>Total Biaya:</strong> Rp <?php echo e(number_format($transaksi->Total_biaya, 0, ',', '.')); ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="<?php echo e(route('transaksi.index')); ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PROJECT AKHIR WEB II\project-web-ll-rental_motor\resources\views/transaksi/edit.blade.php ENDPATH**/ ?>