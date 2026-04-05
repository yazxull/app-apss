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

        {{-- Tampilkan alasan jika ada --}}
        @if ($laporan->aspirasi->alasan)
            <div class="alert alert-warning mt-2 mb-0">
                <strong>Alasan:</strong>
                <p class="mb-0 mt-1">{{ $laporan->aspirasi->alasan }}</p>
            </div>
        @endif

    @else

        {{-- BELUM MEMBERI FEEDBACK --}}
        <form action="{{ route('siswa.laporan.feedback', $laporan->aspirasi->id) }}"
              method="POST">
            @csrf

            <div class="d-flex flex-column gap-2">

                <label class="d-flex align-items-center gap-2">
                    <input type="radio" name="feedback" value="1" class="feedback-radio"
                           {{ old('feedback') == '1' ? 'checked' : '' }}>
                    <span>Tidak Puas</span>
                </label>

                <label class="d-flex align-items-center gap-2">
                    <input type="radio" name="feedback" value="2" class="feedback-radio"
                           {{ old('feedback') == '2' ? 'checked' : '' }}>
                    <span>Kurang Puas</span>
                </label>

                <label class="d-flex align-items-center gap-2">
                    <input type="radio" name="feedback" value="3" class="feedback-radio"
                           {{ old('feedback') == '3' ? 'checked' : '' }}>
                    <span>Cukup Puas</span>
                </label>

                <label class="d-flex align-items-center gap-2">
                    <input type="radio" name="feedback" value="4" class="feedback-radio"
                           {{ old('feedback') == '4' ? 'checked' : '' }}>
                    <span>Puas</span>
                </label>

                <label class="d-flex align-items-center gap-2">
                    <input type="radio" name="feedback" value="5" class="feedback-radio"
                           {{ old('feedback') == '5' ? 'checked' : '' }}>
                    <span>Sangat Puas</span>
                </label>

            </div>

            @error('feedback')
                <div class="text-danger small mt-2">
                    {{ $message }}
                </div>
            @enderror

            {{-- Form Alasan (muncul saat pilih Tidak Puas / Kurang Puas) --}}
            <div id="alasan-container" class="mt-3" style="display: {{ in_array(old('feedback'), ['1', '2']) ? 'block' : 'none' }};">
                <label for="alasan" class="form-label fw-semibold">
                    Alasan ketidakpuasan <span class="text-danger">*</span>
                </label>
                <textarea name="alasan" id="alasan" rows="3"
                          class="form-control @error('alasan') is-invalid @enderror"
                          placeholder="Jelaskan alasan mengapa Anda tidak puas dengan hasil yang diberikan...">{{ old('alasan') }}</textarea>
                @error('alasan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button class="btn btn-primary btn-sm mt-3">
                Kirim Feedback
            </button>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const radios = document.querySelectorAll('.feedback-radio');
                const alasanContainer = document.getElementById('alasan-container');
                const alasanTextarea = document.getElementById('alasan');

                radios.forEach(function (radio) {
                    radio.addEventListener('change', function () {
                        if (this.value === '1' || this.value === '2') {
                            alasanContainer.style.display = 'block';
                        } else {
                            alasanContainer.style.display = 'none';
                            alasanTextarea.value = '';
                        }
                    });
                });
            });
        </script>

    @endif
</div>
