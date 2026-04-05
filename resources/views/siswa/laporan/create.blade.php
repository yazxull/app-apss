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
                    <form action="{{ route('siswa.laporan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Kategori --}}
                        <x-select label="Kategori" name="kategori_id"
                            :options="$kategori" label-field="nama_kategori" />

                        {{-- Lokasi --}}
                        <x-input label="Lokasi Kejadian" name="lokasi"
                            placeholder="Contoh: Ruang Kelas X RPL A" />

                        {{-- Foto Bukti --}}
                        <div class="mb-3">
                            <label for="foto" class="form-label text-white">Foto Bukti / Lampiran (Opsional)</label>
                            <input class="form-control text-white border-secondary bg-dark" type="file" id="foto" name="foto" accept="image/*">
                        </div>

                        {{-- Keterangan --}}
                        <x-textarea label="Keterangan" name="ket"
                            placeholder="Masukkan keterangan..." rows="5" />

                        {{-- Anonim Check --}}
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_anonim" id="is_anonim">
                            <label class="form-check-label text-white" for="is_anonim">
                                Kirim secara Anonim (Sembunyikan nama dari admin)
                            </label>
                        </div>

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
