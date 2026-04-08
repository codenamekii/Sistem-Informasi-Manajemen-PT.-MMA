<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KerjaSama extends Model
{
    protected $fillable = [
        'nomor_perjanjian',
        'fasilitas_kesehatan_id',
        'nama_fasilitas_kesehatan',
        'harga_per_kilogram',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_berakhir' => 'date',
            'harga_per_kilogram' => 'decimal:2',
        ];
    }

    public function fasilitasKesehatan(): BelongsTo
    {
        return $this->belongsTo(FasilitasKesehatan::class);
    }

    public function getNamaFasilitasDisplayAttribute(): string
    {
        return $this->fasilitasKesehatan?->nama
            ?: ($this->nama_fasilitas_kesehatan ?: '—');
    }

    public function getHargaPerKilogramRupiahAttribute(): string
    {
        if ($this->harga_per_kilogram === null || $this->harga_per_kilogram === '') {
            return '—';
        }

        return 'Rp ' . number_format((float) $this->harga_per_kilogram, 0, ',', '.') . '/kg';
    }

    public function getIsConnectedToFasilitasAttribute(): bool
    {
        return ! is_null($this->fasilitas_kesehatan_id);
    }
}
