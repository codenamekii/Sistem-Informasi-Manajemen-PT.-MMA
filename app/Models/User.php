<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  /** @use HasFactory<UserFactory> */
  use HasFactory, Notifiable;

  // ─── Konstanta role ───────────────────────────────────

  const ROLE_SUPER_ADMIN = 'super_admin';
  const ROLE_ADMIN_OPERASIONAL = 'admin_operasional';
  const ROLE_KOORDINATOR_OPERASIONAL = 'koordinator_operasional';
  const ROLE_PETUGAS_LAPANGAN = 'petugas_lapangan';
  const ROLE_MANAJER_OPERASIONAL = 'manajer_operasional';
  const ROLE_DIREKTUR = 'direktur';

  public static function roles(): array
  {
    return [
      self::ROLE_SUPER_ADMIN => 'Super Admin',
      self::ROLE_ADMIN_OPERASIONAL => 'Admin Operasional',
      self::ROLE_KOORDINATOR_OPERASIONAL => 'Koordinator Operasional',
      self::ROLE_PETUGAS_LAPANGAN => 'Petugas Lapangan',
      self::ROLE_MANAJER_OPERASIONAL => 'Manajer Operasional',
      self::ROLE_DIREKTUR => 'Direktur',
    ];
  }

  // ─── Fillable / hidden / casts ────────────────────────

  protected $fillable = ['name', 'email', 'password', 'role'];

  protected $hidden = ['password', 'remember_token'];

  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  // ─── Helper: cek role ─────────────────────────────────

  public function isSuperAdmin(): bool
  {
    return $this->role === self::ROLE_SUPER_ADMIN;
  }

  public function isAdminOperasional(): bool
  {
    return $this->role === self::ROLE_ADMIN_OPERASIONAL;
  }

  public function isKoordinatorOperasional(): bool
  {
    return $this->role === self::ROLE_KOORDINATOR_OPERASIONAL;
  }

  public function isPetugasLapangan(): bool
  {
    return $this->role === self::ROLE_PETUGAS_LAPANGAN;
  }

  public function isManajerOperasional(): bool
  {
    return $this->role === self::ROLE_MANAJER_OPERASIONAL;
  }

  public function isDirektur(): bool
  {
    return $this->role === self::ROLE_DIREKTUR;
  }

  /**
   * Apakah user boleh membaca/mengakses area.
   * Dipakai di sidebar, middleware, dan guardAction trait.
   */
  public function canAccess(string $area): bool
  {
    if ($this->isSuperAdmin()) {
      return true;
    }

    if ($area === 'dashboard') {
      return true;
    }

    $akses = [
      self::ROLE_ADMIN_OPERASIONAL => [
        'fasilitas',
        'kerja_sama',
        'dokumen',
      ],
      self::ROLE_KOORDINATOR_OPERASIONAL => [
        'jadwal',
        'armada',
        'petugas',
        'realisasi',
      ],
      self::ROLE_PETUGAS_LAPANGAN => [
        'jadwal',
        'realisasi',
      ],
      self::ROLE_MANAJER_OPERASIONAL => [
        'realisasi',
        'laporan',
      ],
      self::ROLE_DIREKTUR => [
        'laporan',
      ],
    ];

    return in_array($area, $akses[$this->role] ?? [], true);
  }

  /**
   * Apakah user boleh melakukan write action (create/edit/delete)
   * di area tertentu. Dipakai untuk menyembunyikan tombol di UI.
   *
   * Catatan: ini tidak menggantikan guardAction di Livewire.
   * guardAction tetap wajib ada di component untuk proteksi nyata.
   */
  public function canWrite(string $area): bool
  {
    if ($this->isSuperAdmin()) {
      return true;
    }

    // Monitoring-only roles tidak boleh write ke mana pun
    if (
      in_array($this->role, [
        self::ROLE_MANAJER_OPERASIONAL,
        self::ROLE_DIREKTUR,
      ], true)
    ) {
      return false;
    }

    // Petugas lapangan hanya bisa write ke jadwal (realisasi/bukti)
    if ($this->isPetugasLapangan()) {
      return $area === 'jadwal';
    }

    // Role lain: boleh write jika bisa akses
    return $this->canAccess($area);
  }

  public function labelRole(): string
  {
    return self::roles()[$this->role] ?? $this->role;
  }
}