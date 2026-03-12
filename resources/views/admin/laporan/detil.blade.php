<div class="card mb-3">
    <div class="card-body">
        <table class="table table-borderless">
            <tr>
                <th width="200">Nama Siswa</th>
                <td>{{ $laporan->siswa->nama }}</td>
            </tr>
            <tr>
                <th width="200">NIS</th>
                <td>{{ $laporan->siswa->nis }}</td>
            </tr>
            <tr>
                <th width="200">Kelas</th>
                <td>{{ $laporan->siswa->kelas }}</td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{{ $laporan->kategori->nama_kategori }}</td>
            </tr>
            <tr>
                <th>Laporan</th>
                <td>{{ $laporan->ket }}</td>
            </tr>
            <tr>
                <th>Lokasi</th>
                <td>{{ $laporan->lokasi }}</td>
            </tr>
            <tr>
                <th>Status Saat Ini</th>
                <td>
                    @if ($laporan->aspirasi?->status === 'selesai')
                        <span class="badge bg-success">Selesai</span>
                    @elseif ($laporan->aspirasi?->status === 'proses')
                        <span class="badge bg-warning">Proses</span>
                    @else
                        <span class="badge bg-secondary">Belum Diproses</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Feedback Kepuasan</th>
                <td>
                    <span class="badge bg-info">
                        {{ $laporan->feedback }}
                    </span>
                </td>
            </tr>
        </table>
    </div>
</div>