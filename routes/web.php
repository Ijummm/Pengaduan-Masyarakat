<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth', 'prevent-back'])->group(function () {
    
    Route::get('/dashboard', [PengaduanController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');

    Route::middleware('role:masyarakat')->group(function () {
        Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');

        Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
    });

    Route::middleware('role:admin,petugas')->group(function () {
        Route::post('/tanggapan', [PengaduanController::class, 'tanggapanStore'])->name('tanggapan.store');
    });

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/petugas', [AuthController::class, 'indexPetugas'])->name('petugas.index');
        Route::post('/petugas/store', [AuthController::class, 'storePetugas'])->name('petugas.store');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});