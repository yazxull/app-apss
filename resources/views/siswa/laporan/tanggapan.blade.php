<div class="mb-4">
    <div class="text-muted small">Tanggapan</div>

    @if ($laporan->aspirasi?->status === 'selesai')
        <span class="badge bg-success">
            <i class="bi bi-check-circle"></i>
            {{ ucwords($laporan->aspirasi?->status) }}
        </span>
    @elseif ($laporan->aspirasi?->status === 'proses')
        <span class="badge bg-warning">
            <i class="bi bi-hourglass-split"></i>
            {{ ucwords($laporan->aspirasi?->status) }}
        </span>
    @else
        <span class="badge bg-light text-dark">
            <i class="bi bi-hourglass-split"></i>
            Menunggu
        </span>

        {{-- Tombol Hapus --}}
        <form action="{{ route('siswa.laporan.destroy', $laporan->id) }}"
              method="POST" class="d-inline ms-3"
              onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
            @csrf
            @method('DELETE')

            <button class="btn btn-link text-danger p-0 align-baseline">
                <i class="bi bi-trash"></i>
                Hapus Laporan ini
            </button>
        </form>
    @endif
</div>
