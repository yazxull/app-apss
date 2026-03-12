@extends('layouts.siswa')

@section('title', 'Laporan Pengaduan')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                Laporan Pengaduan
            </h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-8">

                    {{-- Kategori --}}
                    <div class="mb-4">
                        <div class="text-muted small">Kategori</div>
                        <div class="fw-semibold">
                            {{ $laporan->kategori->nama_kategori ?? '-' }}
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="mb-4">
                        <div class="text-muted small">Lokasi Kejadian</div>
                        <div class="fw-semibold">
                            {{ $laporan->lokasi }}
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-4">
                        <div class="text-muted small">Keterangan</div>
                        <div>
                            {{ $laporan->ket }}
                        </div>
                    </div>

                    {{-- Tanggapan Admin --}}
                    @include('siswa.laporan.tanggapan')

                    {{-- Feedback --}}
                    @if ($laporan->aspirasi?->status == 'selesai')
                        @include('siswa.laporan.feedback')
                    @endif

                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection
