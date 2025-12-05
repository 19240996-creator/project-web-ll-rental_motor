@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 30px;
        border-radius: 15px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .dashboard-header h1 {
        font-size: 32px;
        font-weight: bold;
        margin: 0;
        margin-bottom: 10px;
    }

    .dashboard-header p {
        opacity: 0.9;
        margin: 0;
        font-size: 16px;
    }

    .stat-card {
        border: none;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .stat-card.primary::before {
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }

    .stat-card.success::before {
        background: linear-gradient(90deg, #28a745 0%, #20c997 100%);
    }

    .stat-card.danger::before {
        background: linear-gradient(90deg, #dc3545 0%, #ff6b6b 100%);
    }

    .stat-card.warning::before {
        background: linear-gradient(90deg, #ffc107 0%, #ff9800 100%);
    }

    .stat-card.secondary::before {
        background: linear-gradient(90deg, #6c757d 0%, #495057 100%);
    }

    .stat-icon {
        font-size: 32px;
        margin-bottom: 15px;
    }

    .stat-value {
        font-size: 36px;
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 14px;
        color: #999;
        font-weight: 500;
    }

    .quick-actions {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }

    .quick-actions h5 {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .action-btn {
        display: inline-block;
        padding: 12px 24px;
        margin-right: 12px;
        margin-bottom: 12px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .action-btn i {
        margin-right: 8px;
    }

    .action-btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }

    .action-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .action-btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border: none;
    }

    .action-btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
        color: white;
    }

    .action-btn-info {
        background: linear-gradient(135deg, #17a2b8 0%, #00bcd4 100%);
        color: white;
        border: none;
    }

    .action-btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(23, 162, 184, 0.3);
        color: white;
    }

    .welcome-section {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        text-align: center;
    }

    .welcome-section h2 {
        color: #333;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .welcome-section p {
        color: #666;
        font-size: 16px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .dashboard-header h1 {
            font-size: 24px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .action-btn {
            display: block;
            width: 100%;
            text-align: center;
            margin-right: 0;
            margin-bottom: 10px;
        }
    }

    .chart-section {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }

    .chart-section h5 {
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .recent-activity {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    }

    .recent-activity h5 {
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .activity-item {
        padding: 15px 0;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 15px;
        font-size: 18px;
    }

    .activity-text {
        flex: 1;
    }

    .activity-text p {
        margin: 0;
        color: #333;
        font-weight: 500;
    }

    .activity-time {
        color: #999;
        font-size: 12px;
    }
</style>

<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <h2><i class="fas fa-hand-wave" style="margin-right: 10px; color: #667eea;"></i>Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p>Kelola rental motor Anda dengan mudah dan efisien</p>
    </div>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1><i class="fas fa-chart-line"></i> Dashboard</h1>
        <p>Ringkasan aktivitas dan statistik rental motor Anda</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-icon">
                <i class="fas fa-motorcycle"></i>
            </div>
            <div class="stat-value">{{ $total_motors }}</div>
            <div class="stat-label">Total Motor</div>
        </div>

        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $motors_available }}</div>
            <div class="stat-label">Motor Tersedia</div>
        </div>

        <div class="stat-card danger">
            <div class="stat-icon">
                <i class="fas fa-lock"></i>
            </div>
            <div class="stat-value">{{ $motors_rented }}</div>
            <div class="stat-label">Motor Disewa</div>
        </div>

        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div class="stat-value">{{ $total_transaksi }}</div>
            <div class="stat-label">Total Transaksi</div>
        </div>

        <div class="stat-card secondary">
            <div class="stat-icon">
                <i class="fas fa-undo"></i>
            </div>
            <div class="stat-value">{{ $total_pengembalian }}</div>
            <div class="stat-label">Pengembalian</div>
        </div>

        <div class="stat-card info">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $total_admin ?? 0 }}</div>
            <div class="stat-label">Total Admin</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h5><i class="fas fa-bolt" style="margin-right: 10px; color: #667eea;"></i>Aksi Cepat</h5>
        <a href="{{ route('motor.create') }}" class="action-btn action-btn-primary">
            <i class="fas fa-plus"></i> Tambah Motor
        </a>
        <a href="{{ route('transaksi.create') }}" class="action-btn action-btn-success">
            <i class="fas fa-file-invoice"></i> Buat Transaksi
        </a>
        <a href="{{ route('motor.index') }}" class="action-btn action-btn-info">
            <i class="fas fa-list"></i> Lihat Motor
        </a>
        <a href="{{ route('transaksi.index') }}" class="action-btn action-btn-primary">
            <i class="fas fa-receipt"></i> Lihat Transaksi
        </a>
    </div>

    <!-- Chart Section (Optional) -->
    <div class="row">
        <div class="col-lg-8">
            <div class="chart-section">
                <h5><i class="fas fa-chart-bar" style="margin-right: 10px; color: #667eea;"></i>Statistik Aktivitas</h5>
                <p style="color: #999;">Data statistik mengenai transaksi dan pengembalian motor</p>
                <div style="padding: 40px 0; text-align: center;">
                    <i class="fas fa-chart-pie" style="font-size: 48px; color: #ddd;"></i>
                    <p style="color: #999; margin-top: 15px;">Grafik akan ditampilkan setelah ada data transaksi</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="recent-activity">
                <h5><i class="fas fa-history" style="margin-right: 10px; color: #667eea;"></i>Aktivitas Terbaru</h5>
                
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="activity-text">
                        <p>Anda login ke sistem</p>
                        <div class="activity-time">Baru saja</div>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="activity-text">
                        <p>Sistem siap digunakan</p>
                        <div class="activity-time">Hari ini</div>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon" style="background: linear-gradient(135deg, #17a2b8 0%, #00bcd4 100%);">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="activity-text">
                        <p>Selamat datang di rental motor</p>
                        <div class="activity-time">Hari pertama</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
