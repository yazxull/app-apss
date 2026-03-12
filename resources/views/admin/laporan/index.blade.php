@extends('layouts.admin')

@section('title', 'Daftar Laporan dan Aspirasi')

@section('content')
    <h4 class="mb-4 mt-3">Daftar Laporan dan Aspirasi</h4>

    {{-- Pesan Sukses --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            {{-- Form Filter Status --}}
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="mb-3">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Filter Status</label>
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Semua Status --</option>
                            <option value="belum" {{ request('status') === 'belum' ? 'selected' : '' }}>
                                Belum Diproses
                            </option>
                            <option value="proses" {{ request('status') === 'proses' ? 'selected' : '' }}>
                                Proses
                            </option>
                            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary w-100">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Memanggil Partial Tabel Laporan --}}
        <div class="card-body table-responsive p-0">
            @include('admin.laporan.list')
        </div>

        {{-- Navigasi Paginasi --}}
        <div class="card-footer pb-0">
            {{ $laporan->links() }}
        </div>
    </div>
@endsection