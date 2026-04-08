<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SiswaImportController extends Controller
{
    /**
     * Download template format Excel siswa.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        // Header kolom di baris 1
        $sheet->setCellValue('A1', 'NIS');
        $sheet->setCellValue('B1', 'NAMA');
        $sheet->setCellValue('C1', 'KELAS');
        $sheet->setCellValue('D1', 'PASSWORD');

        // Style header: bold + background hijau
        $headerStyle = [
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '16A34A'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

        // Lebar kolom otomatis
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);

        // Stream langsung ke browser tanpa simpan ke disk
        $writer   = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'format_import_siswa.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Proses import Excel siswa.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls|max:5120',
        ], [
            'file_excel.required' => 'Pilih file Excel terlebih dahulu.',
            'file_excel.mimes'    => 'File harus berformat .xlsx atau .xls.',
            'file_excel.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        try {
            $file        = $request->file('file_excel');
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet       = $spreadsheet->getActiveSheet();
            $rows        = $sheet->toArray(null, true, true, true);

            $berhasil = 0;
            $gagal    = [];

            // Data mulai baris ke-5
            foreach ($rows as $rowIndex => $row) {
                if ($rowIndex < 5) continue;

                $nis      = trim($row['A'] ?? '');
                $nama     = trim($row['B'] ?? '');
                $kelas    = trim($row['C'] ?? '');
                $password = trim($row['D'] ?? '');

                if ($nis === '' && $nama === '' && $kelas === '') continue;

                $validator = Validator::make(
                    ['nis' => $nis, 'nama' => $nama, 'kelas' => $kelas, 'password' => $password],
                    [
                        'nis'      => 'required|max:20|unique:siswas,nis',
                        'nama'     => 'required|max:100',
                        'kelas'    => 'required|max:20',
                        'password' => 'required|min:6',
                    ]
                );

                if ($validator->fails()) {
                    $gagal[] = [
                        'baris' => $rowIndex,
                        'nis'   => $nis ?: '-',
                        'nama'  => $nama ?: '-',
                        'pesan' => implode(', ', $validator->errors()->all()),
                    ];
                    continue;
                }

                Siswa::create([
                    'nis'      => $nis,
                    'nama'     => $nama,
                    'kelas'    => $kelas,
                    'password' => Hash::make($password),
                ]);

                $berhasil++;
            }

            $message = "Import selesai. {$berhasil} data siswa berhasil ditambahkan.";
            if (count($gagal) > 0) {
                $message .= ' ' . count($gagal) . ' baris gagal.';
                session(['import_siswa_gagal' => $gagal]);
            }

            return redirect()->route('admin.pengguna.siswa.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membaca file Excel: ' . $e->getMessage());
        }
    }
}
