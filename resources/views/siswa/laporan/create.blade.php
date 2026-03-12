@extends('layouts.siswa')

@section('title', 'Buat Laporan Pengaduan')

@section('content')
    <div class="card mt-5">
        <div class="card-header">
            <h5 class="card-title">
                Buat Laporan Pengaduan
            </h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('siswa.laporan.store') }}" method="POST">
                        @csrf

                        {{-- Kategori --}}
                        <x-select label="Kategori" name="kategori_id"
                            :options="$kategori" label-field="nama_kategori" />

                        {{-- Lokasi --}}
                        <x-input label="Lokasi Kejadian" name="lokasi"
                            placeholder="Contoh: Ruang Kelas X RPL A" />

                        {{-- Keterangan --}}
                        <x-textarea label="Keterangan" name="ket"
                            placeholder="Masukkan keterangan..." rows="5" />

                        <div class="d-grid">
                            <button class="btn btn-primary">
                                <i class="bi bi-send"></i>
                                Kirim Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
