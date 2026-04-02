<?php

namespace App\Livewire\Armada;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Armada;

#[Layout('layouts.app')]
#[Title('Detail Armada')]
class Show extends Component
{
    public Armada $armada;

    public function mount(Armada $armada): void
    {
        $this->armada = $armada;
    }

    public function setAvailable(): void
    {
        if (!in_array($this->armada->status, ['in_use', 'maintenance', 'inactive'])) {
            return;
        }

        $this->armada->update(['status' => 'available']);
        $this->armada->refresh();

        session()->flash('success', 'Status armada diubah menjadi Tersedia.');

        $this->redirect(route('armada.show', $this->armada), navigate: false);
    }

    public function setMaintenance(): void
    {
        if (!in_array($this->armada->status, ['available', 'in_use'])) {
            return;
        }

        $this->armada->update(['status' => 'maintenance']);
        $this->armada->refresh();

        session()->flash('success', 'Status armada diubah menjadi Perawatan.');

        $this->redirect(route('armada.show', $this->armada), navigate: false);
    }

    public function setInactive(): void
    {
        if (!in_array($this->armada->status, ['available', 'maintenance'])) {
            return;
        }

        $this->armada->update(['status' => 'inactive']);
        $this->armada->refresh();

        session()->flash('success', 'Status armada diubah menjadi Tidak Aktif.');

        $this->redirect(route('armada.show', $this->armada), navigate: false);
    }

    public function render()
    {
        return view('livewire.armada.show');
    }
}
