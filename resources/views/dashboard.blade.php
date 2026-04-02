<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | E-Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card { border: none; border-radius: 12px; transition: 0.3s; }
        .btn { border-radius: 8px; font-weight: 500; }
        .navbar { background-color: #1a1a1a !important; }
        .nav-link { color: rgba(255,255,255,0.7) !important; transition: 0.3s; margin: 0 5px; }
        .nav-link:hover, .nav-link.active { color: #fff !important; }
        .stat-card { border-left: 5px solid; }
        .table thead { background-color: #f8f9fa; }
        .badge { font-weight: 600; padding: 6px 12px; border-radius: 30px; }
    </style>
</head>
<body class="bg-light">

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            <i class="bi bi-shield-lock-fill me-2"></i>E-PENGADUAN
        </a>
        
        {{-- Tombol Toggle Mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                {{-- Menu khusus Admin --}}
                @if(Auth::user()->level == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('petugas*') ? 'active' : '' }}" href="{{ route('petugas.index') }}">
                        Kelola Petugas
                    </a>
                </li>
                @endif
            </ul>

            <div class="d-flex align-items-center ms-auto mt-3 mt-lg-0">
                <span class="text-light me-3 small d-none d-sm-inline">
                    Halo, <strong>{{ Auth::user()->nama }}</strong>
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm px-3">
                        <i class="bi bi-box-arrow-right me-1"></i>Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="fw-bold mb-1 text-dark">Selamat Datang, {{ Auth::user()->nama }}</h2>
            <p class="text-muted mb-0">Role: <span class="badge bg-primary opacity-75">{{ ucfirst(Auth::user()->level) }}</span></p>
        </div>
    </div>

    {{-- STATISTIK (Admin/Petugas) --}}
    @if(Auth::user()->level != 'masyarakat')
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card stat-card border-primary p-3 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-file-earmark-text text-primary fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Total Laporan</p>
                            <h3 class="fw-bold mb-0">{{ $total }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card border-warning p-3 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-clock-history text-warning fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Pending</p>
                            <h3 class="fw-bold mb-0">{{ $pending }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card border-success p-3 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-check2-circle text-success fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Selesai</p>
                            <h3 class="fw-bold mb-0">{{ $selesai }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- FORM BUAT LAPORAN (Masyarakat) --}}
    @if(Auth::user()->level == 'masyarakat')
        <div class="card shadow-sm p-4 mb-5 border-0 bg-white">
            <h5 class="fw-bold mb-4"><i class="bi bi-plus-circle-dotted me-2"></i>Buat Laporan Baru</h5>
            <form action="/pengaduan" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold">Isi Laporan</label>
                    <textarea name="isi_laporan" class="form-control" rows="4" placeholder="Jelaskan secara detail..." required></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Lampiran Foto</label>
                    <input type="file" name="foto" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                    <i class="bi bi-send me-2"></i>Kirim Pengaduan
                </button>
            </form>
        </div>
    @endif

    {{-- TABEL DATA --}}
    <div class="card shadow-sm border-0">
        <div class="p-4 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-list-stars me-2"></i>{{ Auth::user()->level == 'masyarakat' ? 'Riwayat Laporan Saya' : 'Daftar Semua Laporan' }}
            </h5>
            <div class="btn-group btn-group-sm">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary {{ !request('status') ? 'active' : '' }}">Semua</a>
                <a href="{{ route('dashboard', ['status' => '0']) }}" class="btn btn-outline-secondary {{ request('status') == '0' ? 'active' : '' }}">Pending</a>
                <a href="{{ route('dashboard', ['status' => 'proses']) }}" class="btn btn-outline-secondary {{ request('status') == 'proses' ? 'active' : '' }}">Proses</a>
                <a href="{{ route('dashboard', ['status' => 'selesai']) }}" class="btn btn-outline-secondary {{ request('status') == 'selesai' ? 'active' : '' }}">Selesai</a>
            </div>
        </div>

        <div class="p-4 bg-light bg-opacity-50 border-bottom">
            <form action="{{ route('dashboard') }}" method="GET" class="row g-2">
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-calendar-event small"></i></span>
                        <input type="date" name="tgl_awal" class="form-control" value="{{ request('tgl_awal') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-calendar-check small"></i></span>
                        <input type="date" name="tgl_akhir" class="form-control" value="{{ request('tgl_akhir') }}">
                    </div>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-dark btn-sm flex-grow-1"><i class="bi bi-search me-1"></i>Filter</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i></a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="small text-uppercase text-muted">
                    <tr>
                        @if(Auth::user()->level != 'masyarakat') <th class="ps-4">Pelapor</th> @endif
                        <th class="{{ Auth::user()->level == 'masyarakat' ? 'ps-4' : '' }}">Tanggal</th>
                        <th>Isi Laporan</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduans as $p)
                    <tr>
                        @if(Auth::user()->level != 'masyarakat')
                            <td class="ps-4 fw-medium text-primary">{{ $p->petugas?->nama ?? 'Anonim' }}</td>
                        @endif
                        <td class="{{ Auth::user()->level == 'masyarakat' ? 'ps-4' : '' }} small">
                            {{ \Carbon\Carbon::parse($p->tg_pengaduan)->translatedFormat('d M Y') }}
                        </td>
                        <td class="text-truncate" style="max-width: 250px;">{{ $p->isi_laporan }}</td>
                        <td class="text-center">
                            @if($p->status == '0')
                                <span class="badge bg-danger">Pending</span>
                            @elseif($p->status == 'proses')
                                <span class="badge bg-warning text-dark">Proses</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('pengaduan.show', $p->id) }}" class="btn btn-info btn-sm text-white shadow-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(Auth::user()->level == 'masyarakat' && $p->status == '0')
                                    <form action="{{ route('pengaduan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus laporan?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm shadow-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada laporan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>