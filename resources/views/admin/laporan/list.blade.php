<table class="table table-striped mb-0">
    <thead>
        <tr>
            <th>No</th>
            <th>Siswa</th>
            <th>Kategori</th>
            <th>Laporan</th>
            <th>Status</th>
            <th>Feedback</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($laporan as $item)
            <tr>
                {{-- Penomoran otomatis yang mendukung paginasi --}}
                <td>{{ $loop->iteration + $laporan->firstItem() - 1 }}</td>
                
                <td>{{ $item->siswa->nama ?? '-' }}</td>
                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                
                {{-- Membatasi teks laporan agar tidak terlalu panjang di tabel --}}
                <td>{{ Str::limit($item->ket, 50) }}</td>
                
                <td>
                    @if ($item->status === 'selesai')
                        <span class="badge bg-success">Selesai</span>
                    @elseif ($item->status === 'proses')
                        <span class="badge bg-warning">Proses</span>
                    @else
                        <span class="badge bg-secondary">Belum Diproses</span>
                    @endif
                </td>
                
                <td>{{ $item->feedback }}</td>
                
                <td>
                    <a href="{{ route('admin.laporan.show', $item->id) }}" class="btn btn-sm btn-primary">
                        Detail
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Data tidak tersedia</td>
            </tr>
        @endforelse
    </tbody>
</table>