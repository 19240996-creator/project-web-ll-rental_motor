

<?php $__env->startSection('title', 'Beranda'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<div class="hero">
    <div class="hero-content">
        <h1><i class="fas fa-motorcycle"></i> Selamat Datang di Rental Motor</h1>
        <p>Layanan penyewaan motor terpercaya dengan harga terjangkau dan kualitas terbaik</p>
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-primary btn-lg">
                <i class="fas fa-chart-line"></i> Ke Dashboard
            </a>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="btn btn-primary btn-lg">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
            <a href="<?php echo e(route('register')); ?>" class="btn btn-secondary btn-lg ms-2">
                <i class="fas fa-user-plus"></i> Daftar
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Features Section -->
<div class="container my-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h2 class="mb-4"><i class="fas fa-star"></i> Keunggulan Kami</h2>
            <p class="lead text-muted">Kami menyediakan layanan rental motor terbaik dengan berbagai keunggulan</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-handshake fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Terpercaya</h5>
                    <p class="card-text">Layanan rental motor yang aman dan terpercaya dengan armada yang terawat dengan baik dan selalu siap operasional.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-dollar-sign fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Harga Terjangkau</h5>
                    <p class="card-text">Kami menawarkan harga yang sangat kompetitif dengan berbagai pilihan motor sesuai budget dan kebutuhan Anda.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-headset fa-3x text-info mb-3"></i>
                    <h5 class="card-title">Layanan 24/7</h5>
                    <p class="card-text">Tim layanan pelanggan kami siap membantu Anda kapan saja untuk memenuhi semua kebutuhan rental motor Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="row mt-5 mb-5">
        <div class="col-12 text-center mb-4">
            <h2><i class="fas fa-cogs"></i> Cara Kerja Aplikasi</h2>
            <p class="lead text-muted">Proses rental motor yang mudah dan cepat</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-lg-3 mb-3 text-center">
            <div class="card h-100">
                <div class="card-body">
                    <div class="display-4 mb-3"><i class="fas fa-user-plus text-primary"></i></div>
                    <h5>1. Daftar Akun</h5>
                    <p class="text-muted">Buat akun baru atau login untuk memulai proses rental motor</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3 text-center">
            <div class="card h-100">
                <div class="card-body">
                    <div class="display-4 mb-3"><i class="fas fa-search text-info"></i></div>
                    <h5>2. Pilih Motor</h5>
                    <p class="text-muted">Lihat koleksi motor kami dan pilih sesuai kebutuhan Anda</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3 text-center">
            <div class="card h-100">
                <div class="card-body">
                    <div class="display-4 mb-3"><i class="fas fa-calendar text-success"></i></div>
                    <h5>3. Booking</h5>
                    <p class="text-muted">Tentukan tanggal sewa dan kembali, sistem akan menghitung total biaya</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3 text-center">
            <div class="card h-100">
                <div class="card-body">
                    <div class="display-4 mb-3"><i class="fas fa-smile text-warning"></i></div>
                    <h5>4. Nikmati</h5>
                    <p class="text-muted">Ambil motor Anda dan nikmati perjalanan dengan motor berkualitas kami</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fleets Section -->
<div class="bg-light py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2><i class="fas fa-motorcycle"></i> Armada Kami</h2>
                <p class="lead text-muted">Pilihan motor berkualitas dari berbagai merk terkemuka</p>
            </div>
        </div>

        <div class="row">
            <?php
                $sample_motors = [
                    ['name' => 'Honda CB150R', 'color' => 'Merah', 'price' => 150000, 'icon' => '🏍️'],
                    ['name' => 'Yamaha Vixion', 'color' => 'Hitam', 'price' => 180000, 'icon' => '🏍️'],
                    ['name' => 'Suzuki GSX', 'color' => 'Biru', 'price' => 200000, 'icon' => '🏍️'],
                ];
            ?>
            <?php $__currentLoopData = $sample_motors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="motor-card">
                        <div class="motor-image">
                            <?php echo e($motor['icon']); ?>

                        </div>
                        <div class="motor-info">
                            <h5><?php echo e($motor['name']); ?></h5>
                            <div class="motor-specs">
                                <p><strong>Warna:</strong></p>
                                <p><?php echo e($motor['color']); ?></p>
                            </div>
                            <div class="motor-price">Rp <?php echo e(number_format($motor['price'], 0, ',', '.')); ?>/hari</div>
                            <button class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-plus"></i> Pesan Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<!-- Contact Section -->
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2><i class="fas fa-phone"></i> Hubungi Kami</h2>
            <p class="lead text-muted">Jangan ragu untuk menghubungi kami jika memiliki pertanyaan</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 text-center mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <i class="fas fa-map-marker-alt fa-2x text-primary mb-3"></i>
                    <h5>Alamat</h5>
                    <p class="text-muted">Jl. Rental Motor No. 123<br>Kota Rental, Jawa Barat 12345</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 text-center mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <i class="fas fa-phone fa-2x text-success mb-3"></i>
                    <h5>Telepon</h5>
                    <p class="text-muted">+62 812-3456-7890<br>+62 821-9876-5432</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 text-center mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <i class="fas fa-envelope fa-2x text-info mb-3"></i>
                    <h5>Email</h5>
                    <p class="text-muted">info@rentalmotor.com<br>support@rentalmotor.com</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PROJECT AKHIR WEB II\project-web-ll-rental_motor\resources\views/home.blade.php ENDPATH**/ ?>