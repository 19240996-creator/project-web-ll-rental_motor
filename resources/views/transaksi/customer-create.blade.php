@extends('layouts.app')

@section('title', 'Pesan Motor - Rental Motor')

@section('content')
<style>
    .booking-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .motor-preview {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        border-left: 5px solid #667eea;
    }

    .motor-preview-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .motor-preview-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .motor-preview-icon {
        font-size: 32px;
        margin-right: 20px;
    }

    .motor-preview-info h5 {
        margin: 0;
        font-weight: bold;
        color: #333;
    }

    .motor-preview-info small {
        color: #666;
    }

    .booking-form {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    }

    .form-section {
        margin-bottom: 25px;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .form-section h6 {
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #667eea;
    }

    .price-breakdown {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-top: 20px;
        border-left: 4px solid #667eea;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .price-row:last-child {
        margin-bottom: 0;
        padding-top: 10px;
        border-top: 2px solid #ddd;
        font-weight: bold;
        font-size: 16px;
        color: #667eea;
    }

    .btn-book {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: bold;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-book:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-cancel {
        background: #6c757d;
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: bold;
        width: 100%;
        margin-top: 10px;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #5a6268;
        color: white;
    }

    .info-alert {
        background: #e7f3ff;
        border-left: 4px solid #2196F3;
        padding: 15px;
        border-radius: 5px;
        margin-top: 20px;
    }

    .info-alert i {
        color: #2196F3;
        margin-right: 10px;
    }
</style>

<div class="container-fluid">
    <div class="booking-header">
        <h1 class="h3 mb-0">
            <i class="fas fa-shopping-cart"></i> Pemesanan Motor
        </h1>
        <p class="mb-0 mt-2">Isi detail pemesanan Anda dengan lengkap dan benar</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="booking-form">
                <form action="{{ route('transaksi.store') }}" method="POST" id="bookingForm">
                    @csrf

                    {{-- Motor Section --}}
                    <div class="form-section">
                        <h6><i class="fas fa-motorcycle"></i> Pilih Motor</h6>
                        
                        @if($motor)
                            {{-- Motor already selected --}}
                            <input type="hidden" name="Id_motor" value="{{ $motor->Id_motor }}" id="Id_motor">
                            <div class="alert alert-info">
                                <i class="fas fa-check-circle"></i>
                                <strong>Motor Dipilih:</strong> {{ $motor->Merk_motor }} - {{ $motor->Warna_motor }}
                            </div>
                        @else
                            {{-- Motor selection dropdown --}}
                            <div class="form-group mb-3">
                                <select class="form-select @error('Id_motor') is-invalid @enderror" 
                                        id="Id_motor" name="Id_motor" required onchange="updateMotorInfo()">
                                    <option value="">-- Pilih Motor --</option>
                                    @foreach($motors as $m)
                                        <option value="{{ $m->Id_motor }}" data-price="{{ $m->Harga }}">
                                            {{ $m->Merk_motor }} - {{ $m->Warna_motor }} 
                                            (Rp {{ number_format($m->Harga, 0, ',', '.') }}/hari)
                                        </option>
                                    @endforeach
                                </select>
                                @error('Id_motor')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                    </div>

                    {{-- Dates Section --}}
                    <div class="form-section">
                        <h6><i class="fas fa-calendar-alt"></i> Tanggal Pemesanan</h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="Tanggal_sewa" class="form-label">
                                        <i class="fas fa-play-circle text-success"></i> Tanggal Mulai Sewa
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('Tanggal_sewa') is-invalid @enderror" 
                                           id="Tanggal_sewa" name="Tanggal_sewa" 
                                           min="{{ date('Y-m-d') }}"
                                           required 
                                           onchange="calculatePrice()">
                                    <small class="form-text text-muted">Tanggal mulai sewa motor</small>
                                    @error('Tanggal_sewa')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="Tanggal_kembali" class="form-label">
                                        <i class="fas fa-stop-circle text-danger"></i> Tanggal Kembali
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('Tanggal_kembali') is-invalid @enderror" 
                                           id="Tanggal_kembali" name="Tanggal_kembali" 
                                           required 
                                           onchange="calculatePrice()">
                                    <small class="form-text text-muted">Tanggal mengembalikan motor</small>
                                    @error('Tanggal_kembali')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Price Breakdown --}}
                    <div class="price-breakdown" id="priceBreakdown">
                        <div class="price-row">
                            <span>Harga Per Hari:</span>
                            <span id="hargaPerHari">-</span>
                        </div>
                        <div class="price-row">
                            <span>Jumlah Hari:</span>
                            <span id="jumlahHari">-</span>
                        </div>
                        <div class="price-row">
                            <span>Total Biaya:</span>
                            <span id="totalBiaya">-</span>
                        </div>
                    </div>

                    {{-- Payment Method Section --}}
                    <div class="form-section">
                        <h6><i class="fas fa-credit-card"></i> Metode Pembayaran</h6>
                        
                        <div class="form-group mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="radio" name="metode_pembayaran" id="cash" value="cash" class="form-check-input" required onchange="togglePaymentOptions()">
                                    <label for="cash" class="form-check-label" style="cursor: pointer; display: flex; align-items: center; padding: 12px; border: 2px solid #ddd; border-radius: 8px; background: white;">
                                        <i class="fas fa-money-bill" style="font-size: 24px; margin-right: 12px; color: #28a745;"></i>
                                        <div>
                                            <strong>Cash</strong>
                                            <small class="d-block" style="color: #666;">Bayar saat pengambilan</small>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="col-md-6">
                                    <input type="radio" name="metode_pembayaran" id="qr" value="qr" class="form-check-input" required onchange="togglePaymentOptions()">
                                    <label for="qr" class="form-check-label" style="cursor: pointer; display: flex; align-items: center; padding: 12px; border: 2px solid #ddd; border-radius: 8px; background: white;">
                                        <i class="fas fa-qrcode" style="font-size: 24px; margin-right: 12px; color: #667eea;"></i>
                                        <div>
                                            <strong>QR Code</strong>
                                            <small class="d-block" style="color: #666;">Scan & bayar</small>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="col-md-6">
                                    <input type="radio" name="metode_pembayaran" id="bank" value="bank" class="form-check-input" required onchange="togglePaymentOptions()">
                                    <label for="bank" class="form-check-label" style="cursor: pointer; display: flex; align-items: center; padding: 12px; border: 2px solid #ddd; border-radius: 8px; background: white;">
                                        <i class="fas fa-university" style="font-size: 24px; margin-right: 12px; color: #ff6b35;"></i>
                                        <div>
                                            <strong>Transfer Bank</strong>
                                            <small class="d-block" style="color: #666;">Transfer ke rekening</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @error('metode_pembayaran')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bank Selection (shown only when bank transfer is selected) -->
                        <div id="bankOptions" style="display: none; margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                            <h6><i class="fas fa-bank"></i> Pilih Bank Tujuan Transfer</h6>
                            <div class="form-group">
                                <select class="form-select" id="bank_tujuan" name="bank_tujuan" onchange="showBankDetails()">
                                    <option value="">-- Pilih Bank --</option>
                                    <option value="BCA">🏦 BCA (Bank Central Asia)</option>
                                    <option value="Mandiri">🏦 Mandiri (Bank Mandiri)</option>
                                    <option value="BRI">🏦 BRI (Bank Rakyat Indonesia)</option>
                                    <option value="BNI">🏦 BNI (Bank Negara Indonesia)</option>
                                    <option value="Lainnya">🏦 Bank Lainnya</option>
                                </select>
                                <small class="form-text text-muted">Pilih bank untuk instruksi transfer yang akan diberikan admin</small>
                            </div>

                            <!-- Bank Account Details -->
                            <div id="bankDetails" style="display: none; margin-top: 15px; padding: 15px; background: white; border-radius: 8px; border-left: 4px solid #667eea;">
                                <h6 style="margin-bottom: 10px;"><i class="fas fa-credit-card"></i> Detail Rekening</h6>
                                <div class="detail-row" style="display: grid; gap: 10px;">
                                    <div style="padding: 10px; background: #f0f4ff; border-radius: 6px;">
                                        <small style="color: #666; display: block; margin-bottom: 5px;">Nama Bank</small>
                                        <strong id="bankName" style="font-size: 16px;">-</strong>
                                    </div>
                                    <div style="padding: 10px; background: #f0f4ff; border-radius: 6px;">
                                        <small style="color: #666; display: block; margin-bottom: 5px;"><i class="fas fa-user"></i> Atas Nama</small>
                                        <strong style="font-size: 16px;">PT. GO-JAG Rental Motor</strong>
                                    </div>
                                    <div style="padding: 10px; background: #f0f4ff; border-radius: 6px;">
                                        <small style="color: #666; display: block; margin-bottom: 5px;"><i class="fas fa-hashtag"></i> Nomor Rekening</small>
                                        <strong id="bankAccount" style="font-size: 18px; color: #667eea; font-family: monospace; letter-spacing: 2px;">-</strong>
                                    </div>
                                </div>
                                <div style="margin-top: 15px; padding: 12px; background: #e8f5e9; border-radius: 6px; border-left: 4px solid #28a745;">
                                    <small><i class="fas fa-info-circle text-success"></i> Kirimkan bukti transfer ke admin untuk verifikasi</small>
                                </div>
                            </div>
                        </div>

                        <!-- QR Code Display (shown only when QR is selected) -->
                        <div id="qrOptions" style="display: none; margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                            <h6><i class="fas fa-qrcode"></i> Kode QR untuk Pembayaran</h6>
                            <div style="text-align: center; padding: 20px;">
                                <div id="qrCodeContainer" style="display: inline-block; padding: 15px; background: white; border-radius: 8px; border: 2px solid #ddd;">
                                    <img id="qrCodeImage" src="" alt="QR Code" style="max-width: 200px; height: auto;" />
                                </div>
                            </div>
                            <small class="form-text text-muted text-center d-block">
                                <i class="fas fa-info-circle"></i> Scan QR code ini dengan e-wallet Anda untuk membayar
                            </small>
                        </div>
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="form-section" style="margin-top: 30px;">
                        <button type="submit" class="btn btn-book">
                            <i class="fas fa-check-circle"></i> Konfirmasi Pemesanan
                        </button>
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-cancel">
                            <i class="fas fa-times-circle"></i> Batal
                        </a>
                    </div>

                    {{-- Info Alert --}}
                    <div class="info-alert">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong> Pemesanan Anda akan diverifikasi oleh admin dalam 24 jam. 
                        Pastikan data Anda sudah lengkap di profile.
                    </div>
                </form>
            </div>
        </div>

        {{-- Motor Info Sidebar --}}
        <div class="col-lg-4">
            @if($motor)
                <div class="motor-preview">
                    <div style="font-size: 48px; text-align: center; margin-bottom: 20px;">
                        🏍️
                    </div>
                    
                    <div class="motor-preview-item">
                        <div class="motor-preview-info w-100">
                            <h5>{{ $motor->Merk_motor }}</h5>
                            <small>Merk Motor</small>
                        </div>
                    </div>

                    <div class="motor-preview-item">
                        <div class="motor-preview-info w-100">
                            <h5>{{ $motor->Warna_motor }}</h5>
                            <small>Warna</small>
                        </div>
                    </div>

                    <div class="motor-preview-item">
                        <div class="motor-preview-info w-100">
                            <h5>{{ $motor->Plat_nomor ?? 'N/A' }}</h5>
                            <small>Plat Nomor</small>
                        </div>
                    </div>

                    <div class="motor-preview-item">
                        <div class="motor-preview-info w-100">
                            <h5 class="text-success">Rp {{ number_format($motor->Harga, 0, ',', '.') }}/Hari</h5>
                            <small>Harga Sewa</small>
                        </div>
                    </div>

                    <div style="margin-top: 20px; padding-top: 20px; border-top: 2px solid #eee;">
                        <span class="badge bg-success" style="font-size: 14px; padding: 8px 12px;">
                            <i class="fas fa-check-circle"></i> Tersedia
                        </span>
                    </div>
                </div>
            @else
                <div class="motor-preview">
                    <div style="text-align: center; color: #999;">
                        <i class="fas fa-motorcycle" style="font-size: 48px;"></i>
                        <p class="mt-3 mb-0"><strong>Pilih motor terlebih dahulu</strong></p>
                        <small>untuk melihat detail informasi</small>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function calculatePrice() {
    const motorSelect = document.getElementById('Id_motor');
    const tanggalSewa = document.getElementById('Tanggal_sewa').value;
    const tanggalKembali = document.getElementById('Tanggal_kembali').value;
    
    if (!motorSelect.value || !tanggalSewa || !tanggalKembali) {
        return;
    }
    
    const hargaPerHari = parseInt(motorSelect.options[motorSelect.selectedIndex].dataset.price) || 0;
    const startDate = new Date(tanggalSewa);
    const endDate = new Date(tanggalKembali);
    
    const timeDiff = endDate - startDate;
    const days = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
    
    if (days < 1) {
        document.getElementById('jumlahHari').textContent = 'Invalid';
        document.getElementById('totalBiaya').textContent = 'Invalid';
        return;
    }
    
    const totalBiaya = hargaPerHari * days;
    
    document.getElementById('hargaPerHari').textContent = 'Rp ' + hargaPerHari.toLocaleString('id-ID');
    document.getElementById('jumlahHari').textContent = days + ' hari';
    document.getElementById('totalBiaya').textContent = 'Rp ' + totalBiaya.toLocaleString('id-ID');
}

function updateMotorInfo() {
    calculatePrice();
}

function togglePaymentOptions() {
    const cashRadio = document.getElementById('cash');
    const qrRadio = document.getElementById('qr');
    const bankRadio = document.getElementById('bank');
    
    const bankOptions = document.getElementById('bankOptions');
    const qrOptions = document.getElementById('qrOptions');
    
    // Hide all options first
    bankOptions.style.display = 'none';
    qrOptions.style.display = 'none';
    
    // Show selected option
    if (bankRadio.checked) {
        bankOptions.style.display = 'block';
    } else if (qrRadio.checked) {
        qrOptions.style.display = 'block';
        generateQRCode();
    }
}

function showBankDetails() {
    const bankSelect = document.getElementById('bank_tujuan');
    const bankDetails = document.getElementById('bankDetails');
    const bankName = document.getElementById('bankName');
    const bankAccount = document.getElementById('bankAccount');
    
    const accountNumber = '1730017287724'; // Nomor rekening utama
    
    const bankInfo = {
        'BCA': 'BCA (Bank Central Asia)',
        'Mandiri': 'Mandiri (Bank Mandiri)',
        'BRI': 'BRI (Bank Rakyat Indonesia)',
        'BNI': 'BNI (Bank Negara Indonesia)',
        'Lainnya': 'Bank Lainnya'
    };
    
    if (bankSelect.value) {
        bankName.textContent = bankInfo[bankSelect.value] || '-';
        bankAccount.textContent = accountNumber;
        bankDetails.style.display = 'block';
    } else {
        bankDetails.style.display = 'none';
    }
}

function generateQRCode() {
    // Generate QR code dengan dummy data (di production, ini bisa berisi info transaksi)
    const qrText = 'https://payment.rental-motor.test?amount=100000&ref=TRX-' + Math.random().toString(36).substring(7);
    
    // Menggunakan QR code API dari qr-server.com
    const qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' + encodeURIComponent(qrText);
    
    const qrCodeImage = document.getElementById('qrCodeImage');
    qrCodeImage.src = qrCodeUrl;
}

// Load initial price if motor is pre-selected
document.addEventListener('DOMContentLoaded', function() {
    @if($motor)
        document.getElementById('hargaPerHari').textContent = 'Rp {{ number_format($motor->Harga, 0, ',', '.') }}';
    @endif
    calculatePrice();
});

// Form validation
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    const tanggalSewa = document.getElementById('Tanggal_sewa').value;
    const tanggalKembali = document.getElementById('Tanggal_kembali').value;
    const bankRadio = document.getElementById('bank');
    const bankSelect = document.getElementById('bank_tujuan');
    
    if (!tanggalSewa || !tanggalKembali) {
        e.preventDefault();
        alert('Pilih tanggal sewa dan kembali terlebih dahulu!');
        return;
    }
    
    const startDate = new Date(tanggalSewa);
    const endDate = new Date(tanggalKembali);
    
    if (endDate < startDate) {
        e.preventDefault();
        alert('Tanggal kembali harus sama atau lebih besar dari tanggal sewa!');
        return;
    }

    // Validasi bank selection jika memilih transfer bank
    if (bankRadio.checked && !bankSelect.value) {
        e.preventDefault();
        alert('Pilih bank tujuan transfer terlebih dahulu!');
        return;
    }
});
</script>
@endsection
