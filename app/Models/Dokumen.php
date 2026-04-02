<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $fillable = [
        'nama_dokumen',
        'kategori_dokumen',
        'nomor_referensi',
        'terkait_dengan',
        'tanggal_berlaku_sampai',
        'status',
    ];

    protected $casts = [
        'tanggal_berlaku_sampai' => 'date',
    ];
}
