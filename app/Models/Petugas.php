<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';

    protected $fillable = [
        'nama_petugas',
        'jabatan',
        'nomor_telepon',
        'wilayah_tugas',
        'status',
    ];
}
