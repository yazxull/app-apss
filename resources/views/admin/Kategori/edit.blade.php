@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <h4 class="mb-3 mt-3">Edit Kategori</h4>

    <div class="card">
        {{-- Form diarahkan ke method update dengan parameter ID kategori --}}
        <form class="card-body" action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
            <div class="col">
                <div class="col-md-6">
                    @csrf
                    {{-- Method PUT wajib digunakan untuk proses update di Laravel --}}
                    @method('PUT')

                    {{-- Mengisi nilai awal input dengan data dari database --}}
                    <x-input name="nama_kategori" :value="$kategori->nama_kategori" placeholder="Nama Kategori" />

                    <div class="mt-3">
                        <button class="btn btn-primary">Update</button>
                        
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection