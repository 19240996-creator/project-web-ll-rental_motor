@extends('layouts.app')

@section('title', 'Detail Booking - Rental Motor')

@section('content')
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
        <p class="mb-0 mt-2">ID: {{ $transaksi->Id_transaksi }}</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            {{-- Status --}}
            <div class="detail-card">
                <h5 class="detail-card-title">
                    <i class="fas fa-info-circle"></i> Status Pemesanan
                </h5>
                <span class="badge status-{{ strtolower(str_replace(' ', '_', $transaksi->Status_sewa)) }}">
                    {{ ucfirst($transaksi->Status_sewa) }}
                </span>
            </div>

            {{-- Motor Info --}}
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
                                <div class="detail-value">{{ $transaksi->motor->Merk_motor }}</div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-label">Warna</div>
                                <div class="detail-value">{{ $transaksi->motor->Warna_motor }}</div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-label">Plat Nomor</div>
                                <div class="detail-value">{{ $transaksi->motor->Plat_nomor ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-group">
                                <div class="detail-label">Harga/Hari</div>
                                <div class="detail-value text-success">Rp {{ number_format($transaksi->motor->Harga, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dates and Pricing --}}
            <div class="detail-card">
                <h5 class="detail-card-title">
                    <i class="fas fa-calendar-alt"></i> Tanggal & Harga
                </h5>
                <div class="detail-row">
                    <div class="detail-group">
                        <div class="detail-label">Tanggal Mulai Sewa</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($transaksi->Tanggal_sewa)->format('d M Y') }}</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Tanggal Kembali</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($transaksi->Tanggal_kembali)->format('d M Y') }}</div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Durasi Sewa</div>
                        <div class="detail-value">
                            {{ \Carbon\Carbon::parse($transaksi->Tanggal_kembali)->diffInDays(\Carbon\Carbon::parse($transaksi->Tanggal_sewa)) + 1 }} Hari
                        </div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Total Biaya</div>
                        <div class="detail-value text-primary">Rp {{ number_format($transaksi->Total_biaya, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            {{-- Pengembalian Info --}}
            @if($transaksi->pengembalian)
                <div class="detail-card">
                    <h5 class="detail-card-title">
                        <i class="fas fa-undo"></i> Informasi Pengembalian
                    </h5>
                    <div class="detail-row">
                        <div class="detail-group">
                            <div class="detail-label">Tanggal Pengembalian Rencana</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($transaksi->Tanggal_kembali)->format('d M Y') }}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Tanggal Pengembalian Aktual</div>
                            <div class="detail-value">
                                @if($transaksi->pengembalian->Tanggal_kembali_sebenarnya)
                                    {{ \Carbon\Carbon::parse($transaksi->pengembalian->Tanggal_kembali_sebenarnya)->format('d M Y') }}
                                @else
                                    <span class="text-muted">Belum dikembalikan</span>
                                @endif
                            </div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Status Pengembalian</div>
                            <div class="detail-value">{{ ucfirst($transaksi->pengembalian->Status_pengembalian ?? 'Diproses') }}</div>
                        </div>
                    </div>

                    {{-- Denda if any --}}
                    @php
                        $denda = 0;
                        if ($transaksi->pengembalian->Tanggal_kembali_sebenarnya) {
                            $actualDate = \Carbon\Carbon::parse($transaksi->pengembalian->Tanggal_kembali_sebenarnya);
                            $plannedDate = \Carbon\Carbon::parse($transaksi->Tanggal_kembali);
                            if ($actualDate->greaterThan($plannedDate)) {
                                $daysLate = $actualDate->diffInDays($plannedDate);
                                $denda = $daysLate * $transaksi->motor->Harga;
                            }
                        }
                    @endphp

                    @if($denda > 0)
                        <div class="denda-alert" style="margin-top: 15px;">
                            <h6 style="margin-bottom: 10px;">
                                <i class="fas fa-exclamation-triangle"></i> Denda Keterlambatan
                            </h6>
                            <div style="margin-bottom: 10px;">
                                <strong>Terlambat:</strong> 
                                @php
                                    $daysLate = \Carbon\Carbon::parse($transaksi->pengembalian->Tanggal_kembali_sebenarnya)->diffInDays(\Carbon\Carbon::parse($transaksi->Tanggal_kembali));
                                @endphp
                                {{ $daysLate }} hari
                            </div>
                            <div style="margin-bottom: 10px;">
                                <strong>Harga/Hari:</strong> Rp {{ number_format($transaksi->motor->Harga, 0, ',', '.') }}
                            </div>
                            <div style="font-size: 18px; font-weight: bold; color: #dc3545;">
                                Total Denda: Rp {{ number_format($denda, 0, ',', '.') }}
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Customer Info --}}
            <div class="detail-card">
                <h5 class="detail-card-title">
                    <i class="fas fa-user"></i> Informasi Penyewa
                </h5>
                <div class="detail-group mb-3">
                    <div class="detail-label">Nama</div>
                    <div class="detail-value">{{ $transaksi->user->name }}</div>
                </div>
                <div class="detail-group mb-3">
                    <div class="detail-label">Email</div>
                    <div class="detail-value" style="font-size: 14px;">{{ $transaksi->user->email }}</div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">No. Telepon</div>
                    <div class="detail-value">{{ $transaksi->user->no_telepon ?? 'N/A' }}</div>
                </div>
            </div>

            {{-- Admin Info --}}
            @if($transaksi->admin)
                <div class="detail-card">
                    <h5 class="detail-card-title">
                        <i class="fas fa-user-tie"></i> Admin Penangani
                    </h5>
                    <div class="detail-group">
                        <div class="detail-label">Nama Admin</div>
                        <div class="detail-value">{{ $transaksi->admin->Nama_admin ?? 'N/A' }}</div>
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="button-group">
                <a href="{{ Auth::user()->role === 'customer' ? route('transaksi.index') : route('transaksi.index') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
