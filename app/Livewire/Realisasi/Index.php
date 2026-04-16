<?php

namespace App\Livewire\Realisasi;

use App\Models\JadwalPengangkutan;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Index extends Component
{
  public string $search = '';
  public string $filterBukti = '';

  public function getRealisasiProperty(): array
  {
    $jadwalList = $this->tableQuery()
      ->with(['kerjaSama.fasilitasKesehatan'])
      ->orderByDesc('tanggal_realisasi')
      ->orderByDesc('tanggal_pengangkutan')
      ->get();

    return $jadwalList
      ->filter(fn(JadwalPengangkutan $jadwal) => !is_null($jadwal->kerja_sama_id))
      ->groupBy('kerja_sama_id')
      ->map(function ($items, $kerjaSamaId): array {
        /** @var \Illuminate\Support\Collection<int, JadwalPengangkutan> $items */
        $first = $items->first();
        $kerjaSama = $first?->kerjaSama;

        $totalLimbah = (float) $items->sum(fn($item) => (float) ($item->total_limbah_kg ?? 0));
        $totalBiaya = (float) $items->sum(fn($item) => (float) ($item->total_biaya_realisasi ?? 0));
        $jumlahRealisasi = $items->count();
        $buktiLengkapCount = $items->where('has_bukti_lengkap', true)->count();

        return [
          'kerja_sama_id' => (int) $kerjaSamaId,
          'nama_fasilitas_display' => $kerjaSama?->nama_fasilitas_display ?? ($first?->nama_fasilitas_display ?? '—'),
          'nomor_perjanjian' => $kerjaSama?->nomor_perjanjian ?? '—',
          'jumlah_realisasi' => $jumlahRealisasi,
          'total_limbah_kg' => $totalLimbah,
          'total_limbah_kg_display' => $this->formatKg($totalLimbah),
          'total_biaya_realisasi' => $totalBiaya,
          'total_biaya_realisasi_rupiah' => $this->formatRupiah($totalBiaya),
          'jumlah_bukti_lengkap' => $buktiLengkapCount,
          'jumlah_bukti_belum_lengkap' => $jumlahRealisasi - $buktiLengkapCount,
          'has_any_bukti_belum_lengkap' => $buktiLengkapCount < $jumlahRealisasi,
        ];
      })
      ->values()
      ->all();
  }

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

  public function resetFilters(): void
  {
    $this->search = '';
    $this->filterBukti = '';
  }

  protected function tableQuery(): Builder
  {
    $search = trim($this->search);

    return JadwalPengangkutan::realisasi()
      ->when($search !== '', function (Builder $query) use ($search): void {
        $query->where(function (Builder $q) use ($search): void {
          $q->where('kode_jadwal', 'like', "%{$search}%")
            ->orWhere('nama_fasilitas', 'like', "%{$search}%")
            ->orWhereHas('kerjaSama', function (Builder $ks) use ($search): void {
              $ks->where('nomor_perjanjian', 'like', "%{$search}%")
                ->orWhereHas('fasilitasKesehatan', function (Builder $f) use ($search): void {
                  $f->where('nama', 'like', "%{$search}%");
                });
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

  protected function formatKg(float $value): string
  {
    return rtrim(rtrim(number_format($value, 2, ',', '.'), '0'), ',') . ' kg';
  }

  protected function formatRupiah(float $value): string
  {
    return 'Rp ' . number_format($value, 0, ',', '.');
  }

  public function render(): View
  {
    return view('livewire.realisasi.index');
  }
}