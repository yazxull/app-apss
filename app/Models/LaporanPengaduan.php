<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'kategori_id',
        'ket',
        'lokasi',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function aspirasi()
    {
        return $this->hasOne(Aspirasi::class, 'laporan_id');
    }
}
