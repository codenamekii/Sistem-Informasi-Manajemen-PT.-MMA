<?php

namespace App\Livewire\JadwalPengangkutan;

use App\Models\JadwalPengangkutan;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Index extends Component
{
  public string $search = '';
  public string $filterStatus = '';   // draft|scheduled|in_progress|completed|cancelled
  public string $filterKoneksi = '';  // connected|legacy
  public string $filterBukti = '';    // lengkap|belum|bukan_completed

  // ─── Computed: data tabel ─────────────────────────────

  public function getJadwalProperty(): array
  {
    return $this->tableQuery()
      ->with(['kerjaSama.fasilitasKesehatan'])
      ->orderBy('tanggal_pengangkutan')
      ->orderBy('kode_jadwal')
      ->get()
      ->map(function (JadwalPengangkutan $jadwal): array {
        return [
          'id' => $jadwal->id,
          'kode_jadwal' => $jadwal->kode_jadwal,
          'tanggal_pengangkutan' => Carbon::parse($jadwal->tanggal_pengangkutan)->format('d/m/Y'),
          'nama_fasilitas_display' => $jadwal->nama_fasilitas_display,
          'is_connected' => !is_null($jadwal->kerja_sama_id),
          'status' => $jadwal->status,
          'has_bukti_lengkap' => $jadwal->has_bukti_lengkap,
        ];
      })
      ->values()
      ->all();
  }

  // ─── Computed: stat cards ─────────────────────────────

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

  public function getCompletedWithBuktiProperty(): int
  {
    return JadwalPengangkutan::where('status', 'completed')
      ->whereNotNull('manifest_elektronik_path')
      ->whereNotNull('bukti_foto_pengangkutan_path')
      ->count();
  }

  // ─── Reset filter ─────────────────────────────────────

  public function resetFilters(): void
  {
    $this->search = '';
    $this->filterStatus = '';
    $this->filterKoneksi = '';
    $this->filterBukti = '';
  }

  // ─── Query ────────────────────────────────────────────

  protected function tableQuery(): Builder
  {
    $search = trim($this->search);

    return JadwalPengangkutan::query()
      ->when($search !== '', function (Builder $query) use ($search): void {
        $query->where(function (Builder $q) use ($search): void {
          $q->where('kode_jadwal', 'like', "%{$search}%")
            ->orWhere('nama_fasilitas', 'like', "%{$search}%")
            ->orWhere('status', 'like', "%{$search}%")
            ->orWhereHas('kerjaSama', function (Builder $ks) use ($search): void {
              $ks->where('nomor_perjanjian', 'like', "%{$search}%")
                ->orWhereHas('fasilitasKesehatan', function (Builder $f) use ($search): void {
                  $f->where('nama', 'like', "%{$search}%");
                });
            });
        });
      })

      ->when($this->filterStatus !== '', function (Builder $q): void {
        $q->where('status', $this->filterStatus);
      })

      ->when($this->filterKoneksi === 'connected', function (Builder $q): void {
        $q->whereNotNull('kerja_sama_id');
      })
      ->when($this->filterKoneksi === 'legacy', function (Builder $q): void {
        $q->whereNull('kerja_sama_id');
      })

      ->when($this->filterBukti === 'lengkap', function (Builder $q): void {
        $q->where('status', 'completed')
          ->whereNotNull('manifest_elektronik_path')
          ->whereNotNull('bukti_foto_pengangkutan_path');
      })
      ->when($this->filterBukti === 'belum', function (Builder $q): void {
        $q->where('status', 'completed')
          ->where(function (Builder $q): void {
            $q->whereNull('manifest_elektronik_path')
              ->orWhereNull('bukti_foto_pengangkutan_path');
          });
      })
      ->when($this->filterBukti === 'bukan_completed', function (Builder $q): void {
        $q->where('status', '!=', 'completed');
      });
  }

  public function render(): View
  {
    return view('livewire.jadwal-pengangkutan.index');
  }
}