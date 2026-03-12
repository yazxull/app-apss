@extends('layouts.siswa')

@section('title', 'Akun Saya')

@section('content')
<h1 class="mt-3">Akun Saya</h1>
<hr>
<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                {{-- Alert Success --}}
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('siswa.akun.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- NIS --}}
                    <label class="form-label">NIS</label>
                    <x-input name="nis" :value="$siswa->nis" />

                    {{-- Nama --}}
                    <label class="form-label">Nama Lengkap</label>
                    <x-input name="nama" :value="$siswa->nama" />

                    {{-- Kelas --}}
                    <label class="form-label">Kelas</label>
                    <x-input name="kelas" :value="$siswa->kelas" />

                    <div class="d-grid">
                        <button class="btn btn-primary">
                            <i class="bi bi-database"></i>
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection