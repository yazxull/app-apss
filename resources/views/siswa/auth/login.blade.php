@extends('layouts.auth')
@section('title', 'Login')
@section('content')
<div action="" class="card shadow-sm" style="width: 400px">
    <div class="card-header text-center">
        <h5 class="card-title mb-0">Login Siswa</h5>
    </div>
    <form class="card-body" method="post"
        action="{{ route('siswa.login') }}">
        @csrf

        {{-- NIS --}}
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-person"></i>
                </span>
                <input type="text"
                    class="form-control @error('nis') is-invalid @enderror"
                    name="nis"
                    placeholder="NIS">
            </div>
            @error('nis')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="d-grid mb-2">
            <button type="submit" class="btn btn-primary">
                Login
            </button>
        </div>
        <p class="text-center">
            Belum punya akun?
            <a href="{{ route('siswa.register') }}">Daftar Baru</a>
        </p>
    </form>
</div>
@endsection