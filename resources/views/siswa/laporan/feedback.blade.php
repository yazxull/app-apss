<div class="mb-4">
    <div class="text-muted small mb-2">Feedback Kepuasan</div>

    @if ($laporan->aspirasi->feedback)

        {{-- SUDAH MEMBERI FEEDBACK --}}
        <div class="alert alert-success mb-0">
            Feedback telah diberikan:
            <strong>
                {{
                    [
                        1 => 'Tidak Puas',
                        2 => 'Kurang Puas',
                        3 => 'Cukup Puas',
                        4 => 'Puas',
                        5 => 'Sangat Puas',
                    ][$laporan->aspirasi->feedback] ?? '-'
                }}
            </strong>
        </div>

    @else

        {{-- BELUM MEMBERI FEEDBACK --}}
        <form action="{{ route('siswa.laporan.feedback', $laporan->aspirasi->id) }}"
              method="POST">
            @csrf

            <div class="d-flex flex-column gap-2">

                <label class="d-flex align-items-center gap-2">
                    <input type="radio" name="feedback" value="1">
                    <span>Tidak Puas</span>
                </label>

                <label class="d-flex align-items-center gap-2">
                    <input type="radio" name="feedback" value="2">
                    <span>Kurang Puas</span>
                </label>

                <label class="d-flex align-items-center gap-2">
                    <input type="radio" name="feedback" value="3">
                    <span>Cukup Puas</span>
                </label>

                <label class="d-flex align-items-center gap-2">
                    <input type="radio" name="feedback" value="4">
                    <span>Puas</span>
                </label>

                <label class="d-flex align-items-center gap-2">
                    <input type="radio" name="feedback" value="5">
                    <span>Sangat Puas</span>
                </label>

            </div>

            @error('feedback')
                <div class="text-danger small mt-2">
                    {{ $message }}
                </div>
            @enderror

            <button class="btn btn-primary btn-sm mt-3">
                Kirim Feedback
            </button>
        </form>

    @endif
</div>
