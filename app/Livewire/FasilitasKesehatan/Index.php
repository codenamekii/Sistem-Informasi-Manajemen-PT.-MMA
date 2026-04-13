<?php

namespace App\Livewire\FasilitasKesehatan;

use App\Models\FasilitasKesehatan as FasilitasModel;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Fasilitas Kesehatan')]
class Index extends Component
{
    public string $search = '';
    public string $status = '';
    public string $statusPenawaran = '';

    public function getFasilitasProperty()
    {
        $search = trim($this->search);

        return FasilitasModel::query()
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $subQuery) use ($search) {
                    $subQuery->where('nama', 'like', "%{$search}%")
                        ->orWhere('jenis_fasilitas', 'like', "%{$search}%")
                        ->orWhere('kota_kabupaten', 'like', "%{$search}%")
                        ->orWhere('provinsi', 'like', "%{$search}%")
                        ->orWhere('pic_nama', 'like', "%{$search}%")
                        ->orWhere('pic_nomor_telepon', 'like', "%{$search}%")
                        ->orWhere('kendala', 'like', "%{$search}%");
                });
            })
            ->when($this->status !== '', function (Builder $query) {
                $query->where('status', $this->status);
            })
            ->when($this->statusPenawaran !== '', function (Builder $query) {
                $query->where('status_penawaran', $this->statusPenawaran);
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

    public function getMasukPenawaranProperty(): int
    {
        return $this->fasilitas->where('status_penawaran', 'masuk_penawaran')->count();
    }

    public function getDenganKendalaProperty(): int
    {
        return $this->fasilitas->filter(function ($item) {
            return filled($item->kendala);
        })->count();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->status = '';
        $this->statusPenawaran = '';
    }

    public function render(): View
    {
        return view('livewire.fasilitas-kesehatan.index');
    }
}
