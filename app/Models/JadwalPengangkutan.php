<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPengangkutan extends Model
{
    protected $fillable = [
        'kode_jadwal',
        'tanggal_pengangkutan',
        'nama_fasilitas',
        'armada',
        'petugas_pic',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengangkutan' => 'date',
        ];
    }
}
