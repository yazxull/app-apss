<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPengaduan;
use App\Models\Kategori;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\Auth;

class LaporanPengaduanController extends Controller
{
    public function create()
    {
        $kategori = Kategori::all();

        return view('siswa.laporan.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'ket'         => 'required|string',
            'lokasi'      => 'required|string|max:255',
        ]);

        LaporanPengaduan::create([
            'siswa_id'    => Auth::guard('siswa')->user()->id,
            'kategori_id' => $request->kategori_id,
            'ket'         => $request->ket,
            'lokasi'      => $request->lokasi,
        ]);

        return redirect()
            ->route('siswa.dashboard')
            ->with('success', 'Laporan berhasil dikirim');
    }

    public function show(LaporanPengaduan $laporan)
    {
        $laporan->load(['siswa', 'aspirasi', 'kategori']);

        return view('siswa.laporan.show', [
            'laporan' => $laporan
        ]);
    }

    public function destroy(LaporanPengaduan $laporan)
    {
        $laporan->delete();

        return redirect()
            ->route('siswa.dashboard')
            ->with('success', 'Laporan berhasil dihapus');
    }

    public function feedback(Request $request, Aspirasi $aspirasi)
    {
        $request->validate([
            'feedback' => 'required|integer|min:1|max:5',
        ]);

        $aspirasi->update($request->all());

        return redirect()
            ->route('siswa.dashboard')
            ->with('success', 'Terima kasih atas feedback Anda.');
    }
}
