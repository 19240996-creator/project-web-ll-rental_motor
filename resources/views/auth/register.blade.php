@extends('layouts.app')

@section('title', 'Daftar - Rental Motor')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        min-height: 100vh !important;
    }

    .register-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .register-card {
        width: 100%;
        max-width: 500px;
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .register-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px 30px 20px 30px;
        text-align: center;
        color: white;
        display: none;
    }

    .register-header i {
        font-size: 50px;
        margin-bottom: 15px;
        display: block;
    }

    .register-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: bold;
    }

    .register-header p {
        margin: 10px 0 0 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .register-body {
        background: white;
        padding: 40px;
    }

    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .form-control {
        border: 2px solid #e9ecef;
        padding: 12px 16px;
        padding-right: 45px;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #f8f9fa;
        width: 100%;
    }

    .form-control:focus {
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .form-control::placeholder {
        color: #999;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        background: #fff5f5;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
    }

    .form-control.is-valid {
        border-color: #667eea;
        background: #f0f4ff;
    }

    .form-control.is-valid:focus {
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #999;
        background: none;
        border: none;
        font-size: 18px;
        transition: all 0.3s ease;
        padding: 8px 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .password-toggle:hover {
        color: #667eea;
        transform: translateY(-50%) scale(1.1);
    }

    .password-toggle:active {
        transform: translateY(-50%) scale(0.95);
    }

    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    @media (max-width: 576px) {
        .form-row-2 {
            grid-template-columns: 1fr;
        }
    }

    .password-strength {
        margin-top: 8px;
        height: 4px;
        background: #e9ecef;
        border-radius: 2px;
        overflow: hidden;
    }

    .password-strength-bar {
        height: 100%;
        width: 0;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .password-strength-bar.weak {
        width: 33%;
        background: #dc3545;
    }

    .password-strength-bar.medium {
        width: 66%;
        background: #ffc107;
    }

    .password-strength-bar.strong {
        width: 100%;
        background: #198754;
    }

    .password-strength-text {
        font-size: 12px;
        margin-top: 5px;
        font-weight: 600;
    }

    .password-strength-text.weak {
        color: #dc3545;
    }

    .password-strength-text.medium {
        color: #ffc107;
    }

    .password-strength-text.strong {
        color: #198754;
    }

    .match-indicator {
        position: absolute;
        right: 15px;
        top: 42px;
        font-size: 16px;
    }

    .match-indicator.matched {
        color: #198754;
    }

    .match-indicator.not-matched {
        color: #dc3545;
    }

    .password-info {
        background: #f8f9fa;
        border-left: 4px solid #667eea;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        font-size: 13px;
    }

    .password-info strong {
        color: #667eea;
    }

    .password-info ul {
        margin: 8px 0 0 0;
        padding-left: 18px;
    }

    .password-info li {
        margin-bottom: 5px;
        color: #666;
    }

    .btn-register {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 14px 20px;
        font-weight: 600;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s ease;
        color: white;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(245, 87, 108, 0.4);
        color: white;
    }

    .btn-register:active {
        transform: translateY(0);
    }

    .btn-register:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .btn-register .spinner-border {
        display: none;
        margin-right: 8px;
    }

    .btn-register.loading .spinner-border {
        display: inline-block;
        width: 14px;
        height: 14px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .register-footer {
        padding: 25px 40px;
        background: #f8f9fa;
        text-align: center;
        border-top: 1px solid #e9ecef;
    }

    .register-footer p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }

    .register-footer a {
        color: #764ba2;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .register-footer a:hover {
        text-decoration: underline;
    }

    .alert {
        border-radius: 10px;
        border: none;
        margin-bottom: 25px;
        animation: slideDown 0.4s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 12px;
        margin-top: 8px;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .alert-danger .btn-close {
        filter: invert(0.5);
    }

    /* Hide navbar dan main layout elements */
    .navbar {
        display: none !important;
    }

    .sidebar {
        display: none !important;
    }

    .d-flex {
        display: block !important;
    }

    .container {
        margin: 0 !important;
        padding: 0 !important;
    }
</style>

<div class="register-wrapper">
    <div class="register-card">
        <div class="register-header">
            <i class="fas fa-motorcycle"></i>
            <h2>Daftar Akun</h2>
            <p>Bergabunglah dengan layanan rental motor kami</p>
        </div>

        <div class="register-body">
            <h3 style="text-align: center; margin-bottom: 30px; color: #333;">
                <i class="fas fa-user"></i> Daftar Sebagai Customer
            </h3>
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div style="margin-bottom: 10px;">
                        <i class="fas fa-exclamation-circle"></i> <strong>Registrasi Gagal!</strong>
                    </div>
                    <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" novalidate id="registerForm">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">
                        <span><i class="fas fa-user" style="color: #667eea; margin-right: 8px;"></i>Nama Lengkap</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="Masukkan nama lengkap"
                           required 
                           autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">
                        <span><i class="fas fa-envelope" style="color: #667eea; margin-right: 8px;"></i>Email Address</span>
                    </label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="masukkan@email.com"
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <span><i class="fas fa-lock" style="color: #667eea; margin-right: 8px;"></i>Password</span>
                        </label>
                        <div style="position: relative;">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="••••••••"
                                   required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength" id="passwordStrength">
                            <div class="password-strength-bar"></div>
                        </div>
                        <div class="password-strength-text" id="passwordStrengthText"></div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <span><i class="fas fa-lock" style="color: #667eea; margin-right: 8px;"></i>Konfirmasi</span>
                        </label>
                        <div style="position: relative;">
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="••••••••"
                                   required>
                            <button type="button" class="password-toggle" id="togglePasswordConfirm">
                                <i class="fas fa-eye"></i>
                            </button>
                            <span class="match-indicator" id="matchIndicator"></span>
                        </div>
                    </div>
                </div>

                <div class="password-info">
                    <strong><i class="fas fa-info-circle"></i> Persyaratan Password:</strong>
                    <ul>
                        <li>✓ Minimal 8 karakter</li>
                        <li>✓ Kombinasi huruf besar dan kecil</li>
                        <li>✓ Harus sama dengan konfirmasi password</li>
                    </ul>
                </div>

                <button type="submit" class="btn btn-register w-100">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </button>
            </form>
        </div>

        <div class="register-footer">
            <p>Sudah punya akun? 
                <a href="{{ route('customer.login') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">Login di sini</a>
            </p>
        </div>
    </div>
</div>

<script>
    // Password visibility toggle
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
        const passwordInput = document.getElementById('password_confirmation');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Password strength indicator
    function checkPasswordStrength(password) {
        let strength = 0;
        
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;
        
        return strength;
    }

    document.getElementById('password').addEventListener('input', function() {
        const strength = checkPasswordStrength(this.value);
        const strengthBar = document.querySelector('.password-strength-bar');
        const strengthText = document.getElementById('passwordStrengthText');
        
        if (this.value.length === 0) {
            strengthBar.className = 'password-strength-bar';
            strengthText.textContent = '';
        } else if (strength < 2) {
            strengthBar.className = 'password-strength-bar weak';
            strengthText.className = 'password-strength-text weak';
            strengthText.textContent = 'Kekuatan: Lemah';
        } else if (strength < 3) {
            strengthBar.className = 'password-strength-bar medium';
            strengthText.className = 'password-strength-text medium';
            strengthText.textContent = 'Kekuatan: Sedang';
        } else {
            strengthBar.className = 'password-strength-bar strong';
            strengthText.className = 'password-strength-text strong';
            strengthText.textContent = 'Kekuatan: Kuat';
        }
        
        checkPasswordMatch();
    });

    // Password match checker
    function checkPasswordMatch() {
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;
        const matchIndicator = document.getElementById('matchIndicator');
        
        if (passwordConfirm.length === 0) {
            matchIndicator.innerHTML = '';
            return;
        }
        
        if (password === passwordConfirm) {
            matchIndicator.className = 'match-indicator matched';
            matchIndicator.innerHTML = '<i class="fas fa-check-circle"></i>';
        } else {
            matchIndicator.className = 'match-indicator not-matched';
            matchIndicator.innerHTML = '<i class="fas fa-times-circle"></i>';
        }
    }

    document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);

    // Form submit loading state
    document.getElementById('registerForm').addEventListener('submit', function() {
        const button = this.querySelector('.btn-register');
        button.disabled = true;
        button.classList.add('loading');
        button.innerHTML = '<span class="spinner-border"></span> Sedang Mendaftar...';
    });
</script>
@endsection
