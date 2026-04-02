<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'nik' => 'required|unique:petugas,nik|digits:16',
            'nama' => 'required|string',
            'username' => 'required|unique:petugas,username',
            'password' => 'required',
            'telp' => 'required',
        ]);

        Petugas::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'telp' => $request->telp,
            'level' => 'masyarakat',
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function indexPetugas()
    {
        $petugas = Petugas::whereIn('level', ['admin', 'petugas'])->get();
        return view('admin.petugas', compact('petugas'));
    }

    public function storePetugas(Request $request)
    {
        $request->validate([
            'nik'      => 'required|unique:petugas,nik',
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:petugas,username',
            'password' => 'required|min:6',
            'telp' => 'required',
            'level' => 'required|in:admin,petugas',
        ]);

        Petugas::create([
            'nik'      => $request->nik,
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'telp' => $request->telp,
            'level' => $request->level,
        ]);

        return redirect()->back()->with('success', 'Petugas baru berhasil didaftarkan!');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}