@extends('layouts.admin')

@section('title', 'Laporan Aspirasi')

@section('content')
    <h4 class="mb-4 mt-3">Laporan Aspirasi</h4>

    {{-- Pesan Sukses --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
       
        <div class="col-md-8">
            @include('admin.laporan.detil')
        </div>

       
        <div class="col-md-4">
            @include('admin.laporan.form-status')

            {{-- Ruang Komentar (Diskusi) --}}
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">Ruang Diskusi / Komentar</h6>
                </div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                    @forelse($laporan->komentar as $komen)
                        <div class="mb-3 {{ $komen->sender_type == 'admin' ? 'text-end' : '' }}">
                            <div class="d-inline-block p-2 rounded {{ $komen->sender_type == 'admin' ? 'bg-primary text-white' : 'bg-light border' }}" style="max-width: 80%;">
                                <small class="d-block fw-bold mb-1">{{ $komen->sender_type == 'admin' ? 'Anda' : ($laporan->is_anonim ? 'Siswa Anonim' : $laporan->siswa->nama) }}</small>
                                {{ $komen->pesan }}
                                <small class="d-block {{ $komen->sender_type == 'admin' ? 'text-white-50' : 'text-muted' }} mt-1" style="font-size: 0.7em;">{{ $komen->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted"><small>Belum ada diskusi.</small></div>
                    @endforelse
                </div>
                <div class="card-footer">
                    <form action="{{ route('admin.laporan.komentar', $laporan->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="pesan" class="form-control" placeholder="Balas komentar..." required>
                            <button class="btn btn-primary" type="submit"><i class="bi bi-send"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection