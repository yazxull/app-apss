@extends('layouts.siswa')

@section('content')
    <div class="container py-5">
        <div class="p-5 mb-4 bg-light rounded-4 shadow-sm text-center">
            <h1 class="display-5 fw-bold">APSS</h1>
            <p class="fs-5 text-muted">
                <strong>Aplikasi Pengaduan Sarana Sekolah</strong>
                adalah platform digital yang digunakan oleh siswa untuk
                melaporkan kerusakan, kekurangan, atau permasalahan pada
                sarana dan prasarana sekolah seperti ruang kelas,
                laboratorium, toilet, dan fasilitas pendukung lainnya
                secara mudah dan terstruktur.
            </p>

            @guest('siswa')
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="{{ route('siswa.login') }}"
                        class="btn btn-primary btn-lg">
                        Masuk Siswa
                    </a>
                    <a href="{{ route('siswa.register') }}"
                        class="btn btn-outline-secondary btn-lg">
                        Daftar
                    </a>
                </div>
            @endguest

        </div>
    </div>
@endsection