<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\LaporanPengaduan;
use App\Models\Siswa;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Admin
        $admin = Admin::factory()->create([
            'nama' => 'Administrator',
            'username' => 'admin',
        ]);

        // Kategori
        $kategori = Kategori::factory()
            ->count(5)
            ->create();

        // Siswa
        $siswa = Siswa::factory()
            ->count(10)
            ->create();

        // Laporan Pengaduan
        $laporan = LaporanPengaduan::factory()
            ->count(15)
            ->make()
            ->each(function ($laporan) use ($siswa, $kategori) {
                $laporan->siswa_id = $siswa->random()->id;
                $laporan->kategori_id = $kategori->random()->id;
                $laporan->save();
            });

        // Aspirasi / Proses Admin
        $laporan->each(function ($laporan) use ($admin) {
            Aspirasi::factory()->create([
                'laporan_id' => $laporan->id,
                'admin_id' => $admin->id,
            ]);
        });
    }
}
