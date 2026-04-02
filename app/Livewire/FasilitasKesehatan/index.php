<?php

namespace App\Livewire\FasilitasKesehatan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\FasilitasKesehatan as FasilitasModel;

#[Layout('layouts.app')]
#[Title('Fasilitas Kesehatan')]
class Index extends Component
{
    public string $search = '';

    public function getFasilitasProperty()
    {
        return FasilitasModel::query()
            ->when($this->search !== '', function ($query) {
                $query->where('nama', 'like', "%{$this->search}%")
                    ->orWhere('kota_kabupaten', 'like', "%{$this->search}%")
                    ->orWhere('jenis_fasilitas', 'like', "%{$this->search}%");
            })
            ->orderBy('nama')
            ->get();
    }

    public function getTotalProperty(): int
    {
        return $this->fasilitas->count();
    }

    public function getAktifProperty(): int
    {
        return $this->fasilitas->where('status', 'active')->count();
    }

    public function getProspectProperty(): int
    {
        return $this->fasilitas->where('status', 'prospect')->count();
    }

    public function render()
    {
        return view('livewire.fasilitas-kesehatan.index');
    }
}
