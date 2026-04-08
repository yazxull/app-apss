@extends('layouts.auth')
@section('title', 'Daftar Akun Siswa')

@section('content')

<div class="auth-form-header">
    <div class="auth-form-icon">
        <i class="bi bi-person-plus-fill"></i>
    </div>
    <div class="auth-form-title">Buat Akun Baru</div>
    <div class="auth-form-sub">Daftarkan diri kamu sebagai siswa untuk mulai melapor.</div>
</div>

{{-- Error global --}}
@if ($errors->any() && !$errors->has('nis') && !$errors->has('nama') && !$errors->has('kelas'))
    <div class="auth-alert">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>{{ $errors->first() }}</div>
    </div>
@endif

<form method="POST" action="{{ route('siswa.register') }}">
    @csrf

    <div class="auth-field">
        <label class="auth-label">Nomor Induk Siswa (NIS)</label>
        <div class="auth-input-wrap">
            <i class="bi bi-person-badge-fill auth-input-icon"></i>
            <input
                type="text"
                name="nis"
                class="auth-input @error('nis') is-invalid @enderror"
                placeholder="Masukkan NIS kamu..."
                value="{{ old('nis', $nis ?? '') }}"
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
        <label class="auth-label">Nama Lengkap</label>
        <div class="auth-input-wrap">
            <i class="bi bi-card-text auth-input-icon"></i>
            <input
                type="text"
                name="nama"
                class="auth-input @error('nama') is-invalid @enderror"
                placeholder="Nama lengkap sesuai data sekolah..."
                value="{{ old('nama') }}">
        </div>
        @error('nama')
            <div class="auth-error">
                <i class="bi bi-exclamation-circle"></i> {{ $message }}
            </div>
        @enderror
    </div>

    <div class="auth-field">
        <label class="auth-label">Kelas</label>
        <div class="auth-input-wrap">
            <i class="bi bi-mortarboard-fill auth-input-icon"></i>
            <input
                type="text"
                name="kelas"
                class="auth-input @error('kelas') is-invalid @enderror"
                placeholder="Contoh: X PPLG A"
                value="{{ old('kelas') }}">
        </div>
        @error('kelas')
            <div class="auth-error">
                <i class="bi bi-exclamation-circle"></i> {{ $message }}
            </div>
        @enderror
    </div>

    <button type="submit" class="auth-submit">
        <i class="bi bi-person-check-fill"></i> Daftar Sekarang
    </button>
</form>

<div class="auth-divider">
    <div class="auth-divider-line"></div>
    <div class="auth-divider-text">Sudah punya akun?</div>
    <div class="auth-divider-line"></div>
</div>

<div class="auth-bottom-link">
    Sudah terdaftar? <a href="{{ route('siswa.login') }}">Masuk di sini <i class="bi bi-arrow-right"></i></a>
</div>

@endsection
