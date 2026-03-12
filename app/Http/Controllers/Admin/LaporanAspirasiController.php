<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aspirasi;

class LaporanAspirasiController extends Controller
{
    public function index(Request $request)
    {
        // Memulai query dengan eager loading untuk optimasi
        $query = LaporanPengaduan::with(['kategori', 'aspirasi'])
            ->latest();

        // Logika Filter Status
        if ($request->filled('status')) {
            if ($request->status === 'belum') {
                // Mencari laporan yang belum memiliki aspirasi atau statusnya masih 'menunggu'
                $query->where(function ($q) {
                    $q->whereDoesntHave('aspirasi')
                      ->orWhereHas('aspirasi', function ($sub) {
                          $sub->where('status', 'menunggu');
                      });
                });
            } else {
                // Filter berdasarkan status spesifik lainnya
                $query->whereHas('aspirasi', function ($q) use ($request) {
                    $q->where('status', $request->status);
                });
            }
        }

        // Paginasi dengan mempertahankan query string filter
        $laporan = $query->paginate(10)->withQueryString();

        // Pemetaan nilai kepuasan (Feedback)
        $kepuasan = [
            1 => 'Tidak Puas',
            2 => 'Kurang Puas',
            3 => 'Cukup Puas',
            4 => 'Puas',
            5 => 'Sangat Puas',
        ];

        // Transformasi data untuk memudahkan tampilan di Blade
        $laporan->getCollection()->transform(function ($item) use ($kepuasan) {
            $item->status = $item->aspirasi?->status;

            $nilai = $item->aspirasi?->feedback ?? null;
            $item->feedback = $nilai 
                ? ($kepuasan[$nilai] ?? '-') 
                : 'Belum ada feedback';

            return $item;
        });

        return view('admin.laporan.index', compact('laporan'));
    }

    public function show(LaporanPengaduan $laporan)
    {
        // Memuat relasi yang diperlukan
        $laporan->load(['kategori', 'aspirasi']);

        $kepuasan = [
            1 => 'Tidak Puas',
            2 => 'Kurang Puas',
            3 => 'Cukup Puas',
            4 => 'Puas',
            5 => 'Sangat Puas',
        ];

        // Mapping feedback untuk detail laporan
        if ($laporan->aspirasi?->feedback) {
            $laporan->feedback = $kepuasan[$laporan->aspirasi->feedback] ?? '-';
        } else {
            $laporan->feedback = 'Belum ada feedback';
        }

        return view('admin.laporan.show', compact('laporan'));
    }

    public function update(Request $request, LaporanPengaduan $laporan)
    {
        // Validasi perubahan status oleh admin
        $request->validate([
            'status' => 'required|in:proses,selesai',
        ]);

        // Menggunakan updateOrCreate agar lebih fleksibel
        Aspirasi::updateOrCreate(
            ['laporan_id' => $laporan->id], // Cari berdasarkan laporan_id
            [
                'admin_id' => Auth::guard('admin')->id(),
                'status'   => $request->status,
            ]
        );

        return redirect()
            ->route('admin.laporan.show', $laporan->id)
            ->with('success', 'Status aspirasi berhasil diperbarui.');
    }
}