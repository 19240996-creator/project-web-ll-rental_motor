

<?php $__env->startSection('title', 'Riwayat Sewa - Rental Motor'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 mb-0">
                <i class="fas fa-history text-primary"></i> Riwayat Sewa Anda
            </h1>
        </div>
    </div>

    <?php if($transactions->isEmpty()): ?>
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle"></i> Anda belum memiliki riwayat sewa. 
            <a href="<?php echo e(route('motor.index')); ?>" class="alert-link">Cari motor untuk disewa</a>
        </div>
    <?php else: ?>
        <div class="row">
            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 transaction-card">
                        <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden;">
                            <!-- Motor Icon Background -->
                            <div style="position: absolute; right: -15px; top: -15px; font-size: 120px; opacity: 0.1; color: white;">
                                <i class="fas fa-motorcycle"></i>
                            </div>
                            
                            <div class="row align-items-center" style="position: relative; z-index: 2;">
                                <div class="col">
                                    <h6 class="mb-0 text-dark">
                                        <i class="fas fa-motorcycle"></i> <?php echo e($transaction->motor->Merk_motor ?? 'Motor'); ?> - <?php echo e($transaction->motor->Warna_motor ?? ''); ?>

                                    </h6>
                                    <small class="text-dark"><?php echo e($transaction->motor->Warna_motor ?? 'N/A'); ?> | <?php echo e($transaction->motor->Plat_nomor ?? 'N/A'); ?></small>
                                </div>
                                <div class="col-auto">
                                    <?php
                                        $status = strtolower($transaction->Status_sewa ?? 'proses');
                                        if ($status === 'selesai') {
                                            $badgeClass = 'bg-success';
                                        } elseif ($status === 'aktif') {
                                            $badgeClass = 'bg-info';
                                        } elseif ($status === 'batal') {
                                            $badgeClass = 'bg-danger';
                                        } else {
                                            $badgeClass = 'bg-warning';
                                        }
                                    ?>
                                    <span class="badge <?php echo e($badgeClass); ?>"><?php echo e(ucfirst($status)); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Motor Icon Display -->
                        <div style="text-align: center; padding: 20px 0; background: linear-gradient(to bottom, #f8f9fa, white);">
                            <div style="font-size: 60px; color: #667eea;">
                                🏍️
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="mb-3">
                                <small class="text-muted d-block"><i class="fas fa-calendar"></i> Tanggal Sewa</small>
                                <strong><?php echo e(\Carbon\Carbon::parse($transaction->Tanggal_sewa)->format('d M Y')); ?></strong>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block"><i class="fas fa-calendar"></i> Rencana Kembali</small>
                                <strong><?php echo e(\Carbon\Carbon::parse($transaction->Tanggal_kembali)->format('d M Y')); ?></strong>
                            </div>
                            
                            <?php if($transaction->pengembalian && $transaction->pengembalian->Tanggal_kembali_sebenarnya): ?>
                                <div class="mb-3">
                                    <small class="text-muted d-block"><i class="fas fa-undo"></i> Kembali Aktual</small>
                                    <strong><?php echo e(\Carbon\Carbon::parse($transaction->pengembalian->Tanggal_kembali_sebenarnya)->format('d M Y')); ?></strong>
                                </div>
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block"><i class="fas fa-money-bill"></i> Total Sewa</small>
                                <strong class="text-primary">Rp <?php echo e(number_format($transaction->Total_biaya ?? 0, 0, ',', '.')); ?></strong>
                            </div>
                            
                            <?php if(isset($transaction->denda) && $transaction->denda > 0): ?>
                                <div class="alert alert-warning mb-3 py-2 px-3" role="alert">
                                    <small>
                                        <i class="fas fa-exclamation-triangle"></i> <strong>Denda Keterlambatan</strong><br>
                                        Terlambat <?php echo e($transaction->daysLate); ?> hari<br>
                                        <strong class="text-danger">Rp <?php echo e(number_format($transaction->denda, 0, ',', '.')); ?></strong>
                                    </small>
                                </div>
                            <?php endif; ?>
                            
                            <div class="pt-2 border-top">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> Dibuat: <?php echo e($transaction->created_at->format('d M Y H:i')); ?>

                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .transaction-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .transaction-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
    }
    
    .bg-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PROJECT AKHIR WEB II\project-web-ll-rental_motor\resources\views/customer-transactions.blade.php ENDPATH**/ ?>