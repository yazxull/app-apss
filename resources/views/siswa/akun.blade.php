@extends('layouts.siswa')

@section('title', 'Akun Saya')

@push('css')
<style>
    :root { --primary: #2563EB; --body-bg: #F8FAFC; --border: #E2E8F0; --text-primary: #0F172A; --text-secondary: #64748B; --radius: 12px; --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.04); }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--body-bg); }
    .card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow); }
    .card-header { background: transparent; border-bottom: 1px solid var(--border); padding: 15px 20px; font-weight: 600; font-size: 14px; }
    .card-body { padding: 20px; }
    .form-label { font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px; }
    .form-control { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; border: 1.5px solid var(--border); border-radius: 8px; padding: 9px 13px; }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.1); outline: none; }
    .btn { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; font-size: 13.5px; border-radius: 8px; border: none; padding: 9px 18px; transition: all 0.15s; }
    .btn-primary { background: var(--primary); color: white; }
    .btn-primary:hover { background: #1D4ED8; color: white; }
    .alert { border: none; border-radius: 8px; font-size: 13.5px; font-weight: 500; padding: 12px 16px; }
    .alert-success { background: #ECFDF5; color: #065F46; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="alert alert-success mb-4 d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="font-size:12px;"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><i class="bi bi-person-fill me-2" style="color:#2563EB;"></i>Profil Saya</div>
            <div class="card-body">
                <form action="{{ route('siswa.akun.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">NIS</label>
                        <x-input name="nis" :value="$siswa->nis" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <x-input name="nama" :value="$siswa->nama" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <x-input name="kelas" :value="$siswa->kelas" />
                    </div>
                    <button class="btn btn-primary w-100"><i class="bi bi-check-lg me-1"></i>Update Profil</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
