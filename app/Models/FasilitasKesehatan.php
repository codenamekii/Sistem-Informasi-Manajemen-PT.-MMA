<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasKesehatan extends Model
{
    protected $fillable = [
        'nama',
        'jenis_fasilitas',
        'kota_kabupaten',
        'status',
    ];
}
