<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokumen extends Model
{
    protected $fillable = [
        'nama_dokumen',
        'kategori_dokumen',
        'nomor_referensi',
        'terkait_dengan',
        'kerja_sama_id',
        'tanggal_berlaku_sampai',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_berlaku_sampai' => 'date',
        ];
    }

    public function kerjaSama(): BelongsTo
    {
        return $this->belongsTo(KerjaSama::class);
    }

    public function getKerjaSamaDisplayAttribute(): string
    {
        if ($this->kerjaSama) {
            $namaFasilitas = $this->kerjaSama->fasilitasKesehatan?->nama
                ?: ($this->kerjaSama->nama_fasilitas_kesehatan ?: '—');

            return $this->kerjaSama->nomor_perjanjian . ' - ' . $namaFasilitas;
        }

        return $this->terkait_dengan ?: '—';
    }

    public function getTerkaitDenganDisplayAttribute(): string
    {
        return $this->kerja_sama_display;
    }

    public function getIsConnectedToKerjaSamaAttribute(): bool
    {
        return ! is_null($this->kerja_sama_id);
    }
}
