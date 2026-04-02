<?php

namespace App\Livewire\Dokumen;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Dokumen;

#[Layout('layouts.app')]
#[Title('Dokumen')]
class Index extends Component
{
    public string $search = '';

    public function getDokumenProperty()
    {
        return Dokumen::query()
            ->when($this->search !== '', function ($query) {
                $query->where('nama_dokumen', 'like', "%{$this->search}%")
                    ->orWhere('terkait_dengan', 'like', "%{$this->search}%")
                    ->orWhere('kategori_dokumen', 'like', "%{$this->search}%");
            })
            ->orderByRaw("FIELD(status, 'expiring_soon', 'expired', 'missing', 'valid')")
            ->orderBy('tanggal_berlaku_sampai', 'asc')
            ->get();
    }

    public function getTotalProperty(): int
    {
        return $this->dokumen->count();
    }

    public function getValidProperty(): int
    {
        return $this->dokumen->where('status', 'valid')->count();
    }

    public function getExpiringSoonProperty(): int
    {
        return $this->dokumen->where('status', 'expiring_soon')->count();
    }

    public function getExpiredProperty(): int
    {
        return $this->dokumen->where('status', 'expired')->count();
    }

    public function render()
    {
        return view('livewire.dokumen.index');
    }
}
