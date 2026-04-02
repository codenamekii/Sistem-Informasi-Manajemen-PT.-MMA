<?php

namespace App\Livewire\FasilitasKesehatan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\FasilitasKesehatan;

#[Layout('layouts.app')]
#[Title('Detail Fasilitas Kesehatan')]
class Show extends Component
{
    public FasilitasKesehatan $fasilitas;

    public function mount(FasilitasKesehatan $fasilitasKesehatan): void
    {
        $this->fasilitas = $fasilitasKesehatan;
    }

    public function deactivate(): void
    {
        if ($this->fasilitas->status === 'inactive') {
            return;
        }

        $this->fasilitas->update(['status' => 'inactive']);
        $this->fasilitas->refresh();

        session()->flash('success', 'Fasilitas berhasil dinonaktifkan.');

        $this->redirect(
            route('fasilitas-kesehatan.show', $this->fasilitas),
            navigate: false
        );
    }

    public function activate(): void
    {
        if ($this->fasilitas->status !== 'inactive') {
            return;
        }

        $this->fasilitas->update(['status' => 'active']);
        $this->fasilitas->refresh();

        session()->flash('success', 'Fasilitas berhasil diaktifkan kembali.');

        $this->redirect(
            route('fasilitas-kesehatan.show', $this->fasilitas),
            navigate: false
        );
    }

    public function render()
    {
        return view('livewire.fasilitas-kesehatan.show');
    }
}
