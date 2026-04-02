<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | E-Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">E-PENGADUAN</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                
                @if(Auth::user()->level == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('petugas*') ? 'active' : '' }}" href="{{ route('petugas.index') }}">Kelola Petugas</a>
                </li>
                @endif
            </ul>

            <div class="d-flex align-items-center">
                <span class="text-light me-3 small">Halo, {{ Auth::user()->nama }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    <div class="mb-4">
        <h4>Selamat Datang, {{ Auth::user()->nama }}</h4>
        <span class="badge bg-primary">Role: {{ ucfirst(Auth::user()->level) }}</span>
    </div>

    @if(Auth::user()->level == 'admin' || Auth::user()->level == 'petugas')
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card p-3 border-0 shadow-sm bg-primary text-white">
                    <h6>Total Laporan</h6>
                    <h3>{{ $total }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 border-0 shadow-sm bg-warning text-dark">
                    <h6>Belum Diproses</h6>
                    <h3>{{ $pending }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 border-0 shadow-sm bg-success text-white">
                    <h6>Selesai</h6>
                    <h3>{{ $selesai }}</h3>
                </div>
            </div>
        </div>
    @endif

    @if(Auth::user()->level == 'masyarakat')
        <div class="card p-4 border-0 shadow-sm mb-4">
                <h5>Buat Laporan Baru</h5>
                <form action="/pengaduan" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <textarea name="isi_laporan" class="form-control" placeholder="Isi laporan..."></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="foto" class="form-control">
                    </div>
                    <button class="btn btn-primary">Kirim Pengaduan</button>
                </form>
            </div>
        @endif

        <div class="card p-4 border-0 shadow-sm">
            <div class="row g-3 align-items-center mb-4">
            <div class="col-md-6">
                <h5 class="mb-0">{{ Auth::user()->level == 'masyarakat' ? 'Riwayat Laporan' : 'Semua Laporan' }}</h5>
            </div>
            
            <div class="col-md-6 text-md-end">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-dark {{ !request('status') ? 'active' : '' }}">Semua</a>
                    <a href="{{ route('dashboard', ['status' => '0']) }}" class="btn btn-outline-dark {{ request('status') == '0' ? 'active' : '' }}">Pending</a>
                    <a href="{{ route('dashboard', ['status' => 'proses']) }}" class="btn btn-outline-dark {{ request('status') == 'proses' ? 'active' : '' }}">Proses</a>
                    <a href="{{ route('dashboard', ['status' => 'selesai']) }}" class="btn btn-outline-dark {{ request('status') == 'selesai' ? 'active' : '' }}">Selesai</a>
                </div>
            </div>
        </div>

        <form action="{{ route('dashboard') }}" method="GET" class="row g-2 mb-4 pb-3 border-bottom">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <div class="col-md-3">
                <label class="small fw-bold text-muted">TANGGAL AWAL</label>
                <input type="date" name="tgl_awal" class="form-control form-control-sm" value="{{ request('tgl_awal') }}">
            </div>
            <div class="col-md-3">
                <label class="small fw-bold text-muted">TANGGAL AKHIR</label>
                <input type="date" name="tgl_akhir" class="form-control form-control-sm" value="{{ request('tgl_akhir') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-dark btn-sm w-100 fw-bold">Cari</button>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm w-100 border text-muted">Reset</a>
            </div>
        </form>
        <table class="table mt-3">
            <thead>
                <tr>
                    @if(Auth::user()->level != 'masyarakat') <th>Pelapor</th> @endif
                    <th>Tanggal</th>
                    <th>Isi Laporan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengaduans as $p)
                <tr>
                    @if(Auth::user()->level != 'masyarakat') <td>{{ $p->petugas?->nama ?? 'User Tidak Ditemukan' }}</td> @endif
                    <td>{{ $p->tg_pengaduan }}</td>
                    <td>{{ Str::limit($p->isi_laporan, 50) }}</td>
                    <td><span class="badge bg-secondary">{{ $p->status }}</span></td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('pengaduan.show', $p->id) }}" class="btn btn-info btn-sm text-white">Detail</a>
                            
                            @if(Auth::user()->level == 'masyarakat' && $p->status == '0')
                                <form action="{{ route('pengaduan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>