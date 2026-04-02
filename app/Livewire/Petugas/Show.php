<?php

namespace App\Livewire\Petugas;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Petugas;

#[Layout('layouts.app')]
#[Title('Detail Petugas')]
class Show extends Component
{
    public Petugas $petugas;

    public function mount(Petugas $petugas): void
    {
        $this->petugas = $petugas;
    }

    public function setActive(): void
    {
        if (!in_array($this->petugas->status, ['on_leave', 'inactive'])) {
            return;
        }

        $this->petugas->update(['status' => 'active']);
        $this->petugas->refresh();

        session()->flash('success', 'Status petugas diubah menjadi Aktif.');

        $this->redirect(route('petugas.show', $this->petugas), navigate: false);
    }

    public function setOnLeave(): void
    {
        if (!in_array($this->petugas->status, ['active'])) {
            return;
        }

        $this->petugas->update(['status' => 'on_leave']);
        $this->petugas->refresh();

        session()->flash('success', 'Status petugas diubah menjadi Cuti.');

        $this->redirect(route('petugas.show', $this->petugas), navigate: false);
    }

    public function setInactive(): void
    {
        if (!in_array($this->petugas->status, ['active', 'on_leave'])) {
            return;
        }

        $this->petugas->update(['status' => 'inactive']);
        $this->petugas->refresh();

        session()->flash('success', 'Status petugas diubah menjadi Tidak Aktif.');

        $this->redirect(route('petugas.show', $this->petugas), navigate: false);
    }

    public function render()
    {
        return view('livewire.petugas.show');
    }
}
