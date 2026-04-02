<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>

    <div class="row">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold">Laporan Dari: {{ $pengaduan->petugas?->nama ?? 'Anonim' }}</h5>
                <hr>
                @if($pengaduan->foto)
                    <img src="{{ asset('assets/pengaduan/'.$pengaduan->foto) }}" class="img-fluid rounded mb-3">
                @endif
                <p><strong>Isi Laporan:</strong></p>
                <div class="p-3 bg-light rounded">{{ $pengaduan->isi_laporan }}</div>
                <p class="mt-3 text-muted">Tanggal: {{ $pengaduan->tg_pengaduan }}</p>
            </div>
        </div>

        <div class="col-md-5">
            @if(Auth::user()->level != 'masyarakat')
            <div class="card border-0 shadow-sm p-4 mb-3">
                <h6>Beri Tanggapan</h6>
                <form action="{{ route('tanggapan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pengaduan_id" value="{{ $pengaduan->id }}">
                    <select name="status" class="form-select mb-2">
                        <option value="0" {{ $pengaduan->status == '0' ? 'selected' : '' }}>Pending</option>
                        <option value="proses" {{ $pengaduan->status == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    <textarea name="isi_tanggapan" class="form-control mb-2" rows="3" placeholder="Ketik tanggapan..."></textarea>
                    <button class="btn btn-primary w-100">Kirim</button>
                </form>
            </div>
            @endif

            <div class="card border-0 shadow-sm p-4">
                <h6 class="fw-bold">Riwayat Tanggapan</h6>
                <hr>
                @forelse($pengaduan->tanggapans as $t)
                    <div class="mb-4 border-bottom pb-2">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="fw-bold text-primary">{{ $t->petugas?->nama }}</small>
                            {{-- Menampilkan Tanggal Tanggapan --}}
                            <small class="text-muted" style="font-size: 0.75rem;">
                                {{ \Carbon\Carbon::parse($t->tg_tanggapan)->format('d M Y, H:i') }}
                            </small>
                        </div>
                        
                        <p class="mb-1 text-dark">{{ $t->isi_tanggapan }}</p>
                        
                    </div>
                @empty
                    <p class="text-muted small text-center">Belum ada tanggapan.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
</body>
</html>