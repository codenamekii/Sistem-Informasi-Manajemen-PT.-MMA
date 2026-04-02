<?php

namespace App\Livewire\Armada;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Armada;

#[Layout('layouts.app')]
#[Title('Armada')]
class Index extends Component
{
    public string $search = '';

    public function getArmadaProperty()
    {
        return Armada::query()
            ->when($this->search !== '', function ($query) {
                $query->where('kode_armada', 'like', "%{$this->search}%")
                    ->orWhere('nomor_polisi', 'like', "%{$this->search}%")
                    ->orWhere('jenis_kendaraan', 'like', "%{$this->search}%");
            })
            ->orderByRaw("FIELD(status, 'available', 'in_use', 'maintenance', 'inactive')")
            ->orderBy('kode_armada', 'asc')
            ->get();
    }

    public function getTotalProperty(): int
    {
        return $this->armada->count();
    }

    public function getAvailableProperty(): int
    {
        return $this->armada->where('status', 'available')->count();
    }

    public function getInUseProperty(): int
    {
        return $this->armada->where('status', 'in_use')->count();
    }

    public function getMaintenanceProperty(): int
    {
        return $this->armada->where('status', 'maintenance')->count();
    }

    public function render()
    {
        return view('livewire.armada.index');
    }
}
