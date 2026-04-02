<?php

namespace App\Livewire\KerjaSama;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\KerjaSama;

#[Layout('layouts.app')]
#[Title('Detail Kerja Sama')]
class Show extends Component
{
    public KerjaSama $kerjaSama;

    public function mount(KerjaSama $kerjaSama): void
    {
        $this->kerjaSama = $kerjaSama;
    }

    public function terminate(): void
    {
        if ($this->kerjaSama->status === 'terminated') {
            return;
        }

        $this->kerjaSama->update(['status' => 'terminated']);
        $this->kerjaSama->refresh();

        session()->flash('success', 'Kerja sama berhasil diakhiri.');

        $this->redirect(
            route('kerja-sama.show', $this->kerjaSama),
            navigate: false
        );
    }

    public function activate(): void
    {
        if ($this->kerjaSama->status !== 'terminated') {
            return;
        }

        $this->kerjaSama->update(['status' => 'active']);
        $this->kerjaSama->refresh();

        session()->flash('success', 'Kerja sama berhasil diaktifkan kembali.');

        $this->redirect(
            route('kerja-sama.show', $this->kerjaSama),
            navigate: false
        );
    }

    public function render()
    {
        return view('livewire.kerja-sama.show');
    }
}
