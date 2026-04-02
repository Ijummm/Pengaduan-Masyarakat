<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            background-color: #212529;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .btn-login {
            background-color: #212529;
            border: none;
            padding: 10px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-login:hover {
            background-color: #343a40;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="card login-card">
        <div class="login-header">
            <h4 class="mb-0 fw-bold">E-PENGADUAN</h4>
            <small class="opacity-75">Silakan masuk ke akun Anda</small>
        </div>
        
        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger small p-2 text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Username</label>
                    <input type="text" name="username" class="form-control form-control-lg fs-6" placeholder="Masukkan username" required autofocus>
                </div>
                
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg fs-6" placeholder="Masukkan password" required>
                </div>
                
                <button type="submit" class="btn btn-dark btn-login w-100 mb-3">Login Sekarang</button>
                
                <div class="text-center">
                    <span class="small text-muted">Belum punya akun?</span>
                    <a href="/register" class="small fw-bold text-decoration-none text-dark">Daftar di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>