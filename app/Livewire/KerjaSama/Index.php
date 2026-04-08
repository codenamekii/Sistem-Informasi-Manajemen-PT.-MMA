<?php

namespace App\Livewire\KerjaSama;

use App\Models\KerjaSama as KerjaSamaModel;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Kerja Sama')]
class Index extends Component
{
    public string $search = '';
    public string $status = '';
    public string $koneksiFasilitas = '';

    public function getKerjaSamasProperty(): array
    {
        $search = trim($this->search);

        return KerjaSamaModel::query()
            ->with('fasilitasKesehatan:id,nama')
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $subQuery) use ($search) {
                    $subQuery->where('nomor_perjanjian', 'like', "%{$search}%")
                        ->orWhere('nama_fasilitas_kesehatan', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas('fasilitasKesehatan', function (Builder $relatedQuery) use ($search) {
                            $relatedQuery->where('nama', 'like', "%{$search}%");
                        });
                });
            })
            ->when($this->status !== '', function (Builder $query) {
                $query->where('status', $this->status);
            })
            ->when($this->koneksiFasilitas !== '', function (Builder $query) {
                if ($this->koneksiFasilitas === 'connected') {
                    $query->whereNotNull('fasilitas_kesehatan_id');
                }

                if ($this->koneksiFasilitas === 'legacy') {
                    $query->whereNull('fasilitas_kesehatan_id');
                }
            })
            ->orderByDesc('tanggal_mulai')
            ->orderBy('nomor_perjanjian')
            ->get()
            ->map(function (KerjaSamaModel $item): array {
                return [
                    'id' => $item->id,
                    'nomor_perjanjian' => $item->nomor_perjanjian,
                    'nama_fasilitas_display' => $item->fasilitasKesehatan?->nama
                        ?: ($item->nama_fasilitas_kesehatan ?: '—'),
                    'is_connected' => (bool) $item->fasilitas_kesehatan_id,
                    'tanggal_mulai' => $item->tanggal_mulai?->format('Y-m-d'),
                    'tanggal_berakhir' => $item->tanggal_berakhir?->format('Y-m-d'),
                    'harga_per_kilogram_rupiah' => $item->harga_per_kilogram !== null
                        ? 'Rp ' . number_format((float) $item->harga_per_kilogram, 0, ',', '.') . '/kg'
                        : '—',
                    'status' => $item->status,
                ];
            })
            ->values()
            ->all();
    }

    public function getTotalProperty(): int
    {
        return count($this->kerjaSamas);
    }

    public function getAktifProperty(): int
    {
        return collect($this->kerjaSamas)->where('status', 'active')->count();
    }

    public function getDraftProperty(): int
    {
        return collect($this->kerjaSamas)->where('status', 'draft')->count();
    }

    public function getTersambungProperty(): int
    {
        return collect($this->kerjaSamas)->where('is_connected', true)->count();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->status = '';
        $this->koneksiFasilitas = '';
    }

    public function render(): View
    {
        return view('livewire.kerja-sama.index');
    }
}
