<?php

namespace App\Livewire\Realisasi;

use App\Models\JadwalPengangkutan;
use App\Models\KerjaSama;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Component;

class FasilitasShow extends Component
{
  public KerjaSama $kerjaSama;

  public array $summary = [];
  public array $riwayat = [];

  public function mount(KerjaSama $kerjaSama): void
  {
    $kerjaSama->load('fasilitasKesehatan');

    $this->kerjaSama = $kerjaSama;

    $jadwalList = JadwalPengangkutan::query()
      ->with(['armadaRelasi', 'petugas'])
      ->where('status', 'completed')
      ->where('kerja_sama_id', $kerjaSama->id)
      ->orderByDesc('tanggal_realisasi')
      ->orderByDesc('tanggal_pengangkutan')
      ->get();

    $this->summary = [
      'kerja_sama_id' => $kerjaSama->id,
      'nomor_perjanjian' => $kerjaSama->nomor_perjanjian,
      'nama_fasilitas_display' => $kerjaSama->nama_fasilitas_display,
      'harga_per_kilogram_rupiah' => $kerjaSama->harga_per_kilogram_rupiah,
      'jumlah_realisasi' => $jadwalList->count(),
      'total_limbah_kg' => (float) $jadwalList->sum(fn($item) => (float) ($item->total_limbah_kg ?? 0)),
      'total_biaya_realisasi' => (float) $jadwalList->sum(fn($item) => (float) ($item->total_biaya_realisasi ?? 0)),
      'total_limbah_kg_display' => $this->formatKg((float) $jadwalList->sum(fn($item) => (float) ($item->total_limbah_kg ?? 0))),
      'total_biaya_realisasi_rupiah' => $this->formatRupiah((float) $jadwalList->sum(fn($item) => (float) ($item->total_biaya_realisasi ?? 0))),
    ];

    $this->riwayat = $jadwalList
      ->map(function (JadwalPengangkutan $jadwal): array {
        $petugasDisplay = $jadwal->petugas->isNotEmpty()
          ? $jadwal->petugas->pluck('nama_petugas')->join(', ')
          : ($jadwal->petugas_pic ?: '—');

        return [
          'id' => $jadwal->id,
          'kode_jadwal' => $jadwal->kode_jadwal,
          'tanggal_pengangkutan' => Carbon::parse($jadwal->tanggal_pengangkutan)->format('d/m/Y') ?? '—',
          'tanggal_realisasi' => Carbon::parse($jadwal->tanggal_realisasi)->format('d/m/Y') ?? '—',
          'armada_display' => $jadwal->armada_display,
          'petugas_display' => $petugasDisplay,
          'total_limbah_kg_display' => $jadwal->total_limbah_kg_display,
          'harga_per_kg_realisasi_rupiah' => $jadwal->harga_per_kg_realisasi_rupiah,
          'total_biaya_realisasi_rupiah' => $jadwal->total_biaya_realisasi_rupiah,
          'has_bukti_lengkap' => $jadwal->has_bukti_lengkap,
        ];
      })
      ->values()
      ->all();
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
    return view('livewire.realisasi.fasilitas-show');
  }
}