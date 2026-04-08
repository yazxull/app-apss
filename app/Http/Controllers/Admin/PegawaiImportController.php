<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PegawaiImportController extends Controller
{
    /**
     * Download template format Excel pegawai.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        // Header kolom di baris 1
        $sheet->setCellValue('A1', 'NAMA');
        $sheet->setCellValue('B1', 'NIP');
        $sheet->setCellValue('C1', 'JABATAN');
        $sheet->setCellValue('D1', 'PASSWORD');

        // Style header: bold + background biru
        $headerStyle = [
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

        // Lebar kolom
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(20);

        // Stream langsung ke browser tanpa simpan ke disk
        $writer   = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'format_import_pegawai.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Proses import Excel pegawai.
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

                $nama     = trim($row['A'] ?? '');
                $nip      = trim($row['B'] ?? '');
                $jabatan  = trim($row['C'] ?? '');
                $password = trim($row['D'] ?? '');

                if ($nama === '' && $nip === '') continue;

                $validator = Validator::make(
                    ['nama' => $nama, 'nip' => $nip, 'jabatan' => $jabatan, 'password' => $password],
                    [
                        'nama'     => 'required|max:100',
                        'nip'      => 'required|max:30|unique:pegawais,nip',
                        'jabatan'  => 'nullable|max:100',
                        'password' => 'required|min:6',
                    ]
                );

                if ($validator->fails()) {
                    $gagal[] = [
                        'baris' => $rowIndex,
                        'nip'   => $nip ?: '-',
                        'nama'  => $nama ?: '-',
                        'pesan' => implode(', ', $validator->errors()->all()),
                    ];
                    continue;
                }

                Pegawai::create([
                    'nama'     => $nama,
                    'nip'      => $nip,
                    'jabatan'  => $jabatan ?: null,
                    'password' => Hash::make($password),
                ]);

                $berhasil++;
            }

            $message = "Import selesai. {$berhasil} data pegawai berhasil ditambahkan.";
            if (count($gagal) > 0) {
                $message .= ' ' . count($gagal) . ' baris gagal.';
                session(['import_pegawai_gagal' => $gagal]);
            }

            return redirect()->route('admin.pengguna.pegawai.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membaca file Excel: ' . $e->getMessage());
        }
    }
}
