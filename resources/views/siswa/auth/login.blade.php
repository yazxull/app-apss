@extends('layouts.auth')
@section('title', 'Masuk Akun')

@section('content')

<div class="auth-form-header">
    <div class="auth-form-icon">
        <i class="bi bi-box-arrow-in-right"></i>
    </div>
    <div class="auth-form-title">Selamat Datang!</div>
    <div class="auth-form-sub">Pilih jenis akun untuk melanjutkan.</div>
</div>

{{-- Pilihan Role --}}
<div class="role-selector" id="roleSelector">
    <button type="button" class="role-btn active" id="btnSiswa" onclick="switchRole('siswa')">
        <i class="bi bi-mortarboard-fill"></i>
        <span>Siswa</span>
    </button>
    <button type="button" class="role-btn" id="btnPegawai" onclick="switchRole('pegawai')">
        <i class="bi bi-person-badge-fill"></i>
        <span>Pegawai</span>
    </button>
</div>

{{-- Error global --}}
@if ($errors->any())
    <div class="auth-alert">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>{{ $errors->first() }}</div>
    </div>
@endif

{{-- Form Login Siswa --}}
<div id="formSiswa">
    <form method="POST" action="{{ route('siswa.login') }}">
        @csrf

        <div class="auth-field">
            <label class="auth-label">Nomor Induk Siswa (NIS)</label>
            <div class="auth-input-wrap">
                <i class="bi bi-person-fill auth-input-icon"></i>
                <input
                    type="text"
                    name="nis"
                    class="auth-input @error('nis') is-invalid @enderror"
                    placeholder="Masukkan NIS kamu..."
                    value="{{ old('nis') }}"
                    autocomplete="off"
                    autofocus>
            </div>
            @error('nis')
                <div class="auth-error">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <div class="auth-field">
            <label class="auth-label">Password</label>
            <div class="auth-input-wrap">
                <i class="bi bi-lock-fill auth-input-icon"></i>
                <input
                    type="password"
                    name="password"
                    class="auth-input @error('password') is-invalid @enderror"
                    placeholder="Masukkan password kamu...">
            </div>
            @error('password')
                <div class="auth-error">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="auth-submit btn-siswa">
            <i class="bi bi-box-arrow-in-right"></i> Masuk sebagai Siswa
        </button>
    </form>

    <div class="auth-divider">
        <div class="auth-divider-line"></div>
        <div class="auth-divider-text">Belum punya akun?</div>
        <div class="auth-divider-line"></div>
    </div>

    <div class="auth-bottom-link">
        Belum terdaftar? <a href="{{ route('siswa.register') }}">Daftar Sekarang <i class="bi bi-arrow-right"></i></a>
    </div>
</div>

{{-- Form Login Pegawai --}}
<div id="formPegawai" style="display: none;">
    <form method="POST" action="{{ route('pegawai.login') }}">
        @csrf

        <div class="auth-field">
            <label class="auth-label">Nomor Induk Pegawai (NIP)</label>
            <div class="auth-input-wrap">
                <i class="bi bi-person-badge-fill auth-input-icon"></i>
                <input
                    type="text"
                    name="nip"
                    class="auth-input @error('nip') is-invalid @enderror"
                    placeholder="Masukkan NIP kamu..."
                    value="{{ old('nip') }}"
                    autocomplete="off">
            </div>
            @error('nip')
                <div class="auth-error">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <div class="auth-field">
            <label class="auth-label">Password</label>
            <div class="auth-input-wrap">
                <i class="bi bi-lock-fill auth-input-icon"></i>
                <input
                    type="password"
                    name="password"
                    class="auth-input @error('password') is-invalid @enderror"
                    placeholder="Masukkan password kamu...">
            </div>
            @error('password')
                <div class="auth-error">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="auth-submit btn-pegawai">
            <i class="bi bi-box-arrow-in-right"></i> Masuk sebagai Pegawai
        </button>
    </form>
</div>

{{-- Style tambahan --}}
<style>
    .role-selector {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
    }

    .role-btn {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        padding: 14px 10px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        background: #f8fafc;
        color: #94a3b8;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .role-btn i {
        font-size: 24px;
    }

    .role-btn:hover {
        border-color: #cbd5e1;
        color: #64748b;
    }

    /* Active state siswa */
    .role-btn.active#btnSiswa {
        border-color: #16a34a;
        background: #f0fdf4;
        color: #16a34a;
    }

    /* Active state pegawai */
    .role-btn.active#btnPegawai {
        border-color: #2563eb;
        background: #eff6ff;
        color: #2563eb;
    }

    .btn-siswa {
        background: #16a34a !important;
    }

    .btn-siswa:hover {
        background: #15803d !important;
    }

    .btn-pegawai {
        background: #2563eb !important;
    }

    .btn-pegawai:hover {
        background: #1d4ed8 !important;
    }
</style>

{{-- Script switch role --}}
<script>
    function switchRole(role) {
        const formSiswa   = document.getElementById('formSiswa');
        const formPegawai = document.getElementById('formPegawai');
        const btnSiswa    = document.getElementById('btnSiswa');
        const btnPegawai  = document.getElementById('btnPegawai');

        if (role === 'siswa') {
            formSiswa.style.display   = 'block';
            formPegawai.style.display = 'none';
            btnSiswa.classList.add('active');
            btnPegawai.classList.remove('active');
        } else {
            formSiswa.style.display   = 'none';
            formPegawai.style.display = 'block';
            btnPegawai.classList.add('active');
            btnSiswa.classList.remove('active');
        }
    }

    // Auto-switch ke pegawai jika ada error NIP dari session
    @if(old('nip') || $errors->has('nip'))
        switchRole('pegawai');
    @endif
</script>

@endsection