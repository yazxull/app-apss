@extends('layouts.auth')
@section('title', 'Register')
@section('content')
<div class="card shadow-sm" style="width: 400px">
    <div class="card-header text-center">
        <h5 class="card-title mb-0">Registrasi Siswa</h5>
    </div>

    <form class="card-body" method="POST"
        action="{{ route('siswa.register') }}">
        @csrf

        {{-- NIS --}}
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-person"></i>
                </span>
                <input type="text" name="nis"
                    class="form-control @error('nis') is-invalid @enderror"
                    placeholder="NIS"
                    value="{{ old('nis', $nis) }}">
            </div>
            @error('nis')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
            @enderror
        </div>

        {{-- Nama --}}
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-card-text"></i>
                </span>
                <input type="text" name="nama"
                    class="form-control @error('nama') is-invalid @enderror"
                    placeholder="Nama Lengkap"
                    value="{{ old('nama') }}">
            </div>
            @error('nama')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
            @enderror
        </div>

        {{-- Kelas --}}
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-mortarboard"></i>
                </span>
                <input type="text" name="kelas"
                    class="form-control @error('kelas') is-invalid @enderror"
                    placeholder="Kelas (contoh: X PPLG Z)"
                    value="{{ old('kelas') }}">
            </div>
            @error('kelas')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="d-grid mb-2">
            <button type="submit" class="btn btn-primary">
                Daftar
            </button>
        </div>

        <p class="text-center mb-0">
            Sudah punya akun?
            <a href="{{ route('siswa.login') }}">Login</a>
        </p>
    </form>
</div>
@endsection