<div class="card mb-3">
    <div class="card-body">
        <table class="table table-borderless">
            <tr>
                <th width="200">Nama Siswa</th>
                <td>{{ $laporan->is_anonim ? 'Siswa Anonim' : $laporan->siswa->nama }} <br><small class="text-muted">NIS: {{ $laporan->is_anonim ? 'Disembunyikan' : $laporan->siswa->nis }} | Kelas: {{ $laporan->is_anonim ? 'Disembunyikan' : $laporan->siswa->kelas }}</small></td>
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
                <th>Bukti Foto</th>
                <td>
                    @if($laporan->foto)
                        <img src="{{ asset('uploads/laporan/'.$laporan->foto) }}" alt="Bukti Laporan" class="img-fluid rounded" style="max-height: 200px;">
                    @else
                        <span class="text-muted">Tidak ada lampiran gambar</span>
                    @endif
                </td>
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
            @if ($laporan->aspirasi?->alasan)
            <tr>
                <th>Alasan Ketidakpuasan</th>
                <td>
                    <div class="alert alert-warning mb-0 py-2 px-3">
                        {{ $laporan->aspirasi->alasan }}
                    </div>
                </td>
            </tr>
            @endif
        </table>
    </div>
</div>