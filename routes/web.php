<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Siswa\AuthController;
use App\Http\Controllers\Siswa\RegisterController;
use App\Http\Controllers\Siswa\AkunController;
use App\Http\Controllers\Siswa\DashboardController;
use App\Http\Controllers\Siswa\LaporanPengaduanController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AkunController as AdminAkunController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanAspirasiController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::prefix('siswa')->name('siswa.')->group(function () {

    Route::middleware('guest:siswa')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])
            ->name('login');
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/register', [RegisterController::class, 'showRegister'])
            ->name('register');
        Route::post('/register', [RegisterController::class, 'register']);
    });

    Route::middleware('auth:siswa')->group(function () {
        Route::get('/dasboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::singleton('/akun', AkunController::class)->except('show');
        Route::post('laporan/{aspirasi}/feedback', [LaporanPengaduanController::class, 'feedback'])
            ->name('laporan.feedback');
        Route::resource('laporan', LaporanPengaduanController::class)->except(['index', 'edit', 'update']);
    });
});

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
        Route::resource('laporan', LaporanAspirasiController::class)
        ->only(['index', 'show', 'update']);
    });
});
