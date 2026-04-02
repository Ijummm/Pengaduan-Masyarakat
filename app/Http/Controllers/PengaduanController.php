<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::where('petugas_id', Auth::id())->latest()->get();
        return view('pengaduan.index', compact('pengaduans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi_laporan' => 'required',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $nama_foto = time().'.'.$request->foto->extension();  
        $request->foto->move(public_path('assets/pengaduan'), $nama_foto);

        Pengaduan::create([
            'tg_pengaduan' => now(),
            'isi_laporan' => $request->isi_laporan,
            'foto' => $nama_foto,
            'status' => '0',
            'petugas_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }

    public function dashboard(Request $request)
    {
        $query = Pengaduan::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tg_pengaduan', [$request->tgl_awal, $request->tgl_akhir]);
        }

        if (Auth::user()->level == 'masyarakat') {
            $query->where('petugas_id', Auth::id());
        }

        $pengaduans = $query->latest()->get();

        $total = Pengaduan::count();
        $pending = Pengaduan::where('status', '0')->count();
        $selesai = Pengaduan::where('status', 'selesai')->count();

        return view('dashboard', compact('pengaduans', 'total', 'pending', 'selesai'));
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::with(['petugas', 'tanggapans.petugas'])->findOrFail($id);

        return view('pengaduan.show', compact('pengaduan'));
    }

    public function tanggapanStore(Request $request)
    {
        $request->validate([
            'pengaduan_id' => 'required',
            'isi_tanggapan' => 'required',
            'status' => 'required',
        ]);

        Tanggapan::create([
            'pengaduan_id' => $request->pengaduan_id,
            'tg_tanggapan' => now(), 
            'isi_tanggapan' => $request->isi_tanggapan,
            'petugas_id' => Auth::id(), 
        ]);

        $pengaduan = Pengaduan::findOrFail($request->pengaduan_id);
        $pengaduan->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Tanggapan berhasil dikirim dan status diperbarui!');
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->petugas_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus laporan ini.');
        }

        if ($pengaduan->status !== '0') {
            return redirect()->back()->with('error', 'Laporan yang sedang diproses atau selesai tidak dapat dihapus.');
        }

        if ($pengaduan->foto) {
            Storage::delete('public/' . $pengaduan->foto);
        }

        $pengaduan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }
}