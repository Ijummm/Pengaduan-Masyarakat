<div class="card p-4 shadow-sm border-0 mb-4">
    <h5>Tulis Laporan Anda</h5>
    <form action="/pengaduan" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Isi Laporan</label>
            <textarea name="isi_laporan" class="form-control" rows="4" placeholder="Jelaskan laporan Anda secara detail..." required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto Pendukung</label>
            <input type="file" name="foto" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Laporan</button>
    </form>
</div>

<div class="card p-4 shadow-sm border-0">
    <h5>Riwayat Laporan Saya</h5>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Isi Laporan</th>
                <th>Status</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduans as $p)
            <tr>
                <td>{{ $p->tg_pengaduan }}</td>
                <td>{{ $p->isi_laporan }}</td>
                <td>
                    <span class="badge {{ $p->status == '0' ? 'bg-secondary' : ($p->status == 'proses' ? 'bg-warning' : 'bg-success') }}">
                        {{ $p->status == '0' ? 'Terkirim' : ucfirst($p->status) }}
                    </span>
                </td>
                <td><img src="{{ asset('assets/pengaduan/'.$p->foto) }}" width="100"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>