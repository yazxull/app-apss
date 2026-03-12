@extends('layouts.admin')

@section('content')
<div class="row g-3 mb-4 mt-3">
    
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Total Siswa</div>
                <h3>{{ $totalSiswa ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Total Laporan</div>
                <h3>{{ $totalLaporan ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Laporan Diproses</div>
                <h3>{{ $laporanProses ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Laporan Selesai</div>
                <h3>{{ $laporanSelesai ?? 0 }}</h3>
            </div>
        </div>
    </div>

</div>

@include('admin.list-laporan')
@endsection