<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex align-items-center justify-content-center vh-100" 
      style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://i.imgur.com/1mw6KSb.jpeg'); 
      background-size: cover; background-position: center;">

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="max-width: 400px; width: 90%;">
        <div class="card-body p-4 p-sm-5">
            
            <div class="text-center mb-4">
                <h3 class="fw-bold text-dark mb-1">🔐 Login Sistem</h3>
                <p class="text-muted small">Inven Tech</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger border-0 small py-2 text-center mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" name="username" class="form-control border-0 bg-light rounded-3" id="username" placeholder="Username" required autocomplete="off">
                    <label for="username" class="text-muted">Username</label>
                </div>
                
                <div class="form-floating mb-4">
                    <input type="password" name="password" class="form-control border-0 bg-light rounded-3" id="password" placeholder="Password" required>
                    <label for="password" class="text-muted">Password</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm">
                    Masuk Ke Sistem
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="#" class="text-decoration-none small text-muted">Lupa password? Hubungi Admin IT</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>