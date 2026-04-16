<?php

namespace App\Livewire\Realisasi;

use App\Models\JadwalPengangkutan;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Show extends Component
{
  public JadwalPengangkutan $jadwalPengangkutan;

  public array $detail = [];

  public function mount(JadwalPengangkutan $jadwalPengangkutan): void
  {
    if ($jadwalPengangkutan->status !== 'completed') {
      abort(404);
    }

    $jadwalPengangkutan->load(['kerjaSama.fasilitasKesehatan', 'armadaRelasi', 'petugas']);

    $this->jadwalPengangkutan = $jadwalPengangkutan;

    $petugasList = $jadwalPengangkutan->petugas->isNotEmpty()
      ? $jadwalPengangkutan->petugas->map(fn($p) => [
        'nama' => $p->nama_petugas,
        'jabatan' => $p->jabatan ?: '—',
      ])->all()
      : [];

    $petugasFallback = $jadwalPengangkutan->petugas_pic ?: '—';

    $manifestUrl = $jadwalPengangkutan->manifest_elektronik_path
      ? Storage::url($jadwalPengangkutan->manifest_elektronik_path)
      : null;

    $buktiFotoUrl = $jadwalPengangkutan->bukti_foto_pengangkutan_path
      ? Storage::url($jadwalPengangkutan->bukti_foto_pengangkutan_path)
      : null;

    $this->detail = [
      'id' => $jadwalPengangkutan->id,
      'kode_jadwal' => $jadwalPengangkutan->kode_jadwal,
      'tanggal_pengangkutan' => $jadwalPengangkutan->tanggal_pengangkutan
        ? Carbon::parse($jadwalPengangkutan->tanggal_pengangkutan)->format('d/m/Y')
        : '—',
      'tanggal_realisasi' => $jadwalPengangkutan->tanggal_realisasi
        ? Carbon::parse($jadwalPengangkutan->tanggal_realisasi)->format('d/m/Y')
        : '—',
      'nama_fasilitas_display' => $jadwalPengangkutan->nama_fasilitas_display,
      'armada_display' => $jadwalPengangkutan->armada_display,
      'petugas_list' => $petugasList,
      'petugas_fallback' => $petugasFallback,
      'is_connected' => !is_null($jadwalPengangkutan->kerja_sama_id),
      'has_bukti_lengkap' => $jadwalPengangkutan->has_bukti_lengkap,
      'manifest_url' => $manifestUrl,
      'bukti_foto_url' => $buktiFotoUrl,
      'nomor_perjanjian' => $jadwalPengangkutan->kerjaSama?->nomor_perjanjian ?: '—',
      'total_limbah_kg' => $jadwalPengangkutan->total_limbah_kg,
      'total_limbah_kg_display' => $jadwalPengangkutan->total_limbah_kg_display,
      'harga_per_kg_realisasi' => $jadwalPengangkutan->harga_per_kg_realisasi,
      'harga_per_kg_realisasi_rupiah' => $jadwalPengangkutan->harga_per_kg_realisasi_rupiah,
      'total_biaya_realisasi' => $jadwalPengangkutan->total_biaya_realisasi,
      'total_biaya_realisasi_rupiah' => $jadwalPengangkutan->total_biaya_realisasi_rupiah,
    ];
  }

  public function render(): View
  {
    return view('livewire.realisasi.show');
  }
}