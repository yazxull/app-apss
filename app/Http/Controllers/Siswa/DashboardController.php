<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = Auth::guard('siswa')->user();

        $laporan = $siswa->laporan()
            ->with(['kategori', 'aspirasi'])
            ->latest()
            ->paginate();

        $kepuasan = [
            1 => 'Tidak Puas',
            2 => 'Kurang Puas',
            3 => 'Cukup Puas',
            4 => 'Puas',
            5 => 'Sangat Puas',
        ];

        $laporan->getCollection()->transform(function ($item) use ($kepuasan) {
            $item->status = $item->aspirasi 
                ? $item->aspirasi->status 
                : null;

            $nilai = $item->aspirasi->feedback ?? null;
            $item->feedback = $nilai 
                ? ($kepuasan[$nilai] ?? '-') 
                : 'Belum ada feedback';

            return $item;
        });

        return view('siswa.dashboard', compact('laporan'));
    }
}
