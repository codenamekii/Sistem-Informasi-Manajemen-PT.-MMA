<?php

namespace App\Livewire\Petugas;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Petugas;

#[Layout('layouts.app')]
#[Title('Petugas')]
class Index extends Component
{
    public string $search = '';

    public function getPetugasProperty()
    {
        return Petugas::query()
            ->when($this->search !== '', function ($query) {
                $query->where('nama_petugas', 'like', "%{$this->search}%")
                    ->orWhere('jabatan', 'like', "%{$this->search}%")
                    ->orWhere('wilayah_tugas', 'like', "%{$this->search}%");
            })
            ->orderByRaw("FIELD(status, 'active', 'on_leave', 'inactive')")
            ->orderBy('nama_petugas', 'asc')
            ->get();
    }

    public function getTotalProperty(): int
    {
        return $this->petugas->count();
    }

    public function getActiveProperty(): int
    {
        return $this->petugas->where('status', 'active')->count();
    }

    public function getOnLeaveProperty(): int
    {
        return $this->petugas->where('status', 'on_leave')->count();
    }

    public function getInactiveProperty(): int
    {
        return $this->petugas->where('status', 'inactive')->count();
    }

    public function render()
    {
        return view('livewire.petugas.index');
    }
}
