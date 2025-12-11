@extends('layouts.app')

@section('title', 'Login Customer - Rental Motor')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        min-height: 100vh !important;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .login-card {
        width: 100%;
        max-width: 450px;
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

    .login-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px 30px 20px 30px;
        text-align: center;
        color: white;
        display: none;
    }

    .login-header i {
        font-size: 50px;
        margin-bottom: 15px;
        display: block;
    }

    .login-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: bold;
    }

    .login-header p {
        margin: 10px 0 0 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .login-body {
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

    .form-check {
        margin-bottom: 25px;
        display: flex;
        align-items: center;
    }

    .form-check-input {
        width: 20px;
        height: 20px;
        margin: 0;
        padding: 0;
        border: 2px solid #d1d5db;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
        appearance: none;
        -webkit-appearance: none;
    }

    .form-check-input:hover {
        border-color: #667eea;
    }

    .form-check-input:checked {
        background: #667eea;
        border-color: #667eea;
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: center;
        background-size: 100% 100%;
    }

    .form-check-label {
        color: #333;
        font-size: 14px;
        cursor: pointer;
        margin-left: 10px;
        margin-bottom: 0;
        font-weight: 500;
    }

    .btn-login {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        width: 100%;
        font-size: 16px;
    }

    .btn-login:hover:not(.loading) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-login:active:not(.loading) {
        transform: translateY(0);
    }

    .btn-login:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .btn-login.loading .spinner-border {
        display: inline-block;
        width: 14px;
        height: 14px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin-right: 8px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .login-footer {
        padding: 25px 40px;
        background: #f8f9fa;
        text-align: center;
        border-top: 1px solid #e9ecef;
    }

    .login-footer p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }

    .login-footer a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .login-footer a:hover {
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

<div class="login-wrapper">
    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-motorcycle"></i>
            <h2>Rental Motor</h2>
            <p>Masuk ke akun Anda</p>
        </div>

        <div class="login-body">
            <h3 style="text-align: center; margin-bottom: 30px; color: #333;">
                <i class="fas fa-user"></i> Login Customer
            </h3>
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div style="margin-bottom: 10px;">
                        <i class="fas fa-exclamation-circle"></i> <strong>Login Gagal!</strong>
                    </div>
                    <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('customer.login.post') }}" method="POST" novalidate id="loginForm">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope" style="color: #667eea; margin-right: 8px;"></i>Email Address
                    </label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="masukkan@email.com"
                           required 
                           autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock" style="color: #667eea; margin-right: 8px;"></i>Password
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
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember" value="on">
                    <label class="form-check-label" for="remember">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <button type="submit" class="btn btn-login w-100">
                    <i class="fas fa-sign-in-alt"></i> Login Sekarang
                </button>
            </form>
        </div>

        <div class="login-footer">
            <p>Belum punya akun? 
                <a href="{{ route('register') }}">Daftar di sini</a>
            </p>
            <p style="margin-top: 15px; border-top: 1px solid #ddd; padding-top: 15px;">
                <a href="{{ route('login') }}">Login sebagai Admin?</a>
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

    // Form submit loading state
    document.getElementById('loginForm').addEventListener('submit', function() {
        const button = this.querySelector('.btn-login');
        button.disabled = true;
        button.classList.add('loading');
        button.innerHTML = '<span class="spinner-border"></span> Sedang Login...';
    });
</script>
@endsection
