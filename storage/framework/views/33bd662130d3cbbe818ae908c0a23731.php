<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Rental Motor'); ?> - Aplikasi Rental Motor</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                <i class="fas fa-motorcycle"></i> Rental Motor
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if(auth()->guard()->check()): ?>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(Auth::user()->role === 'admin' ? route('dashboard') : route('customer.dashboard')); ?>">
                                <i class="fas fa-chart-line"></i> Dashboard
                            </a>
                        </li>
                        
                        
                        <?php if(Auth::user()->role === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('motor.index')); ?>">
                                    <i class="fas fa-list"></i> Motor
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        
                        <?php if(Auth::user()->role === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('transaksi.index')); ?>">
                                    <i class="fas fa-receipt"></i> Transaksi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('pengembalian.index')); ?>">
                                    <i class="fas fa-undo"></i> Pengembalian
                                </a>
                            </li>
                        <?php else: ?>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('customer.transactions')); ?>">
                                    <i class="fas fa-history"></i> Riwayat Sewa
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?php echo e(Auth::user()->name); ?>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">
                                        <i class="fas fa-user-edit"></i> Edit Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register')); ?>">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="d-flex">
        <?php if(auth()->guard()->check()): ?>
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h5><i class="fas fa-bars"></i> Menu</h5>
            </div>
            <nav class="nav flex-column">
                
                <a class="nav-link <?php echo e(Route::is('dashboard', 'customer.dashboard') ? 'active' : ''); ?>" href="<?php echo e(Auth::user()->role === 'admin' ? route('dashboard') : route('customer.dashboard')); ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                
                
                <?php if(Auth::user()->role === 'admin'): ?>
                    <a class="nav-link <?php echo e(Route::is('motor.*') ? 'active' : ''); ?>" href="<?php echo e(route('motor.index')); ?>">
                        <i class="fas fa-motorcycle"></i> Motor
                    </a>
                <?php endif; ?>
                
                
                <?php if(Auth::user()->role === 'admin'): ?>
                    <a class="nav-link <?php echo e(Route::is('admin.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.index')); ?>">
                        <i class="fas fa-user-tie"></i> Data Admin
                    </a>
                    <a class="nav-link <?php echo e(Route::is('transaksi.*') ? 'active' : ''); ?>" href="<?php echo e(route('transaksi.index')); ?>">
                        <i class="fas fa-exchange-alt"></i> Transaksi
                    </a>
                    <a class="nav-link <?php echo e(Route::is('pengembalian.*') ? 'active' : ''); ?>" href="<?php echo e(route('pengembalian.index')); ?>">
                        <i class="fas fa-undo"></i> Pengembalian
                    </a>
                <?php else: ?>
                    
                    <a class="nav-link <?php echo e(Route::is('customer.transactions') ? 'active' : ''); ?>" href="<?php echo e(route('customer.transactions')); ?>">
                        <i class="fas fa-history"></i> Riwayat Sewa
                    </a>
                    <a class="nav-link <?php echo e(Route::is('transaksi.*') ? 'active' : ''); ?>" href="<?php echo e(route('transaksi.index')); ?>">
                        <i class="fas fa-motorcycle"></i> Motor yang Disewa
                    </a>
                <?php endif; ?>
            </nav>
        </div>
        <?php endif; ?>

        <!-- Main Content Area -->
        <div class="main-content w-100">
            <!-- Alerts -->
            <?php if($errors->any()): ?>
                <div class="alert alert-danger m-3">
                    <strong>Ups! Ada kesalahan:</strong>
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Page Content -->
            <div class="p-4">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container-fluid">
            <p>&copy; 2025 Website Rental Motor. All rights reserved. | Dibuat dengan <i class="fas fa-heart text-danger"></i> oleh Tim GO-JAG</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\PROJECT AKHIR WEB II\project-web-ll-rental_motor\resources\views/layouts/app.blade.php ENDPATH**/ ?>