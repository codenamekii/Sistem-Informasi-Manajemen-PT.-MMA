<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JadwalPengangkutan extends Model
{
  protected $fillable = [
    'kode_jadwal',
    'tanggal_pengangkutan',
    'nama_fasilitas',
    'armada',
    'petugas_pic',
    'status',
    'kerja_sama_id',
    'armada_id',
    'tanggal_realisasi',
    'total_limbah_kg',
    'harga_per_kg_realisasi',
    'total_biaya_realisasi',
    'manifest_elektronik_path',
    'bukti_foto_pengangkutan_path',
  ];

  protected function casts(): array
  {
    return [
      'tanggal_pengangkutan' => 'date',
      'tanggal_realisasi' => 'date',
      'total_limbah_kg' => 'decimal:2',
      'harga_per_kg_realisasi' => 'decimal:2',
      'total_biaya_realisasi' => 'decimal:2',
    ];
  }

  // ─── Relasi ───────────────────────────────────────────

  public function kerjaSama(): BelongsTo
  {
    return $this->belongsTo(KerjaSama::class);
  }

  public function armadaRelasi(): BelongsTo
  {
    return $this->belongsTo(Armada::class, 'armada_id');
  }

  public function petugas(): BelongsToMany
  {
    return $this->belongsToMany(
      Petugas::class,
      'jadwal_pengangkutan_petugas',
      'jadwal_pengangkutan_id',
      'petugas_id'
    )->withTimestamps();
  }

  // ─── Query Scopes ─────────────────────────────────────

  /**
   * Hanya record completed — sumber data realisasi.
   */
  public function scopeRealisasi(Builder $query): Builder
  {
    return $query->where('status', 'completed');
  }

  /**
   * Completed dengan bukti lengkap.
   */
  public function scopeBuktiLengkap(Builder $query): Builder
  {
    return $query->realisasi()
      ->whereNotNull('manifest_elektronik_path')
      ->whereNotNull('bukti_foto_pengangkutan_path');
  }

  /**
   * Completed tetapi bukti belum lengkap.
   */
  public function scopeBuktiBelumLengkap(Builder $query): Builder
  {
    return $query->realisasi()
      ->where(function (Builder $q): void {
        $q->whereNull('manifest_elektronik_path')
          ->orWhereNull('bukti_foto_pengangkutan_path');
      });
  }

  // ─── Accessor display ─────────────────────────────────

  public function getNamaFasilitasDisplayAttribute(): string
  {
    return $this->kerjaSama?->nama_fasilitas_display
      ?: ($this->nama_fasilitas ?: '—');
  }

  public function getArmadaDisplayAttribute(): string
  {
    if ($this->armadaRelasi) {
      return $this->armadaRelasi->nomor_polisi
        . ' (' . $this->armadaRelasi->jenis_kendaraan . ')';
    }

    return $this->armada ?: '—';
  }

  public function getHasBuktiLengkapAttribute(): bool
  {
    return $this->status === 'completed'
      && !empty($this->manifest_elektronik_path)
      && !empty($this->bukti_foto_pengangkutan_path);
  }

  public function getHargaPerKgRealisasiRupiahAttribute(): string
  {
    if ($this->harga_per_kg_realisasi === null || $this->harga_per_kg_realisasi === '') {
      return '—';
    }

    return 'Rp ' . number_format((float) $this->harga_per_kg_realisasi, 0, ',', '.') . '/kg';
  }

  public function getTotalBiayaRealisasiRupiahAttribute(): string
  {
    if ($this->total_biaya_realisasi === null || $this->total_biaya_realisasi === '') {
      return '—';
    }

    return 'Rp ' . number_format((float) $this->total_biaya_realisasi, 0, ',', '.');
  }

  public function getTotalLimbahKgDisplayAttribute(): string
  {
    if ($this->total_limbah_kg === null || $this->total_limbah_kg === '') {
      return '—';
    }

    return rtrim(rtrim(number_format((float) $this->total_limbah_kg, 2, ',', '.'), '0'), ',') . ' kg';
  }
}