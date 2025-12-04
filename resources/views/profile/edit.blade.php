@extends('layouts.app')

@section('title', 'Edit Profile - Rental Motor')

@section('content')
<style>
    .profile-container {
        min-height: 80vh;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .profile-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px;
        border-radius: 15px 15px 0 0;
        color: white;
    }

    .profile-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: bold;
    }

    .profile-body {
        padding: 40px;
    }

    .form-section {
        margin-bottom: 30px;
    }

    .form-section h4 {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #667eea;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .form-control {
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-update {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-delete {
        background: #dc3545;
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
    }

    .danger-zone {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 20px;
        border-radius: 8px;
        margin-top: 30px;
    }

    .danger-zone h4 {
        color: #856404;
        margin: 0 0 15px 0;
    }

    .danger-zone p {
        color: #856404;
        margin: 0 0 15px 0;
        font-size: 14px;
    }

    .grid-2col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .grid-2col {
            grid-template-columns: 1fr;
        }

        .profile-body {
            padding: 20px;
        }
    }

    .alert {
        border-radius: 8px;
        border: none;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 13px;
        margin-top: 5px;
    }
</style>

<div class="profile-container">
    <div class="container">
        <div class="profile-card">
            <div class="profile-header">
                <h2><i class="fas fa-user-circle"></i> Edit Profil</h2>
            </div>

            <div class="profile-body">
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> Profil berhasil diperbarui!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" novalidate>
                    @csrf
                    @method('PATCH')

                    <!-- Informasi Pribadi -->
                    <div class="form-section">
                        <h4><i class="fas fa-user"></i> Informasi Pribadi</h4>

                        <div class="grid-2col">
                            <div class="form-group">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Kontak & Alamat -->
                    <div class="form-section">
                        <h4><i class="fas fa-phone"></i> Kontak & Alamat</h4>

                        <div class="form-group">
                            <label for="no_telepon" class="form-label">Nomor Telepon</label>
                            <input type="tel" 
                                   class="form-control @error('no_telepon') is-invalid @enderror" 
                                   id="no_telepon" 
                                   name="no_telepon" 
                                   value="{{ old('no_telepon', $user->no_telepon) }}"
                                   placeholder="08xx-xxxx-xxxx">
                            @error('no_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" 
                                      name="alamat" 
                                      rows="3"
                                      placeholder="Masukkan alamat lengkap Anda">{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Identitas -->
                    <div class="form-section">
                        <h4><i class="fas fa-id-card"></i> Data Identitas</h4>

                        <div class="grid-2col">
                            <div class="form-group">
                                <label for="tipe_identitas" class="form-label">Tipe Identitas</label>
                                <select class="form-control @error('tipe_identitas') is-invalid @enderror" 
                                        id="tipe_identitas" 
                                        name="tipe_identitas">
                                    <option value="">-- Pilih Tipe Identitas --</option>
                                    <option value="KTP" {{ old('tipe_identitas', $user->tipe_identitas) === 'KTP' ? 'selected' : '' }}>KTP</option>
                                    <option value="SIM" {{ old('tipe_identitas', $user->tipe_identitas) === 'SIM' ? 'selected' : '' }}>SIM</option>
                                    <option value="Paspor" {{ old('tipe_identitas', $user->tipe_identitas) === 'Paspor' ? 'selected' : '' }}>Paspor</option>
                                </select>
                                @error('tipe_identitas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="no_identitas" class="form-label">Nomor Identitas</label>
                                <input type="text" 
                                       class="form-control @error('no_identitas') is-invalid @enderror" 
                                       id="no_identitas" 
                                       name="no_identitas" 
                                       value="{{ old('no_identitas', $user->no_identitas) }}"
                                       placeholder="Nomor KTP/SIM/Paspor">
                                @error('no_identitas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="d-flex gap-2 mt-30">
                        <button type="submit" class="btn btn-update">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>

                <!-- Danger Zone -->
                <div class="danger-zone">
                    <h4><i class="fas fa-exclamation-triangle"></i> Zona Berbahaya</h4>
                    <p>Setelah menghapus akun Anda, tidak ada jalan untuk memulihkan akun atau data yang terkandung di dalamnya.</p>
                    <button type="button" class="btn btn-delete" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="fas fa-trash"></i> Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Akun -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-warning"></i> Konfirmasi Penghapusan Akun</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan.</p>
                <form action="{{ route('profile.destroy') }}" method="POST" id="deleteForm" novalidate>
                    @csrf
                    @method('DELETE')

                    <div class="form-group">
                        <label for="password" class="form-label">Masukkan Password Anda untuk Konfirmasi</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger" form="deleteForm">
                    <i class="fas fa-trash"></i> Ya, Hapus Akun
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
