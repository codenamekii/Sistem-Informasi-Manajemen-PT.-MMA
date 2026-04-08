<?php

namespace App\Livewire\Dokumen;

use App\Models\Dokumen as DokumenModel;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Dokumen')]
class Index extends Component
{
    public string $search = '';
    public string $status = '';
    public string $koneksiKerjaSama = '';

    public function getDokumensProperty(): array
    {
        $search = trim($this->search);

        return DokumenModel::query()
            ->with([
                'kerjaSama:id,nomor_perjanjian,nama_fasilitas_kesehatan,fasilitas_kesehatan_id',
                'kerjaSama.fasilitasKesehatan:id,nama',
            ])
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $subQuery) use ($search) {
                    $subQuery->where('nama_dokumen', 'like', "%{$search}%")
                        ->orWhere('nomor_referensi', 'like', "%{$search}%")
                        ->orWhere('kategori_dokumen', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhere('terkait_dengan', 'like', "%{$search}%")
                        ->orWhereHas('kerjaSama', function (Builder $kerjaSamaQuery) use ($search) {
                            $kerjaSamaQuery->where('nomor_perjanjian', 'like', "%{$search}%")
                                ->orWhere('nama_fasilitas_kesehatan', 'like', "%{$search}%")
                                ->orWhereHas('fasilitasKesehatan', function (Builder $fasilitasQuery) use ($search) {
                                    $fasilitasQuery->where('nama', 'like', "%{$search}%");
                                });
                        });
                });
            })
            ->when($this->status !== '', function (Builder $query) {
                $query->where('status', $this->status);
            })
            ->when($this->koneksiKerjaSama !== '', function (Builder $query) {
                if ($this->koneksiKerjaSama === 'connected') {
                    $query->whereNotNull('kerja_sama_id');
                }

                if ($this->koneksiKerjaSama === 'legacy') {
                    $query->whereNull('kerja_sama_id');
                }
            })
            ->orderBy('nama_dokumen')
            ->get()
            ->map(function (DokumenModel $item): array {
                return [
                    'id' => $item->id,
                    'nama_dokumen' => $item->nama_dokumen,
                    'kategori_dokumen' => $item->kategori_dokumen,
                    'nomor_referensi' => $item->nomor_referensi,
                    'kerja_sama_display' => $item->kerja_sama_display,
                    'is_connected_to_kerja_sama' => $item->is_connected_to_kerja_sama,
                    'tanggal_berlaku_sampai' => $item->tanggal_berlaku_sampai?->format('Y-m-d'),
                    'status' => $item->status,
                ];
            })
            ->values()
            ->all();
    }

    public function getTotalProperty(): int
    {
        return count($this->dokumens);
    }

    public function getValidProperty(): int
    {
        return collect($this->dokumens)->where('status', 'valid')->count();
    }

    public function getExpiringSoonProperty(): int
    {
        return collect($this->dokumens)->where('status', 'expiring_soon')->count();
    }

    public function getTersambungProperty(): int
    {
        return collect($this->dokumens)->where('is_connected_to_kerja_sama', true)->count();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->status = '';
        $this->koneksiKerjaSama = '';
    }

    public function render(): View
    {
        return view('livewire.dokumen.index');
    }
}
