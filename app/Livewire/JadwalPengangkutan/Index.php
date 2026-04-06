<?php

namespace App\Livewire\JadwalPengangkutan;

use App\Models\JadwalPengangkutan;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';

    public function getJadwalProperty(): array
    {
        return $this->tableQuery()
            ->orderBy('tanggal_pengangkutan')
            ->orderBy('kode_jadwal')
            ->get()
            ->map(function (JadwalPengangkutan $jadwal): array {
                return [
                    'id' => $jadwal->id,
                    'kode_jadwal' => $jadwal->kode_jadwal,
                    'tanggal_pengangkutan' => $jadwal->tanggal_pengangkutan?->format('Y-m-d'),
                    'nama_fasilitas' => $jadwal->nama_fasilitas,
                    'armada' => $jadwal->armada,
                    'petugas_pic' => $jadwal->petugas_pic,
                    'status' => $jadwal->status,
                ];
            })
            ->values()
            ->all();
    }

    public function getTotalProperty(): int
    {
        return JadwalPengangkutan::count();
    }

    public function getScheduledProperty(): int
    {
        return JadwalPengangkutan::where('status', 'scheduled')->count();
    }

    public function getInProgressProperty(): int
    {
        return JadwalPengangkutan::where('status', 'in_progress')->count();
    }

    public function getCompletedProperty(): int
    {
        return JadwalPengangkutan::where('status', 'completed')->count();
    }

    protected function tableQuery(): Builder
    {
        $search = trim($this->search);

        return JadwalPengangkutan::query()
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $subQuery) use ($search): void {
                    $subQuery->where('kode_jadwal', 'like', "%{$search}%")
                        ->orWhere('nama_fasilitas', 'like', "%{$search}%")
                        ->orWhere('armada', 'like', "%{$search}%")
                        ->orWhere('petugas_pic', 'like', "%{$search}%");
                });
            });
    }

    public function render(): View
    {
        return view('livewire.jadwal-pengangkutan.index');
    }
}
