@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3"><i class="fas fa-chart-line"></i> Dashboard</h1>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="stat-card primary">
                <div class="stat-icon">
                    <i class="fas fa-motorcycle" style="color: var(--primary-color);"></i>
                </div>
                <div class="stat-value">{{ $total_motors }}</div>
                <div class="stat-label">Total Motor</div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 mb-3">
            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-check-circle" style="color: var(--success-color);"></i>
                </div>
                <div class="stat-value">{{ $motors_available }}</div>
                <div class="stat-label">Motor Tersedia</div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 mb-3">
            <div class="stat-card danger">
                <div class="stat-icon">
                    <i class="fas fa-lock" style="color: var(--danger-color);"></i>
                </div>
                <div class="stat-value">{{ $motors_rented }}</div>
                <div class="stat-label">Motor Disewa</div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 mb-3">
            <div class="stat-card secondary">
                <div class="stat-icon">
                    <i class="fas fa-exchange-alt" style="color: var(--secondary-color);"></i>
                </div>
                <div class="stat-value">{{ $total_transaksi }}</div>
                <div class="stat-label">Total Transaksi</div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 mb-3">
            <div class="stat-card info">
                <div class="stat-icon">
                    <i class="fas fa-history" style="color: var(--info-color);"></i>
                </div>
                <div class="stat-value">{{ $transaksi_aktif }}</div>
                <div class="stat-label">Transaksi Aktif</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bolt"></i> Quick Actions
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('motor.create') }}" class="btn btn-primary btn-block w-100">
                                <i class="fas fa-plus"></i> Tambah Motor
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('transaksi.create') }}" class="btn btn-success btn-block w-100">
                                <i class="fas fa-plus"></i> Buat Transaksi
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('pengembalian.create') }}" class="btn btn-warning btn-block w-100">
                                <i class="fas fa-plus"></i> Catat Pengembalian
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.create') }}" class="btn btn-info btn-block w-100">
                                <i class="fas fa-plus"></i> Tambah Admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-list"></i> Informasi Sistem
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Tentang Aplikasi</h5>
                            <p>Aplikasi Rental Motor adalah sistem manajemen penyewaan kendaraan bermotor yang dirancang untuk memudahkan pengelolaan data motor, transaksi, dan pengembalian kendaraan.</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Fitur Utama</h5>
                            <ul>
                                <li>Manajemen data motor</li>
                                <li>Manajemen transaksi sewa</li>
                                <li>Pencatatan pengembalian</li>
                                <li>Laporan dan statistik</li>
                                <li>Manajemen admin</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
