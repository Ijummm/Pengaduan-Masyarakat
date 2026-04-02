<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between mb-4">
        <h4>Manajemen Petugas</h4>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4">
                <h6 class="fw-bold">Tambah Petugas Baru</h6>
                <hr>
                <form action="{{ route('petugas.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="level" value="petugas">

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">NIK</label>
                        <input type="text" name="nik" class="form-control" placeholder="Masukkan 16 digit NIK" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama lengkap petugas" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username untuk login" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nomor Telepon</label>
                        <input type="text" name="telp" class="form-control" placeholder="Contoh: 0812345..." required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Daftarkan Petugas</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <h6 class="fw-bold">Daftar Petugas & Admin</h6>
                <hr>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Telp</th>
                            <th>Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($petugas as $p)
                        <tr>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->username }}</td>
                            <td>{{ $p->telp }}</td>
                            <td>
                                <span class="badge {{ $p->level == 'admin' ? 'bg-danger' : 'bg-info' }}">
                                    {{ ucfirst($p->level) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>