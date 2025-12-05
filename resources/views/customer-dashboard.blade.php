@extends('layouts.app')

@section('title', 'Dashboard Customer')

@section('content')
<style>
    .welcome-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 40px 30px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .welcome-section h1 {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .quick-actions {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 40px;
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
    }

    .action-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .motor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .motor-card {
        border: none;
        border-radius: 15px;
        padding: 25px;
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .motor-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }

    .motor-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .motor-icon {
        font-size: 48px;
        text-align: center;
        margin-bottom: 15px;
    }

    .motor-merk {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .motor-info {
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
    }

    .motor-harga {
        font-size: 16px;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 15px;
    }

    .motor-btn {
        display: inline-block;
        width: 100%;
        padding: 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-align: center;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .motor-btn:hover {
        transform: scale(1.05);
        color: white;
    }

    .info-section {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    }

    .info-section h5 {
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }
</style>

<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <h1><i class="fas fa-hand-wave"></i> Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p>Sewa motor berkualitas dengan harga terjangkau dan layanan terbaik</p>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h5><i class="fas fa-bolt"></i> Aksi Cepat</h5>
        <a href="#motor-list" class="action-btn action-btn-primary">
            <i class="fas fa-search"></i> Lihat Motor Tersedia
        </a>
        <a href="{{ route('transaksi.index') }}" class="action-btn action-btn-primary">
            <i class="fas fa-list"></i> Booking Saya
        </a>
        <a href="{{ route('profile.edit') }}" class="action-btn action-btn-primary">
            <i class="fas fa-user-edit"></i> Edit Profile
        </a>
    </div>

    <!-- Available Motors -->
    <div id="motor-list">
        <h3 style="margin-bottom: 20px; font-weight: bold; color: #333;">
            <i class="fas fa-motorcycle"></i> Motor Tersedia
        </h3>
        <div class="motor-grid">
            @forelse($motors as $motor)
                <div class="motor-card">
                    <div class="motor-icon">🏍️</div>
                    <div class="motor-merk">{{ $motor->Merk_motor }}</div>
                    <div class="motor-info">
                        <strong>Warna:</strong> {{ $motor->Warna_motor }}<br>
                        <strong>Plat:</strong> {{ $motor->Plat_nomor }}<br>
                        <strong>Status:</strong> 
                        <span class="badge bg-success">{{ $motor->Status_motor }}</span>
                    </div>
                    <div class="motor-harga">Rp {{ number_format($motor->Harga, 0, ',', '.') }}/Hari</div>
                    <a href="{{ route('transaksi.create', ['motor_id' => $motor->Id_motor]) }}" class="motor-btn">
                        <i class="fas fa-plus"></i> Pesan Sekarang
                    </a>
                </div>
            @empty
                <div class="alert alert-info w-100">
                    <i class="fas fa-info-circle"></i> Tidak ada motor yang tersedia saat ini
                </div>
            @endforelse
        </div>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <h5><i class="fas fa-info-circle"></i> Informasi Penting</h5>
        <ul style="margin-bottom: 0;">
            <li>Pastikan data identitas Anda sudah lengkap di profile</li>
            <li>Pilih motor yang sesuai dengan kebutuhan Anda</li>
            <li>Isi tanggal booking dengan benar untuk perhitungan biaya yang akurat</li>
            <li>Hubungi admin jika ada pertanyaan atau kendala</li>
        </ul>
    </div>
</div>
@endsection
