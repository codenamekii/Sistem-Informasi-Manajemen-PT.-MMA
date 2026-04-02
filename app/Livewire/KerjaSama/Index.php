<?php

namespace App\Livewire\KerjaSama;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\KerjaSama;

#[Layout('layouts.app')]
#[Title('Kerja Sama')]
class Index extends Component
{
    public string $search = '';

    public function getKerjaSamaProperty()
    {
        return KerjaSama::query()
            ->when($this->search !== '', function ($query) {
                $query->where('nomor_perjanjian', 'like', "%{$this->search}%")
                    ->orWhere('nama_fasilitas_kesehatan', 'like', "%{$this->search}%");
            })
            ->orderBy('tanggal_berakhir', 'asc')
            ->get();
    }

    public function getTotalProperty(): int
    {
        return $this->kerjaSama->count();
    }

    public function getAktifProperty(): int
    {
        return $this->kerjaSama->where('status', 'active')->count();
    }

    public function getExpiredProperty(): int
    {
        return $this->kerjaSama->where('status', 'expired')->count();
    }

    public function render()
    {
        return view('livewire.kerja-sama.index');
    }
}
