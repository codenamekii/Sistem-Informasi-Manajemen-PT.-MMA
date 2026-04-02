<?php

namespace App\Livewire\Dokumen;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Dokumen;

#[Layout('layouts.app')]
#[Title('Detail Dokumen')]
class Show extends Component
{
    public Dokumen $dokumen;

    public function mount(Dokumen $dokumen): void
    {
        $this->dokumen = $dokumen;
    }

    public function markAsExpired(): void
    {
        if (!in_array($this->dokumen->status, ['valid', 'expiring_soon'])) {
            return;
        }

        $this->dokumen->update(['status' => 'expired']);
        $this->dokumen->refresh();

        session()->flash('success', 'Status dokumen diubah menjadi Kadaluarsa.');

        $this->redirect(route('dokumen.show', $this->dokumen), navigate: false);
    }

    public function markAsMissing(): void
    {
        if ($this->dokumen->status !== 'valid') {
            return;
        }

        $this->dokumen->update(['status' => 'missing']);
        $this->dokumen->refresh();

        session()->flash('success', 'Status dokumen diubah menjadi Tidak Ada.');

        $this->redirect(route('dokumen.show', $this->dokumen), navigate: false);
    }

    public function restore(): void
    {
        if (!in_array($this->dokumen->status, ['expired', 'missing'])) {
            return;
        }

        $this->dokumen->update(['status' => 'valid']);
        $this->dokumen->refresh();

        session()->flash('success', 'Dokumen berhasil diaktifkan kembali menjadi Valid.');

        $this->redirect(route('dokumen.show', $this->dokumen), navigate: false);
    }

    public function renew(): void
    {
        if ($this->dokumen->status !== 'expiring_soon') {
            return;
        }

        $this->dokumen->update(['status' => 'valid']);
        $this->dokumen->refresh();

        session()->flash('success', 'Dokumen berhasil diperpanjang dan diaktifkan kembali.');

        $this->redirect(route('dokumen.show', $this->dokumen), navigate: false);
    }

    public function render()
    {
        return view('livewire.dokumen.show');
    }
}
