<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AkunController extends Controller
{
    public function edit()
    {
        return view('siswa.akun', [
            'siswa' => Auth::guard('siswa')->user()
        ]);
    }

    public function update(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();

        $request->validate([
            'nis'   => 'required|unique:siswas,nis,' . $siswa->id,
            'nama'  => 'required|string|max:100',
            'kelas' => 'required|string|max:50',
        ]);

        $siswa->update([
            'nis'   => $request->input('nis'),
            'nama'  => $request->input('nama'),
            'kelas' => $request->input('kelas'),
        ]);

        return redirect()
            ->route('siswa.akun.edit')
            ->with('success', 'Data akun berhasil diperbarui');
    }
}
