<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | E-Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }
        .register-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
        }
        .register-header {
            background-color: #212529;
            color: white;
            padding: 25px;
            text-align: center;
        }
        .form-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 0.9rem;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #212529;
        }
        .btn-register {
            background-color: #212529;
            border: none;
            padding: 12px;
            font-weight: bold;
            border-radius: 8px;
            transition: 0.3s;
        }
        .btn-register:hover {
            background-color: #343a40;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="card register-card">
        <div class="register-header">
            <h4 class="mb-0 fw-bold text-uppercase tracking-wider">Daftar Akul</h4>
            <small class="opacity-75">Lengkapi data diri untuk mulai melapor</small>
        </div>

        <div class="card-body p-4 p-md-5 bg-white">
            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="alert alert-danger py-2 px-3 mb-4">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/register" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-uppercase">NIK (16 Digit)</label>
                        <input type="text" name="nik" class="form-control" placeholder="3512..." value="{{ old('nik') }}" required autofocus>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-uppercase">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama Anda" value="{{ old('nama') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-uppercase">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Gunakan huruf kecil" value="{{ old('username') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-uppercase">Nomor Telepon</label>
                    <input type="text" name="telp" class="form-control" placeholder="0812..." value="{{ old('telp') }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-uppercase">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                </div>

                <button type="submit" class="btn btn-dark btn-register w-100 mb-3 text-uppercase">Buat Akun Sekarang</button>

                <div class="text-center">
                    <span class="small text-muted">Sudah punya akun?</span>
                    <a href="/login" class="small fw-bold text-decoration-none text-dark">Login di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>