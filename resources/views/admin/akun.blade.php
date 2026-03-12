@extends('layouts.admin')

@section('title', 'Akun Saya')

@section('content')
<h1 class="mt-3">Pengaturan Akun</h1>
<hr>

<div class="row mb-3">
    <div class="col-md-5">
        
        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- FORM PROFIL --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h6 class="mb-0">Pengaturan Profil Admin</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.akun') }}" method="POST">
                    @csrf
                    
                    <x-input name="nama" placeholder="Nama" :value="$admin->nama" />
                    <x-input name="username" placeholder="Username" :value="$admin->username" />
                    
                    <button class="btn btn-primary">
                        <i class="bi bi-database"></i> Update
                    </button>
                </form>
            </div>
        </div>

        {{-- FORM PASSWORD --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">Ganti Password</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.akun.password') }}" method="POST">
                    @csrf

                    <x-input type="password" name="password_lama" placeholder="Password Lama" />
                    <x-input type="password" name="password_baru" placeholder="Password Baru" />
                    <x-input type="password" name="password_baru_confirmation" placeholder="Konfirmasi Password Baru" />
                    
                    <button class="btn btn-warning">
                        <i class="bi bi-key"></i> Ganti Password
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection