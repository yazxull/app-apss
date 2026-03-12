<div class="card shadow-sm">
    <div class="card-header bg-white">
        <strong>Laporan Terbaru</strong>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Siswa</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporanTerbaru ?? [] as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->siswa->nama ?? '-' }}</td>
                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td>
                        @php
                            // Menentukan warna badge berdasarkan status
                            $badge = $item->aspirasi?->status === 'selesai' ? 'success' : 'danger';
                        @endphp
                        <span class="badge bg-{{ $badge }}">
                            {{ ucfirst($item->aspirasi?->status ?? 'baru') }}
                        </span>
                    </td>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">
                        Belum ada laporan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>