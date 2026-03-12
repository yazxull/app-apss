@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
    <h4 class="mb-3 mt-3">Tambah Kategori</h4>

    <div class="card">
        {{-- Form diarahkan ke method store di KategoriController --}}
        <form action="{{ route('admin.kategori.store') }}" method="POST" class="card-body">
            <div class="row">
                <div class="col-md-6">
                    @csrf

                    {{-- Menggunakan komponen input custom --}}
                    <x-input name="nama_kategori" placeholder="Nama Kategori" />

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                        
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection