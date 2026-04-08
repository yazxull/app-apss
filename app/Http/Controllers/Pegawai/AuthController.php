<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nip'      => 'required',
            'password' => 'required',
        ], [
            'nip.required'      => 'NIP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::guard('pegawai')->attempt([
            'nip'      => $request->nip,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();
            return redirect()->route('pegawai.dashboard');
        }

        return back()->withErrors([
            'nip' => 'NIP atau password salah.',
        ])->withInput($request->only('nip'));
    }

    public function logout(Request $request)
    {
        Auth::guard('pegawai')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('siswa.login');
    }
}