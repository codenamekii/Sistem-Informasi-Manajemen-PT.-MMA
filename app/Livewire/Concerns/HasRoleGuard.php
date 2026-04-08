<?php

namespace App\Livewire\Concerns;

trait HasRoleGuard
{
  /**
   * Cek apakah user boleh menjalankan aksi di area ini.
   * Dipanggil di awal setiap write action Livewire.
   *
   * Penggunaan:
   *   if (! $this->guardAction('fasilitas')) return null;
   *
   * @param string $area  Konsisten dengan canAccess() di User model
   */
  protected function guardAction(string $area): bool
  {
    $user = auth()->user();

    if (!$user || !$user->canAccess($area)) {
      session()->flash('error', 'Anda tidak memiliki akses untuk melakukan aksi ini.');
      $this->redirect(route('dashboard'), navigate: true);
      return false;
    }

    return true;
  }
}