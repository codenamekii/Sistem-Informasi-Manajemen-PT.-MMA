<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KerjaSama extends Model
{
    protected $fillable = [
        'nomor_perjanjian',
        'nama_fasilitas_kesehatan',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai'    => 'date',
        'tanggal_berakhir' => 'date',
    ];
}
