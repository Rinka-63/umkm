<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventech - Solusi Inventaris UMKM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-glow: rgba(13, 110, 253, 0.5);
            --accent-color: #00d4ff;
            --dark-bg: #050505;
        }

        body {
            overflow-x: hidden;
            background-color: var(--dark-bg);
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: #0d6efd; border-radius: 10px; }

        /* Background Animated Particles (Simple CSS version) */
        .bg-glow {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at 50% 50%, #0d6efd15 0%, transparent 50%);
            z-index: -1;
            pointer-events: none;
        }

        .hero-section {
            min-height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1553413077-190dd305871c?auto=format&fit=crop&q=80&w=2000');
            background-size: cover;
            background-attachment: fixed;
            display: flex;
            align-items: center;
        }

        .glass-container {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            padding: 3.5rem;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-15px);
            background: rgba(13, 110, 253, 0.1);
            border-color: var(--accent-color);
            box-shadow: 0 10px 30px rgba(13, 110, 253, 0.2);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #0d6efd, var(--accent-color));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(45deg, #fff, #0d6efd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-login {
            padding: 15px 40px;
            font-weight: 700;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.4s;
            border: none;
            background: linear-gradient(45deg, #0d6efd, #00d4ff);
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        .section-padding { padding: 100px 0; }

        .step-line {
            position: relative;
        }
        .step-line::after {
            content: "";
            position: absolute;
            top: 50%; left: 0; width: 100%; height: 2px;
            background: rgba(13, 110, 253, 0.2);
            z-index: -1;
        }
    </style>
</head>
<body>

    <div class="bg-glow"></div>

    <section class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="glass-container" data-aos="zoom-in">
                        <h5 class="text-primary fw-bold mb-3" style="letter-spacing: 5px;">INVENTECH SYSTEM</h5>
                        <h1 class="display-3 fw-bold mb-4">Gudang Digital dalam <span class="text-primary">Genggaman</span></h1>
                        <p class="lead mb-5 opacity-75">Optimalkan stok UMKM Anda. Dari pencatatan otomatis hingga laporan real-time, kami bantu bisnis Anda naik kelas tanpa ribet manual.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#fitur" class="btn btn-outline-light btn-lg rounded-pill px-4">Lihat Fitur</a>
                            <a href="{{ route('login') }}" class="btn-login">Masuk Sistem</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container text-center">
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-number">5000+</div>
                    <p class="text-secondary">UMKM Terintegrasi</p>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-number">1M+</div>
                    <p class="text-secondary">Barang Terlacak</p>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-number">99.9%</div>
                    <p class="text-secondary">Akurasi Stok</p>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="section-padding bg-black bg-opacity-50">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold">Fitur Cerdas UMKM</h2>
                <p class="text-secondary">Dirancang khusus untuk mempermudah operasional harian Anda</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="icon-box bg-warning text-dark"><i class="bi bi-clipboard-check-fill"></i></div>
                        <h4>Audit Stok Digital</h4>
                        <p class="text-secondary">Lakukan stock opname rutin langsung dari HP. Otomatis hitung nilai kerugian barang rusak.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="icon-box"><i class="bi bi-bell"></i></div>
                        <h4>Notifikasi Stok Rendah</h4>
                        <p class="text-secondary">Dapatkan peringatan otomatis saat stok produk menipis agar penjualan tidak terhenti.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="icon-box"><i class="bi bi-graph-up-arrow"></i></div>
                        <h4>Laporan Profit</h4>
                        <p class="text-secondary">Pantau laba rugi secara real-time berdasarkan pergerakan stok barang Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&q=80&w=1000" class="img-fluid rounded-4 shadow-lg" alt="Dashboard">
                </div>
                <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                    <h2 class="display-6 fw-bold mb-4">Kelola Stok Hanya dalam 3 Langkah</h2>
                    <div class="mb-4 d-flex align-items-start">
                        <div class="badge bg-primary rounded-circle p-3 me-3">01</div>
                        <div>
                            <h5>Daftarkan Produk</h5>
                            <p class="text-secondary">Masukkan nama, kategori, dan jumlah stok awal produk UMKM Anda.</p>
                        </div>
                    </div>
                    <div class="mb-4 d-flex align-items-start">
                        <div class="badge bg-primary rounded-circle p-3 me-3">02</div>
                        <div>
                            <h5>Pantau Arus Barang</h5>
                            <p class="text-secondary">Catat barang masuk dan keluar dengan satu kali klik.</p>
                        </div>
                    </div>
                    <div class="mb-4 d-flex align-items-start">
                        <div class="badge bg-primary rounded-circle p-3 me-3">03</div>
                        <div>
                            <h5>Unduh Laporan</h5>
                            <p class="text-secondary">Dapatkan laporan bulanan otomatis dalam format PDF atau Excel.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="glass-container text-center py-5" data-aos="flip-up">
                <h2 class="fw-bold mb-4">Siap Transformasi Bisnis Anda?</h2>
                <p class="mb-5 opacity-75">Bergabunglah dengan ribuan pengusaha sukses lainnya.</p>
                <a href="https://wa.me/6285601224250?text=Halo%20Admin,%20saya%20mau%20buat%20akun%20sistem" class="btn btn-primary">
                    Hubungi Admin untuk Akses
                </a>
            </div>
        </div>
    </section>

    <footer class="py-5 border-top border-secondary border-opacity-25">
        <div class="container text-center">
            <p class="text-secondary">&copy; 2026 Inventech System. All rights reserved.</p>
            <div class="d-flex justify-content-center gap-3 mt-3">
                <a href="#" class="text-secondary fs-4"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-secondary fs-4"><i class="bi bi-linkedin"></i></a>
                <a href="#" class="text-secondary fs-4"><i class="bi bi-twitter-x"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: false,
            mirror: true
        });
    </script>
</body>
</html>
