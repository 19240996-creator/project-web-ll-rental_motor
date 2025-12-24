<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<style>
    :root{
        --brand-1: #667eea;
        --brand-2: #764ba2;
        --muted: #6c757d;
        --glass: rgba(255,255,255,0.8);
    }

    .page-bg{
        background: linear-gradient(180deg, #f7f9fc 0%, #eef2fb 100%);
        padding: 30px 0;
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--brand-1) 0%, var(--brand-2) 100%);
        color: white;
        padding: 28px 24px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.15);
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:20px;
    }

    .dashboard-header .title {
        display:flex;align-items:center;gap:12px;
    }

    .dashboard-header h1{font-size:20px;margin:0;font-weight:700}
    .dashboard-header p{margin:0;opacity:.9}

    .welcome-section{background:var(--glass);backdrop-filter: blur(6px);border-radius:12px;padding:18px 20px;margin-bottom:18px;display:flex;align-items:center;justify-content:space-between;gap:12px}
    .welcome-section h2{font-size:18px;margin:0}
    .welcome-section p{margin:0;color:var(--muted)}

    .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:18px;margin-bottom:18px}
    .stat-card{background:white;border-radius:12px;padding:18px;box-shadow:0 6px 18px rgba(19,24,31,0.05);position:relative;overflow:hidden;transition:transform .18s ease,box-shadow .18s ease}
    .stat-card:hover{transform:translateY(-6px);box-shadow:0 18px 40px rgba(19,24,31,0.08)}
    .stat-top{display:flex;align-items:center;gap:12px}
    .stat-bubble{width:56px;height:56px;border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;font-size:20px}
    .stat-body{flex:1}
    .stat-value{font-size:26px;font-weight:700;margin:0}
    .stat-label{color:var(--muted);font-size:13px;margin-top:6px}

    .quick-actions{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:18px}
    .action-btn{padding:10px 16px;border-radius:10px;text-decoration:none;font-weight:600;color:white;display:inline-flex;align-items:center;gap:8px}

    .action-primary{background:linear-gradient(90deg,var(--brand-1),var(--brand-2))}
    .action-success{background:linear-gradient(90deg,#28a745,#20c997)}
    .action-info{background:linear-gradient(90deg,#17a2b8,#00bcd4)}

    .row {display:flex;flex-wrap:wrap;gap:18px}
    .col-lg-8{flex:0 0 66.6666%;max-width:66.6666%}
    .col-lg-4{flex:0 0 33.3333%;max-width:33.3333%}
    @media (max-width: 992px){.col-lg-8,.col-lg-4{flex:0 0 100%;max-width:100%}}

    .chart-section,.recent-activity{background:white;border-radius:12px;padding:18px;box-shadow:0 6px 18px rgba(19,24,31,0.04)}
    .chart-actions{display:flex;gap:8px;align-items:center}

    .activity-item{display:flex;gap:12px;padding:12px 0;border-bottom:1px solid #f1f3f5}
    .activity-item:last-child{border-bottom:none}
    .activity-icon{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;color:white}

    .small-note{color:var(--muted);font-size:13px}
</style>

<div class="container-fluid page-bg">

    <div class="container">
        <div class="welcome-section">
            <div>
                <h2><i class="fas fa-hand-wave" style="color:var(--brand-1);margin-right:8px"></i>Selamat Datang, <?php echo e(Auth::user()->name); ?>!</h2>
                <p class="small-note">Kelola rental motor Anda dengan mudah dan efisien</p>
            </div>
            <div class="small-note">Terakhir login: <strong><?php echo e(Auth::user()->last_login_at ?? '—'); ?></strong></div>
        </div>

        <div class="dashboard-header">
            <div class="title">
                <h1><i class="fas fa-tachometer-alt" style="color:rgba(255,255,255,0.95)"></i> Dashboard</h1>
                <p>Ringkasan aktivitas dan statistik</p>
            </div>
            <div class="chart-actions">
                <a href="<?php echo e(route('motor.index')); ?>" class="action-btn action-primary"><i class="fas fa-list"></i> Data Motor</a>
                <a href="<?php echo e(route('transaksi.index')); ?>" class="action-btn action-success"><i class="fas fa-receipt"></i> Transaksi</a>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-bubble" style="background:linear-gradient(90deg,var(--brand-1),var(--brand-2))">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="stat-body">
                        <p class="stat-value"><?php echo e($total_motors); ?></p>
                        <p class="stat-label">Total Motor</p>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-bubble" style="background:linear-gradient(90deg,#28a745,#20c997)">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-body">
                        <p class="stat-value"><?php echo e($motors_available); ?></p>
                        <p class="stat-label">Motor Tersedia</p>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-bubble" style="background:linear-gradient(90deg,#dc3545,#ff6b6b)">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="stat-body">
                        <p class="stat-value"><?php echo e($motors_rented); ?></p>
                        <p class="stat-label">Motor Disewa</p>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-bubble" style="background:linear-gradient(90deg,#ffc107,#ff9800);color:#2b2b2b">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="stat-body">
                        <p class="stat-value"><?php echo e($total_transaksi); ?></p>
                        <p class="stat-label">Total Transaksi</p>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-bubble" style="background:linear-gradient(90deg,#6c757d,#495057)">
                        <i class="fas fa-undo"></i>
                    </div>
                    <div class="stat-body">
                        <p class="stat-value"><?php echo e($total_pengembalian); ?></p>
                        <p class="stat-label">Pengembalian</p>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-bubble" style="background:linear-gradient(90deg,#00bcd4,#17a2b8)">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-body">
                        <p class="stat-value"><?php echo e($total_admin ?? 0); ?></p>
                        <p class="stat-label">Total Admin</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="quick-actions">
            <a href="<?php echo e(route('motor.create')); ?>" class="action-btn action-primary"><i class="fas fa-plus"></i> Tambah Motor</a>
            <a href="<?php echo e(route('transaksi.create')); ?>" class="action-btn action-success"><i class="fas fa-file-invoice"></i> Buat Transaksi</a>
            <a href="<?php echo e(route('motor.index')); ?>" class="action-btn action-info"><i class="fas fa-list"></i> Lihat Motor</a>
            <a href="<?php echo e(route('transaksi.index')); ?>" class="action-btn action-primary"><i class="fas fa-receipt"></i> Lihat Transaksi</a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="chart-section">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
                        <h5 style="margin:0"><i class="fas fa-chart-bar" style="color:var(--brand-1);margin-right:8px"></i> Statistik Aktivitas</h5>
                        <div class="small-note">Periode: <strong><?php echo e($chartPeriod ?? 'Bulan ini'); ?></strong></div>
                    </div>
                    <p class="small-note">Data statistik mengenai transaksi dan pengembalian motor</p>
                    <canvas id="activityChart" height="120"></canvas>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="recent-activity">
                    <h5 style="margin-bottom:12px"><i class="fas fa-history" style="color:var(--brand-1);margin-right:8px"></i> Aktivitas Terbaru</h5>

                    <div class="activity-item">
                        <div class="activity-icon" style="background:linear-gradient(90deg,var(--brand-1),var(--brand-2))">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div>
                            <p style="margin:0;font-weight:600">Anda login ke sistem</p>
                            <div class="small-note"><?php echo e(now()->diffForHumans()); ?></div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon" style="background:linear-gradient(90deg,#28a745,#20c997)">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <p style="margin:0;font-weight:600">Sistem siap digunakan</p>
                            <div class="small-note">Hari ini</div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon" style="background:linear-gradient(90deg,#17a2b8,#00bcd4)">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <p style="margin:0;font-weight:600">Selamat datang di rental motor</p>
                            <div class="small-note">Hari pertama</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        const ctx = document.getElementById('activityChart');
        if(!ctx) return;

        const labels = <?php echo json_encode($chartLabels); ?>;
        const data = [<?php echo e($total_transaksi ?? 0); ?>, 12, 18, 6];

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Transaksi',
                    data: data,
                    backgroundColor: 'rgba(102,126,234,0.85)',
                    borderRadius: 6,
                    barThickness: 18
                }]
            },
            options: {
                responsive: true,
                plugins: {legend:{display:false}},
                scales: {
                    y: {beginAtZero:true,grid:{color:'rgba(0,0,0,0.04)'}},
                    x: {grid:{display:false}}
                }
            }
        });
    });
</script>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PROJECT AKHIR WEB II\project-web-ll-rental_motor\resources\views/dashboard.blade.php ENDPATH**/ ?>