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

                    {{-- Foto Bukti --}}
                    <div class="mb-4">
                        <div class="text-muted small">Foto Bukti / Lampiran</div>
                        <div>
                            @if($laporan->foto)
                                <img src="{{ asset('uploads/laporan/'.$laporan->foto) }}" alt="Bukti Laporan" class="img-fluid rounded mt-2" style="max-height: 200px;">
                            @else
                                <span class="text-muted">Tidak ada lampiran gambar</span>
                            @endif
                        </div>
                    </div>

                    {{-- Tanggapan Admin --}}
                    @include('siswa.laporan.tanggapan')

                    {{-- Feedback --}}
                    @if ($laporan->aspirasi?->status == 'selesai')
                        @include('siswa.laporan.feedback')
                    @endif

                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary mt-3">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                </div>

                <div class="col-md-4">
                    {{-- Ruang Komentar (Diskusi) --}}
                    <div class="card shadow-sm border border-light-subtle">
                        <div class="card-header bg-light border-bottom">
                            <h6 class="mb-0 fw-bold"><i class="bi bi-chat-dots me-2"></i> Ruang Diskusi / Komentar</h6>
                        </div>
                        <div class="card-body bg-white" style="max-height: 400px; overflow-y: auto;">
                            @forelse($laporan->komentar as $komen)
                                <div class="mb-3 {{ $komen->sender_type == 'siswa' ? 'text-end' : '' }}">
                                    <div class="d-inline-block p-3 rounded-4 {{ $komen->sender_type == 'siswa' ? 'bg-primary text-white shadow-sm' : 'bg-light border text-dark shadow-sm' }}" style="max-width: 85%;">
                                        <small class="d-block fw-bold mb-1">{{ $komen->sender_type == 'siswa' ? 'Anda' : 'Admin' }}</small>
                                        {{ $komen->pesan }}
                                        <small class="d-block {{ $komen->sender_type == 'siswa' ? 'text-white-50' : 'text-muted' }} mt-2" style="font-size: 0.65em;">{{ $komen->created_at->format('d M Y, H:i') }}</small>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted p-3">
                                    <i class="bi bi-chat-square text-secondary fs-1 d-block mb-2"></i>
                                    <small>Belum ada diskusi untuk laporan ini.</small>
                                </div>
                            @endforelse
                        </div>
                        <div class="card-footer bg-light border-top">
                            <form action="{{ route('siswa.laporan.komentar', $laporan->id) }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="pesan" class="form-control" placeholder="Tulis komentar..." required>
                                    <button class="btn btn-primary" type="submit"><i class="bi bi-send-fill"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
