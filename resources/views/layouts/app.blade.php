<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Rental Motor') - Aplikasi Rental Motor</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-motorcycle"></i> Rental Motor
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        {{-- Dashboard accessible to both --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ Auth::user()->role === 'admin' ? route('dashboard') : route('customer.dashboard') }}">
                                <i class="fas fa-chart-line"></i> Dashboard
                            </a>
                        </li>
                        
                        {{-- Motor list - admin only --}}
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('motor.index') }}">
                                    <i class="fas fa-list"></i> Motor
                                </a>
                            </li>
                        @endif
                        
                        {{-- Admin only menu --}}
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('transaksi.index') }}">
                                    <i class="fas fa-receipt"></i> Transaksi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengembalian.index') }}">
                                    <i class="fas fa-undo"></i> Pengembalian
                                </a>
                            </li>
                        @else
                            {{-- Customer only menu --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('customer.transactions') }}">
                                    <i class="fas fa-history"></i> Riwayat Sewa
                                </a>
                            </li>
                        @endif
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-edit"></i> Edit Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="d-flex">
        @auth
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h5><i class="fas fa-bars"></i> Menu</h5>
            </div>
            <nav class="nav flex-column">
                {{-- Dashboard for both roles --}}
                <a class="nav-link {{ Route::is('dashboard', 'customer.dashboard') ? 'active' : '' }}" href="{{ Auth::user()->role === 'admin' ? route('dashboard') : route('customer.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                
                {{-- Motor untuk admin only --}}
                @if(Auth::user()->role === 'admin')
                    <a class="nav-link {{ Route::is('motor.*') ? 'active' : '' }}" href="{{ route('motor.index') }}">
                        <i class="fas fa-motorcycle"></i> Motor
                    </a>
                @endif
                
                {{-- Admin only menu --}}
                @if(Auth::user()->role === 'admin')
                    <a class="nav-link {{ Route::is('admin.*') ? 'active' : '' }}" href="{{ route('admin.index') }}">
                        <i class="fas fa-user-tie"></i> Data Admin
                    </a>
                    <a class="nav-link {{ Route::is('transaksi.*') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
                        <i class="fas fa-exchange-alt"></i> Transaksi
                    </a>
                    <a class="nav-link {{ Route::is('pengembalian.*') ? 'active' : '' }}" href="{{ route('pengembalian.index') }}">
                        <i class="fas fa-undo"></i> Pengembalian
                    </a>
                @else
                    {{-- Customer only menu --}}
                    <a class="nav-link {{ Route::is('customer.transactions') ? 'active' : '' }}" href="{{ route('customer.transactions') }}">
                        <i class="fas fa-history"></i> Riwayat Sewa
                    </a>
                @endif
            </nav>
        </div>
        @endauth

        <!-- Main Content Area -->
        <div class="main-content w-100">
            <!-- Alerts -->
            @if ($errors->any())
                <div class="alert alert-danger m-3">
                    <strong>Ups! Ada kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page Content -->
            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container-fluid">
            <p>&copy; 2024 Aplikasi Rental Motor. All rights reserved. | Dibuat dengan <i class="fas fa-heart text-danger"></i> oleh Tim Developer</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('scripts')
</body>
</html>
