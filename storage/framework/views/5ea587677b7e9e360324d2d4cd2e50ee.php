

<?php $__env->startSection('title', 'Detail Booking - Rental Motor'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
    }

    .detail-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
    }

    .detail-card-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #667eea;
    }

    .detail-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .detail-group {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
    }

    .detail-label {
        font-size: 12px;
        color: #666;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .detail-value {
        font-size: 16px;
        color: #333;
        font-weight: 600;
    }

    .badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 14px;
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

    .denda-alert {
        background: #ffe5e5;
        border-left: 4px solid #dc3545;
        padding: 20px;
        border-radius: 10px;
    }

    .motor-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .motor-icon {
        font-size: 64px;
    }

    .button-group {
        margin-top: 30px;
        display: flex;
        gap: 10px;
    }
</style>

<div class="container-fluid">
    <div class="detail-header">
        <h1 class="h3 mb-0">
            <i class="fas fa-receipt"></i> Detail Booking
        </h1>
        <p class="mb-0 mt-2">ID: <?php echo e($transaksi->Id_transaksi); ?></p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            
            <div class="detail-card">
                <h5 class="detail-card-title">
                    <i class="fas fa-info-circle"></i> Status Pemesanan
                </h5>
                <span class="badge status-<?php echo e(strtolower(str_replace(' ', '_', $transaksi->Status_sewa))); ?>">
                    <?php echo e(ucfirst($transaksi->Status_sewa)); ?>

                </span>
            </div>

            
            <div class="detail-card">
                <h5 class="detail-card-title">
                    <i class="fas fa-motorcycle"></i> Informasi Motor
                </h5>
                <div class="motor-info">
                    <div class="motor-icon">🏍️</div>
                    <div>
                        <div class="detail-row">
                            <div class="detail-group">
                                <div class="detail-label">Merk</div>
                                <div class="detail-value"><?php echo e($transaksi->motor->Merk_motor); ?> - <?php echo e($transaksi->motor->Warna_motor); ?></div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-label">Warna</div>
                                <div class="detail-value"><?php echo e($transaksi->motor->Warna_motor); ?></div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-label">Plat Nomor</div>
                                <div class="detail-value"><?php echo e($transaksi->motor->Plat_nomor ?? 'N/A'); ?></div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-label">Harga/Hari</div>
                                <div class="detail-value text-success">Rp <?php echo e(number_format($transaksi->motor->Harga, 0, ',', '.')); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="detail-card">
                <h5 class="detail-card-title">
                    <i class="fas fa-calendar-alt"></i> Tanggal & Harga
                </h5>
                <div class="detail-row">
                    <div class="detail-group">
                        <div class="detail-label">Tanggal Mulai Sewa</div>
                        <div class="detail-value"><?php echo e(\Carbon\Carbon::parse($transaksi->Tanggal_sewa)->format('d M Y')); ?></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Tanggal Kembali</div>
                        <div class="detail-value"><?php echo e(\Carbon\Carbon::parse($transaksi->Tanggal_kembali)->format('d M Y')); ?></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Durasi Sewa</div>
                        <div class="detail-value">
                            <?php echo e(\Carbon\Carbon::parse($transaksi->Tanggal_kembali)->diffInDays(\Carbon\Carbon::parse($transaksi->Tanggal_sewa)) + 1); ?> Hari
                        </div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Total Biaya</div>
                        <div class="detail-value text-primary">Rp <?php echo e(number_format($transaksi->Total_biaya, 0, ',', '.')); ?></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Metode Pembayaran</div>
                        <div class="detail-value">
                            <?php if($transaksi->metode_pembayaran === 'cash'): ?>
                                <span class="badge bg-success"><i class="fas fa-money-bill"></i> Cash</span>
                            <?php elseif($transaksi->metode_pembayaran === 'qr'): ?>
                                <span class="badge bg-info"><i class="fas fa-qrcode"></i> QR Code</span>
                            <?php elseif($transaksi->metode_pembayaran === 'bank'): ?>
                                <span class="badge bg-warning"><i class="fas fa-university"></i> Transfer Bank</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Belum ditentukan</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <?php if($transaksi->metode_pembayaran === 'bank' && $transaksi->bank_tujuan): ?>
                        <div class="detail-group">
                            <div class="detail-label">Bank Tujuan Transfer</div>
                            <div class="detail-value">
                                <span class="badge bg-info"><?php echo e($transaksi->bank_tujuan); ?></span>
                            </div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label"><i class="fas fa-user"></i> Atas Nama</div>
                            <div class="detail-value">PT. GO-JAG Rental Motor</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label"><i class="fas fa-hashtag"></i> Nomor Rekening</div>
                            <div class="detail-value" style="font-family: monospace; letter-spacing: 1px; font-size: 18px; color: #667eea;">
                                1730017287724
                            </div>
                            <small class="text-muted mt-2" style="display: block;">Kirimkan bukti transfer untuk verifikasi pembayaran</small>
                        </div>
                    <?php endif; ?>

                    
                    <?php if($transaksi->metode_pembayaran === 'qr' && $transaksi->qr_code): ?>
                        <div class="detail-group">
                            <div class="detail-label">Kode QR Pembayaran</div>
                            <div style="text-align: center; margin-top: 10px;">
                                <img src="<?php echo e($transaksi->qr_code); ?>" alt="QR Code Pembayaran" style="max-width: 150px; height: auto; border: 2px solid #ddd; padding: 10px; border-radius: 8px;" />
                            </div>
                            <small class="text-muted mt-2" style="display: block;">Scan QR code untuk melakukan pembayaran</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <?php if($transaksi->pengembalian): ?>
                <div class="detail-card">
                    <h5 class="detail-card-title">
                        <i class="fas fa-undo"></i> Informasi Pengembalian
                    </h5>
                    <div class="detail-row">
                        <div class="detail-group">
                            <div class="detail-label">Tanggal Pengembalian Rencana</div>
                            <div class="detail-value"><?php echo e(\Carbon\Carbon::parse($transaksi->Tanggal_kembali)->format('d M Y')); ?></div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Tanggal Pengembalian Aktual</div>
                            <div class="detail-value">
                                <?php if($transaksi->pengembalian->Tanggal_kembali_sebenarnya): ?>
                                    <?php echo e(\Carbon\Carbon::parse($transaksi->pengembalian->Tanggal_kembali_sebenarnya)->format('d M Y')); ?>

                                <?php else: ?>
                                    <span class="text-muted">Belum dikembalikan</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Status Pengembalian</div>
                            <div class="detail-value"><?php echo e(ucfirst($transaksi->pengembalian->Status_pengembalian ?? 'Diproses')); ?></div>
                        </div>
                    </div>

                    
                    <?php
                        $denda = 0;
                        if ($transaksi->pengembalian->Tanggal_kembali_sebenarnya) {
                            $actualDate = \Carbon\Carbon::parse($transaksi->pengembalian->Tanggal_kembali_sebenarnya);
                            $plannedDate = \Carbon\Carbon::parse($transaksi->Tanggal_kembali);
                            if ($actualDate->greaterThan($plannedDate)) {
                                $daysLate = $actualDate->diffInDays($plannedDate);
                                $denda = $daysLate * $transaksi->motor->Harga;
                            }
                        }
                    ?>

                    <?php if($denda > 0): ?>
                        <div class="denda-alert" style="margin-top: 15px;">
                            <h6 style="margin-bottom: 10px;">
                                <i class="fas fa-exclamation-triangle"></i> Denda Keterlambatan
                            </h6>
                            <div style="margin-bottom: 10px;">
                                <strong>Terlambat:</strong> 
                                <?php
                                    $daysLate = \Carbon\Carbon::parse($transaksi->pengembalian->Tanggal_kembali_sebenarnya)->diffInDays(\Carbon\Carbon::parse($transaksi->Tanggal_kembali));
                                ?>
                                <?php echo e($daysLate); ?> hari
                            </div>
                            <div style="margin-bottom: 10px;">
                                <strong>Harga/Hari:</strong> Rp <?php echo e(number_format($transaksi->motor->Harga, 0, ',', '.')); ?>

                            </div>
                            <div style="font-size: 18px; font-weight: bold; color: #dc3545;">
                                Total Denda: Rp <?php echo e(number_format($denda, 0, ',', '.')); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="col-lg-4">
            
            <div class="detail-card">
                <h5 class="detail-card-title">
                    <i class="fas fa-user"></i> Informasi Penyewa
                </h5>
                <div class="detail-group mb-3">
                    <div class="detail-label">Nama</div>
                    <div class="detail-value"><?php echo e($transaksi->user->name); ?></div>
                </div>
                <div class="detail-group mb-3">
                    <div class="detail-label">Email</div>
                    <div class="detail-value" style="font-size: 14px;"><?php echo e($transaksi->user->email); ?></div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">No. Telepon</div>
                    <div class="detail-value"><?php echo e($transaksi->user->no_telepon ?? 'N/A'); ?></div>
                </div>
            </div>

            
            <?php if($transaksi->admin): ?>
                <div class="detail-card">
                    <h5 class="detail-card-title">
                        <i class="fas fa-user-tie"></i> Admin Penangani
                    </h5>
                    <div class="detail-group">
                        <div class="detail-label">Nama Admin</div>
                        <div class="detail-value"><?php echo e($transaksi->admin->Nama_admin ?? 'N/A'); ?></div>
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="button-group">
                <a href="<?php echo e(Auth::user()->role === 'customer' ? route('transaksi.index') : route('transaksi.index')); ?>" class="btn btn-secondary w-100">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PROJECT AKHIR WEB II\project-web-ll-rental_motor\resources\views/transaksi/show.blade.php ENDPATH**/ ?>