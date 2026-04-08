<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        $pegawais = $query->latest()->paginate(15)->withQueryString();

        return view('admin.pengguna.pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        return view('admin.pengguna.pegawai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'nip'      => 'required|string|unique:pegawais,nip|max:30',
            'jabatan'  => 'nullable|string|max:100',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nip.unique'           => 'NIP sudah terdaftar.',
            'password.confirmed'   => 'Konfirmasi password tidak cocok.',
            'password.min'         => 'Password minimal 6 karakter.',
        ]);

        Pegawai::create([
            'nama'     => $request->nama,
            'nip'      => $request->nip,
            'jabatan'  => $request->jabatan,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.pengguna.pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit(Pegawai $pegawai)
    {
        return view('admin.pengguna.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'nip'      => 'required|string|max:30|unique:pegawais,nip,' . $pegawai->id,
            'jabatan'  => 'nullable|string|max:100',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'nip.unique'         => 'NIP sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 6 karakter.',
        ]);

        $data = [
            'nama'    => $request->nama,
            'nip'     => $request->nip,
            'jabatan' => $request->jabatan,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pegawai->update($data);

        return redirect()->route('admin.pengguna.pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('admin.pengguna.pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus.');
    }
}