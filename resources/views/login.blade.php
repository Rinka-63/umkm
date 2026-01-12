<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            /* Ganti URL di bawah dengan path gambar kamu */
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('https://images.unsplash.com/photo-1523050853064-dbad35009711?q=80&w=1470&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            max-width: 900px;
            width: 95%;
        }
        .welcome-section {
            background: #7b1fa2; /* Warna ungu sesuai tema awalmu */
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .form-section {
            padding: 40px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="row g-0">
        <div class="col-md-6 welcome-section d-none d-md-flex">
            <h1 class="display-4 fw-bold">Welcome!</h1>
            <p class="lead">Selamat datang di Sistem Manajemen Iventori UMKM. Silakan login untuk melanjutkan.</p>
        </div>

        <div class="col-md-6 form-section">
            <div class="mb-4">
                <h2 class="fw-bold text-dark">Login</h2>
                <p class="text-muted">Masukkan kredensial anda</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label fw-bold">Username</label>
                    <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Masukkan username" required>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label fw-bold">Password</label>
                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="********" required>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm" style="background-color: #7b1fa2; border: none;">
                    Login Sekarang
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>