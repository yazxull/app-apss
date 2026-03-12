@extends('layouts.admin')
@section('title', 'Kategori')

@section('content')
    <h4 class="mb-3 mt-3">Kategori</h4>

    <div class="card mb-3">
        <div class="card-body">
            {{-- Tombol Tambah Data --}}
            <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary mb-3">
                + Tambah Kategori
            </a>

            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif
        </div>

        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Kategori</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategori as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_kategori }}</td>
                            <td>
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.kategori.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                {{-- Form Hapus --}}
                                <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Data kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Navigasi Paginasi --}}
        <div class="card-footer pb-0">
            {{ $kategori->links() }}
        </div>
    </div>
@endsection