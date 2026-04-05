<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rekap Laporan Pengaduan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>REKAPITULASI LAPORAN PENGADUAN</h2>
        <p>Bulan: {{ $bulan }} | Tahun: {{ $tahun }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Lokasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporan as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $item->is_anonim ? 'Anonim' : $item->siswa->nama }}</td>
                    <td>{{ $item->kategori->nama_kategori }}</td>
                    <td>{{ Str::limit($item->ket, 50) }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>
                        {{ ucfirst($item->aspirasi ? $item->aspirasi->status : 'Menunggu') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada laporan pada periode ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
