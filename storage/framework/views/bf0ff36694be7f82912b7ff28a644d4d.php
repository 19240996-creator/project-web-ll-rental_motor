

<?php $__env->startSection('title', 'Booking Saya - Rental Motor'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .booking-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .booking-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        border-left: 5px solid #667eea;
        transition: all 0.3s ease;
        color: #333 !important;
    }

    .booking-card * {
        color: inherit !important;
    }

    .booking-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    }

    .booking-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .booking-card-title {
        font-weight: bold;
        color: #000 !important;
        margin: 0;
    }

    .booking-card-title i,
    .booking-card-title * {
        color: #000 !important;
    }

    .booking-card-id {
        font-size: 12px;
        color: #999;
        margin-top: 5px;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .status-proses {
        background: #fff3cd;
        color: #856404;
    }

    .status-aktif {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status-selesai {
        background: #d4edda;
        color: #155724;
    }

    .status-batal {
        background: #f8d7da;
        color: #721c24;
    }

    .booking-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
        color: #333 !important;
    }

    .booking-details * {
        color: inherit !important;
    }

    .detail-item {
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
        color: #333 !important;
    }

    .detail-item * {
        color: inherit !important;
    }

    .detail-label {
        font-size: 12px;
        color: #666;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .detail-value {
        font-size: 16px;
        color: #333;
        font-weight: 600;
    }

    .detail-value.price {
        color: #667eea;
        font-size: 18px;
    }

    .detail-item.motor-info {
        background: #e8edf7;
        color: #333;
    }

    .detail-item.motor-info .detail-label {
        color: #333 !important;
    }

    .detail-item.motor-info .detail-value {
        color: #000 !important;
        font-size: 18px;
        font-weight: bold;
    }

    .detail-item.motor-info .detail-value * {
        color: #000 !important;
    }

    .booking-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .btn-action {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-detail {
        background: #667eea;
        color: white;
    }

    .btn-detail:hover {
        background: #5568d3;
        color: white;
    }

    .btn-cancel {
        background: #dc3545;
        color: white;
    }

    .btn-cancel:hover {
        background: #c82333;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 60px 30px;
    }

    .empty-state-icon {
        font-size: 64px;
        color: #ddd;
        margin-bottom: 20px;
    }

    .empty-state-text {
        color: #999;
        margin-bottom: 30px;
    }

    .denda-alert {
        background: #ffe5e5;
        border-left: 4px solid #dc3545;
        padding: 12px;
        border-radius: 6px;
        margin-top: 10px;
        font-size: 13px;
        color: #721c24;
    }
</style>

<div class="container-fluid">
    <div class="booking-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-list-check"></i> Booking Saya
                </h1>
                <p class="mb-0 mt-2">Kelola semua pemesanan motor Anda di sini</p>
            </div>
            <a href="<?php echo e(route('transaksi.create')); ?>" class="btn btn-light btn-lg" style="font-weight: bold;">
                <i class="fas fa-plus-circle"></i> Pesan Motor Baru
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if($transaksis->isEmpty()): ?>
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h4 class="empty-state-text">Belum ada pemesanan</h4>
            <p class="empty-state-text">Anda belum membuat pemesanan. Mulai dengan memilih motor yang Anda inginkan.</p>
            <a href="<?php echo e(route('customer.dashboard')); ?>" class="btn btn-primary btn-lg">
                <i class="fas fa-search"></i> Lihat Motor Tersedia
            </a>
        </div>
    <?php else: ?>
        <div class="row">
            <?php $__currentLoopData = $transaksis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-6 col-xl-6 mb-3">
                    <div class="booking-card">
                        <div class="booking-card-header">
                            <div>
                                <h5 class="booking-card-title" style="color: #000 !important;">
                                    <i class="fas fa-motorcycle"></i> <?php echo e($booking->motor->Merk_motor ?? 'Motor'); ?> - <?php echo e($booking->motor->Warna_motor ?? ''); ?>

                                </h5>
                                <small class="booking-card-id">ID: <?php echo e($booking->Id_transaksi); ?></small>
                            </div>
                            <span class="status-badge status-<?php echo e(strtolower(str_replace(' ', '_', $booking->Status_sewa))); ?>">
                                <?php echo e(ucfirst($booking->Status_sewa)); ?>

                            </span>
                        </div>

                        <div class="booking-details">
                            <div class="detail-item motor-info">
                                <div class="detail-label"><i class="fas fa-motorcycle"></i> Keterangan Motor</div>
                                <div class="detail-value" style="color: #000 !important;"><?php echo e($booking->motor->Merk_motor); ?> - <?php echo e($booking->motor->Warna_motor); ?></div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label"><i class="fas fa-calendar"></i> Tanggal Sewa</div>
                                <div class="detail-value"><?php echo e(\Carbon\Carbon::parse($booking->Tanggal_sewa)->format('d M Y')); ?></div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label"><i class="fas fa-calendar"></i> Tanggal Kembali</div>
                                <div class="detail-value"><?php echo e(\Carbon\Carbon::parse($booking->Tanggal_kembali)->format('d M Y')); ?></div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label"><i class="fas fa-info-circle"></i> Durasi</div>
                                <div class="detail-value">
                                    <?php echo e(\Carbon\Carbon::parse($booking->Tanggal_kembali)->diffInDays(\Carbon\Carbon::parse($booking->Tanggal_sewa)) + 1); ?> hari
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label"><i class="fas fa-money-bill"></i> Total</div>
                                <div class="detail-value price">
                                    Rp <?php echo e(number_format($booking->Total_biaya, 0, ',', '.')); ?>

                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label"><i class="fas fa-credit-card"></i> Metode Bayar</div>
                                <div class="detail-value">
                                    <?php if($booking->metode_pembayaran === 'cash'): ?>
                                        <span class="badge bg-success"><i class="fas fa-money-bill"></i> Cash</span>
                                    <?php elseif($booking->metode_pembayaran === 'qr'): ?>
                                        <span class="badge bg-info"><i class="fas fa-qrcode"></i> QR Code</span>
                                    <?php elseif($booking->metode_pembayaran === 'bank'): ?>
                                        <span class="badge bg-warning"><i class="fas fa-university"></i> <?php echo e($booking->bank_tujuan ?? 'Bank'); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">-</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            
                            <?php if($booking->metode_pembayaran === 'bank' && $booking->bank_tujuan): ?>
                                <div class="detail-item" style="background: #fff8e1; border-left: 4px solid #ff6b35;">
                                    <div class="detail-label"><i class="fas fa-hashtag"></i> Nomor Rekening</div>
                                    <div class="detail-value" style="font-family: monospace; letter-spacing: 1px; color: #ff6b35;">
                                        1730017287724
                                    </div>
                                    <small style="display: block; margin-top: 5px; color: #666;">Atas Nama: PT. GO-JAG Rental Motor</small>
                                </div>
                            <?php endif; ?>

                            
                            <?php if($booking->metode_pembayaran === 'qr' && $booking->qr_code): ?>
                                <div class="detail-item" style="text-align: center;">
                                    <div class="detail-label"><i class="fas fa-qrcode"></i> Kode QR</div>
                                    <img src="<?php echo e($booking->qr_code); ?>" alt="QR Code" style="max-width: 100px; height: auto; border: 2px solid #ddd; padding: 5px; border-radius: 8px; margin-top: 10px;" />
                                </div>
                            <?php endif; ?>
                        </div>

                        
                        <?php
                            $pengembalian = $booking->pengembalian;
                            $denda = 0;
                            if ($pengembalian && $pengembalian->Tanggal_kembali_sebenarnya) {
                                $actualDate = \Carbon\Carbon::parse($pengembalian->Tanggal_kembali_sebenarnya);
                                $plannedDate = \Carbon\Carbon::parse($booking->Tanggal_kembali);
                                if ($actualDate->greaterThan($plannedDate)) {
                                    $daysLate = $actualDate->diffInDays($plannedDate);
                                    $denda = $daysLate * $booking->motor->Harga;
                                }
                            }
                        ?>

                        <?php if($denda > 0): ?>
                            <div class="denda-alert">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Denda Keterlambatan: Rp <?php echo e(number_format($denda, 0, ',', '.')); ?></strong>
                                <p class="mb-0">Motor dikembalikan terlambat dari tanggal rencana.</p>
                            </div>
                        <?php endif; ?>

                        <div class="booking-actions">
                            <a href="<?php echo e(route('transaksi.show', $booking->Id_transaksi)); ?>" class="btn-action btn-detail">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <?php if($booking->Status_sewa === 'Proses'): ?>
                                <form action="<?php echo e(route('transaksi.destroy', $booking->Id_transaksi)); ?>" method="POST" style="display: inline;" 
                                      onsubmit="return confirm('Yakin ingin membatalkan pemesanan?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-action btn-cancel">
                                        <i class="fas fa-times"></i> Batalkan
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div style="margin-top: 40px;">
            <a href="<?php echo e(route('customer.dashboard')); ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PROJECT AKHIR WEB II\project-web-ll-rental_motor\resources\views/transaksi/customer-index.blade.php ENDPATH**/ ?>