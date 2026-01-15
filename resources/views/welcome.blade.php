<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Inventech System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-glow: rgba(13, 110, 253, 0.5);
        }

        body {
            overflow-x: hidden;
            background-color: #000;
        }

        .hero-section {
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.8)), 
                        url('https://images.unsplash.com/photo-1553413766-47583c4511f4?auto=format&fit=crop&q=80&w=2000');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
        }

        .brand-logo {
            letter-spacing: 5px;
            animation: float 3s ease-in-out infinite;
            text-shadow: 0 0 15px var(--primary-glow);
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .glass-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        .btn-login {
            padding: 15px 60px;
            font-weight: 700;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            background: linear-gradient(45deg, #0d6efd, #00d4ff);
        }

        .btn-login:hover {
            transform: scale(1.1);
            box-shadow: 0 0 30px var(--primary-glow);
            color: white;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at center, transparent 0%, black 100%);
            opacity: 0.4;
        }
    </style>
</head>
<body>

    <section class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="glass-container" data-aos="zoom-in" data-aos-duration="1200">
                        
                        <h5 class="text-primary fw-bold mb-3 brand-logo" data-aos="fade-down" data-aos-delay="200">
                            INVENTECH SYSTEM
                        </h5>
                        
                        <h1 class="display-2 fw-bold mb-4" data-aos="fade-up" data-aos-delay="400">
                            Selamat Datang
                        </h1>
                        
                        <p class="lead mb-5 opacity-75" data-aos="fade-up" data-aos-delay="600">
                            Platform manajemen inventaris cerdas untuk memantau, 
                            mengelola, dan mengoptimalkan aset perusahaan Anda secara real-time.
                        </p>
                        
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" data-aos="fade-up" data-aos-delay="800">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-login btn-lg">
                                Mulai Sekarang
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true 
        });
    </script>
</body>
</html>