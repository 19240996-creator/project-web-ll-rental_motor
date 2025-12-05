<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rental Motor - Layanan Penyewaan Motor Terpercaya</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: white !important;
        }

        .navbar-brand i {
            margin-right: 10px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            margin: 0 10px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        .btn-auth {
            border-radius: 50px;
            padding: 8px 25px;
            font-weight: 600;
            margin-left: 10px;
            transition: all 0.3s ease;
        }

        .btn-login {
            background: white;
            color: #667eea;
            border: 2px solid white;
        }

        .btn-login:hover {
            background: transparent;
            color: white;
        }

        .btn-register {
            background: #667eea;
            color: white;
            border: 2px solid #667eea;
        }

        .btn-register:hover {
            background: white;
            color: #667eea;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 120px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><pattern id="dots" x="0" y="0" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="2" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="1200" height="600" fill="url(%23dots)"/></svg>');
            opacity: 0.5;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            animation: slideUp 0.8s ease-out;
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

        .hero h1 {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero p {
            font-size: 20px;
            margin-bottom: 40px;
            opacity: 0.95;
        }

        .hero .btn {
            border-radius: 50px;
            padding: 15px 40px;
            font-size: 16px;
            font-weight: 600;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: white;
            color: #667eea;
            border: 2px solid white;
        }

        .btn-primary:hover {
            background: transparent;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            font-size: 48px;
            color: #667eea;
            margin-bottom: 20px;
        }

        .feature-card h5 {
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            font-size: 20px;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* How It Works */
        .how-it-works {
            padding: 80px 0;
            background: white;
        }

        .step-card {
            text-align: center;
            margin-bottom: 40px;
        }

        .step-number {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: bold;
            margin: 0 auto 20px;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .step-card h5 {
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .step-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Fleets Section */
        .fleets {
            padding: 80px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .fleet-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
        }

        .fleet-item:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-10px);
        }

        .fleet-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }

        .fleet-item h5 {
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .fleet-item p {
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .fleet-price {
            font-size: 24px;
            font-weight: bold;
            color: #ffd700;
            margin: 20px 0;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .cta-section p {
            font-size: 18px;
            margin-bottom: 40px;
            opacity: 0.95;
        }

        .cta-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-buttons .btn {
            border-radius: 50px;
            padding: 15px 40px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .cta-btn-primary {
            background: white;
            color: #667eea;
            border: 2px solid white;
        }

        .cta-btn-primary:hover {
            background: transparent;
            color: white;
            transform: translateY(-3px);
        }

        .cta-btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .cta-btn-secondary:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }

        /* Footer */
        footer {
            background: #333;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        footer p {
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 32px;
            }

            .hero p {
                font-size: 16px;
            }

            .hero .btn {
                padding: 12px 30px;
                font-size: 14px;
                margin: 10px 5px;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .cta-buttons .btn {
                width: 100%;
                max-width: 300px;
                margin: 0 auto;
            }
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
            animation: fadeIn 0.8s ease-out;
        }

        .section-title h2 {
            font-size: 36px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .section-title p {
            font-size: 18px;
            color: #666;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-motorcycle"></i> Rental Motor
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Keunggulan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">Cara Kerja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#fleets">Armada</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-auth btn-login" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-auth btn-register" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> Daftar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1><i class="fas fa-motorcycle"></i> Selamat Datang di Rental Motor</h1>
                <p>Layanan penyewaan motor terpercaya dengan harga terjangkau dan kualitas terbaik</p>
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">
                        <i class="fas fa-user-plus"></i> Daftar Akun Baru
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2><i class="fas fa-star"></i> Keunggulan Kami</h2>
                <p>Kami menyediakan layanan rental motor terbaik dengan berbagai keunggulan</p>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h5>Terpercaya</h5>
                        <p>Layanan rental motor yang aman dan terpercaya dengan armada yang terawat dengan baik dan selalu siap operasional.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h5>Harga Terjangkau</h5>
                        <p>Kami menawarkan harga yang sangat kompetitif dengan berbagai pilihan motor sesuai budget dan kebutuhan Anda.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5>Layanan 24/7</h5>
                        <p>Tim layanan pelanggan kami siap membantu Anda kapan saja untuk memenuhi semua kebutuhan rental motor Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <div class="section-title">
                <h2><i class="fas fa-cogs"></i> Cara Kerja Aplikasi</h2>
                <p>Proses rental motor yang mudah dan cepat</p>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h5>Daftar Akun</h5>
                        <p>Buat akun baru atau login untuk memulai proses rental motor</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h5>Pilih Motor</h5>
                        <p>Lihat koleksi motor kami dan pilih sesuai kebutuhan Anda</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h5>Booking</h5>
                        <p>Tentukan tanggal sewa dan kembali, sistem akan menghitung total biaya</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <h5>Nikmati</h5>
                        <p>Ambil motor Anda dan nikmati perjalanan dengan motor berkualitas kami</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fleets Section -->
    <section class="fleets" id="fleets">
        <div class="container">
            <div class="section-title">
                <h2 style="color: white;"><i class="fas fa-motorcycle"></i> Armada Kami</h2>
                <p style="color: rgba(255, 255, 255, 0.9);">Pilihan motor berkualitas dari berbagai merk terkemuka</p>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="fleet-item">
                        <div class="fleet-icon">🏍️</div>
                        <h5>Honda CB150R</h5>
                        <p>Motor sporty dengan performa tinggi</p>
                        <div class="fleet-price">Rp 150.000/hari</div>
                        <a href="{{ route('login') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Pesan Sekarang
                        </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="fleet-item">
                        <div class="fleet-icon">🏍️</div>
                        <h5>Yamaha Vixion</h5>
                        <p>Motor modern dengan teknologi terkini</p>
                        <div class="fleet-price">Rp 180.000/hari</div>
                        <a href="{{ route('login') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Pesan Sekarang
                        </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="fleet-item">
                        <div class="fleet-icon">🏍️</div>
                        <h5>Suzuki GSX</h5>
                        <p>Motor premium dengan desain elegan</p>
                        <div class="fleet-price">Rp 200.000/hari</div>
                        <a href="{{ route('login') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Siap untuk Memulai Petualangan?</h2>
            <p>Daftar sekarang dan dapatkan akses ke ribuan motor berkualitas</p>
            <div class="cta-buttons">
                <a href="{{ route('login') }}" class="btn cta-btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="{{ route('register') }}" class="btn cta-btn-secondary">
                    <i class="fas fa-user-plus"></i> Daftar Akun
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2024 Aplikasi Rental Motor. All rights reserved. | Dibuat dengan <i class="fas fa-heart text-danger"></i> oleh Tim Developer</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Smooth scroll untuk navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>
