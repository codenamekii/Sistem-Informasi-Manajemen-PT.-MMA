<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Armada extends Model
{
    protected $fillable = [
        'kode_armada',
        'nomor_polisi',
        'jenis_kendaraan',
        'kapasitas',
        'status',
    ];
}
