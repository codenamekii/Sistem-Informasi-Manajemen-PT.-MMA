<?php

namespace App\Livewire\Akun;

use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class UbahPassword extends Component
{
  public string $current_password = '';
  public string $password = '';
  public string $password_confirmation = '';

  public function save(UpdateUserPassword $updater): void
  {
    $updater->update(auth()->user(), [
      'current_password' => $this->current_password,
      'password' => $this->password,
      'password_confirmation' => $this->password_confirmation,
    ]);

    $this->reset([
      'current_password',
      'password',
      'password_confirmation',
    ]);

    session()->flash('success', 'Password berhasil diperbarui.');
  }

  public function render(): View
  {
    return view('livewire.akun.ubah-password')
      ->title('Ubah Password');
  }
}