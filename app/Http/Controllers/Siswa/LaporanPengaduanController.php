<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPengaduan;
use App\Models\Kategori;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\Auth;

use App\Models\KomentarLaporan;

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
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoName = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/laporan'), $fotoName);
        }

        LaporanPengaduan::create([
            'siswa_id'    => Auth::guard('siswa')->user()->id,
            'kategori_id' => $request->kategori_id,
            'ket'         => $request->ket,
            'lokasi'      => $request->lokasi,
            'foto'        => $fotoName,
            'is_anonim'   => $request->has('is_anonim') ? true : false,
        ]);

        return redirect()
            ->route('siswa.dashboard')
            ->with('success', 'Laporan berhasil dikirim');
    }

    public function show(LaporanPengaduan $laporan)
    {
        $laporan->load(['siswa', 'aspirasi', 'kategori', 'komentar.sender']);

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
        $rules = [
            'feedback' => 'required|integer|min:1|max:5',
        ];

        // Jika feedback 1 (Tidak Puas) atau 2 (Kurang Puas), alasan wajib diisi
        if (in_array((int) $request->feedback, [1, 2])) {
            $rules['alasan'] = 'required|string|max:1000';
        } else {
            $rules['alasan'] = 'nullable|string|max:1000';
        }

        $request->validate($rules, [
            'alasan.required' => 'Alasan wajib diisi jika Anda memilih Tidak Puas atau Kurang Puas.',
        ]);

        $aspirasi->update([
            'feedback' => $request->feedback,
            'alasan'   => $request->alasan,
        ]);

        return redirect()
            ->route('siswa.dashboard')
            ->with('success', 'Terima kasih atas feedback Anda.');
    }

    public function storeKomentar(Request $request, LaporanPengaduan $laporan)
    {
        $request->validate([
            'pesan' => 'required|string|max:1000'
        ]);

        KomentarLaporan::create([
            'laporan_id'  => $laporan->id,
            'sender_type' => 'siswa',
            'sender_id'   => Auth::guard('siswa')->id(),
            'pesan'       => $request->pesan,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim');
    }
}
