<?php

use Illuminate\Support\Facades\Route;

// Siswa
use App\Http\Controllers\Siswa\AuthController;
use App\Http\Controllers\Siswa\RegisterController;
use App\Http\Controllers\Siswa\AkunController;
use App\Http\Controllers\Siswa\DashboardController;
use App\Http\Controllers\Siswa\LaporanPengaduanController;

// Pegawai
use App\Http\Controllers\Pegawai\AuthController as PegawaiAuthController;

// Admin
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AkunController as AdminAkunController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanAspirasiController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\PegawaiController as AdminPegawaiController;
use App\Http\Controllers\Admin\SiswaImportController;
use App\Http\Controllers\Admin\PegawaiImportController;

// ─────────────────────────────────────────────
// Welcome
// ─────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ─────────────────────────────────────────────
// Siswa
// ─────────────────────────────────────────────
Route::prefix('siswa')->name('siswa.')->group(function () {

    Route::middleware('guest:siswa')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
        Route::post('/register', [RegisterController::class, 'register']);
    });

    Route::middleware('auth:siswa')->group(function () {
        Route::get('/dasboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::singleton('/akun', AkunController::class)->except('show');
        Route::post('laporan/{aspirasi}/feedback', [LaporanPengaduanController::class, 'feedback'])->name('laporan.feedback');
        Route::post('laporan/{laporan}/komentar', [LaporanPengaduanController::class, 'storeKomentar'])->name('laporan.komentar');
        Route::resource('laporan', LaporanPengaduanController::class)->except(['edit', 'update']);
    });
});

// ─────────────────────────────────────────────
// Pegawai
// ─────────────────────────────────────────────
Route::prefix('pegawai')->name('pegawai.')->group(function () {

    Route::middleware('guest:pegawai')->group(function () {
        Route::post('/login', [PegawaiAuthController::class, 'login'])->name('login');
    });

    Route::middleware('auth:pegawai')->group(function () {
        Route::post('/logout', [PegawaiAuthController::class, 'logout'])->name('logout');
        // Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])->name('dashboard');
    });
});

// ─────────────────────────────────────────────
// Admin
// ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dasboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/akun', [AdminAkunController::class, 'index'])->name('akun');
        Route::post('/akun', [AdminAkunController::class, 'updateProfile']);
        Route::post('/akun/password', [AdminAkunController::class, 'updatePassword'])->name('akun.password');
        Route::resource('kategori', KategoriController::class);

        Route::get('laporan/cetak', [LaporanAspirasiController::class, 'cetakPdf'])->name('laporan.cetak');
        Route::post('laporan/{laporan}/komentar', [LaporanAspirasiController::class, 'storeKomentar'])->name('laporan.komentar');
        Route::resource('laporan', LaporanAspirasiController::class)->only(['index', 'show', 'update']);

        // Pengguna
        Route::prefix('pengguna')->name('pengguna.')->group(function () {

            // Siswa
            Route::get('siswa/template', [SiswaImportController::class, 'downloadTemplate'])->name('siswa.template');
            Route::post('siswa/import',  [SiswaImportController::class, 'import'])->name('siswa.import');
            Route::resource('siswa', AdminSiswaController::class);

            // Pegawai
            Route::get('pegawai/template', [PegawaiImportController::class, 'downloadTemplate'])->name('pegawai.template');
            Route::post('pegawai/import',  [PegawaiImportController::class, 'import'])->name('pegawai.import');
            Route::resource('pegawai', AdminPegawaiController::class);
        });
    });
});