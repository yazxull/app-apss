<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\LaporanPengaduan;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil total keseluruhan data
        $totalSiswa = Siswa::count();
        $totalLaporan = LaporanPengaduan::count();

        // Menghitung laporan dengan status 'proses' melalui relasi 'aspirasi'
        $laporanProses = LaporanPengaduan::whereHas('aspirasi', function ($q) {
            $q->where('status', 'proses');
        })->count();

        // Menghitung laporan dengan status 'selesai' melalui relasi 'aspirasi'
        $laporanSelesai = LaporanPengaduan::whereHas('aspirasi', function ($q) {
            $q->where('status', 'selesai');
        })->count();

        // Mengambil 5 laporan terbaru beserta relasinya
        $laporanTerbaru = LaporanPengaduan::with(['siswa', 'kategori', 'aspirasi'])
            ->latest()
            ->take(5)
            ->get();

        // Mengirimkan data ke view admin.dashboard
        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalLaporan',
            'laporanProses',
            'laporanSelesai',
            'laporanTerbaru'
        ));
    }
}
