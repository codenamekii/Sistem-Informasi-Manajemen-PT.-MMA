<?php

namespace App\Livewire\Realisasi;

use App\Models\JadwalPengangkutan;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Index extends Component
{
    public string $search       = '';
    public string $filterBukti  = ''; // lengkap|belum

    // ─── Computed: data tabel ─────────────────────────────

    public function getRealisasiProperty(): array
    {
        return $this->tableQuery()
            ->with(['kerjaSama.fasilitasKesehatan', 'armadaRelasi', 'petugas'])
            ->orderByDesc('tanggal_realisasi')
            ->orderByDesc('tanggal_pengangkutan')
            ->get()
            ->map(function (JadwalPengangkutan $jadwal): array {

                $petugasDisplay = $jadwal->petugas->isNotEmpty()
                    ? $jadwal->petugas->pluck('nama_petugas')->join(', ')
                    : ($jadwal->petugas_pic ?: '—');

                return [
                    'id'                     => $jadwal->id,
                    'kode_jadwal'            => $jadwal->kode_jadwal,
                    'tanggal_pengangkutan'   => $jadwal->tanggal_pengangkutan?->format('d/m/Y'),
                    'tanggal_realisasi'      => $jadwal->tanggal_realisasi?->format('d/m/Y') ?: '—',
                    'nama_fasilitas_display' => $jadwal->nama_fasilitas_display,
                    'armada_display'         => $jadwal->armada_display,
                    'petugas_display'        => $petugasDisplay,
                    'has_bukti_lengkap'      => $jadwal->has_bukti_lengkap,
                    'is_connected'           => ! is_null($jadwal->kerja_sama_id),
                ];
            })
            ->values()
            ->all();
    }

    // ─── Computed: stat cards ─────────────────────────────

    public function getTotalRealisasiProperty(): int
    {
        return JadwalPengangkutan::realisasi()->count();
    }

    public function getBuktiLengkapProperty(): int
    {
        return JadwalPengangkutan::buktiLengkap()->count();
    }

    public function getBuktiBelumLengkapProperty(): int
    {
        return JadwalPengangkutan::buktiBelumLengkap()->count();
    }

    // ─── Reset ────────────────────────────────────────────

    public function resetFilters(): void
    {
        $this->search      = '';
        $this->filterBukti = '';
    }

    // ─── Query ────────────────────────────────────────────

    protected function tableQuery(): Builder
    {
        $search = trim($this->search);

        return JadwalPengangkutan::realisasi()
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $q) use ($search): void {
                    $q->where('kode_jadwal', 'like', "%{$search}%")
                        ->orWhere('nama_fasilitas', 'like', "%{$search}%")
                        ->orWhere('armada', 'like', "%{$search}%")
                        ->orWhere('petugas_pic', 'like', "%{$search}%")
                        ->orWhereHas('kerjaSama', function (Builder $ks) use ($search): void {
                            $ks->where('nomor_perjanjian', 'like', "%{$search}%")
                                ->orWhereHas('fasilitasKesehatan', function (Builder $f) use ($search): void {
                                    $f->where('nama', 'like', "%{$search}%");
                                });
                        })
                        ->orWhereHas('petugas', function (Builder $p) use ($search): void {
                            $p->where('nama_petugas', 'like', "%{$search}%");
                        });
                });
            })
            ->when($this->filterBukti === 'lengkap', function (Builder $q): void {
                $q->whereNotNull('manifest_elektronik_path')
                    ->whereNotNull('bukti_foto_pengangkutan_path');
            })
            ->when($this->filterBukti === 'belum', function (Builder $q): void {
                $q->where(function (Builder $q): void {
                    $q->whereNull('manifest_elektronik_path')
                        ->orWhereNull('bukti_foto_pengangkutan_path');
                });
            });
    }

    public function render(): View
    {
        return view('livewire.realisasi.index');
    }
}