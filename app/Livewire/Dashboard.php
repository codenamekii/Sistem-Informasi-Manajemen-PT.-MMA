<?php

namespace App\Livewire;

use App\Models\Dokumen;
use App\Models\FasilitasKesehatan;
use App\Models\JadwalPengangkutan;
use App\Models\KerjaSama;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Dashboard')]
#[Layout('layouts.app')]
class Dashboard extends Component
{
  // Stat cards
  public int $totalFasilitas = 0;
  public int $kerjaSamaAktif = 0;
  public int $dokumenExpiredCount = 0;
  public int $jadwalHariIniCount = 0;
  public int $buktiKurangCount = 0;

  // Notifikasi
  public array $notifKerjaSamaHabis = [];
  public array $notifDokumenExpired = [];
  public array $notifDokumenSegera = [];
  public array $notifJadwalHariIni = [];
  public array $notifBuktiKurang = [];
  public array $notifFasilitasKendala = [];

  public function mount(): void
  {
    $this->loadStatCards();
    $this->loadNotifKerjaSamaHabis();
    $this->loadNotifDokumenExpired();
    $this->loadNotifDokumenSegera();
    $this->loadNotifJadwalHariIni();
    $this->loadNotifBuktiKurang();
    $this->loadNotifFasilitasKendala();
  }

  private function loadStatCards(): void
  {
    $today = Carbon::today();

    $this->totalFasilitas = FasilitasKesehatan::count();
    $this->kerjaSamaAktif = KerjaSama::where('status', 'active')->count();
    $this->dokumenExpiredCount = Dokumen::where('status', 'expired')
      ->orWhere(function ($q) use ($today) {
        $q->whereNotNull('tanggal_berlaku_sampai')
          ->where('tanggal_berlaku_sampai', '<', $today)
          ->where('status', '!=', 'expired');
      })->count();
    $this->jadwalHariIniCount = JadwalPengangkutan::whereDate('tanggal_pengangkutan', $today)->count();
    $this->buktiKurangCount = JadwalPengangkutan::buktiBelumLengkap()->count();
  }

  private function loadNotifKerjaSamaHabis(): void
  {
    $today = Carbon::today();
    $batas30 = Carbon::today()->addDays(30);

    $this->notifKerjaSamaHabis = KerjaSama::with('fasilitasKesehatan')
      ->where('status', 'active')
      ->whereNotNull('tanggal_berakhir')
      ->whereBetween('tanggal_berakhir', [$today, $batas30])
      ->orderBy('tanggal_berakhir')
      ->get()
      ->map(fn($ks) => [
        'label' => $ks->nomor_perjanjian . ' — ' . $ks->nama_fasilitas_display,
        'info' => 'Berakhir ' . Carbon::parse($ks->tanggal_berakhir)->format('d/m/Y'),
        'hari' => $today->diffInDays($ks->tanggal_berakhir),
      ])
      ->all();
  }

  private function loadNotifDokumenExpired(): void
  {
    $today = Carbon::today();

    $this->notifDokumenExpired = Dokumen::where(function ($q) use ($today) {
      $q->where('status', 'expired')
        ->orWhere(function ($q2) use ($today) {
          $q2->whereNotNull('tanggal_berlaku_sampai')
            ->where('tanggal_berlaku_sampai', '<', $today);
        });
    })
      ->orderBy('tanggal_berlaku_sampai')
      ->get()
      ->map(fn($d) => [
        'label' => $d->nama_dokumen,
        'info' => $d->tanggal_berlaku_sampai
          ? 'Expired ' . Carbon::parse($d->tanggal_berlaku_sampai)->format('d/m/Y')
          : 'Status: Expired',
      ])
      ->all();
  }

  private function loadNotifDokumenSegera(): void
  {
    $today = Carbon::today();
    $batas30 = Carbon::today()->addDays(30);

    $this->notifDokumenSegera = Dokumen::where('status', '!=', 'expired')
      ->whereNotNull('tanggal_berlaku_sampai')
      ->whereBetween('tanggal_berlaku_sampai', [$today, $batas30])
      ->orderBy('tanggal_berlaku_sampai')
      ->get()
      ->map(fn($d) => [
        'label' => $d->nama_dokumen,
        'info' => 'Berakhir ' . Carbon::parse($d->tanggal_berlaku_sampai)->format('d/m/Y')
          . ' (' . $today->diffInDays($d->tanggal_berlaku_sampai) . ' hari lagi)',
      ])
      ->all();
  }

  private function loadNotifJadwalHariIni(): void
  {
    $today = Carbon::today();

    $this->notifJadwalHariIni = JadwalPengangkutan::with(['armadaRelasi'])
      ->whereDate('tanggal_pengangkutan', $today)
      ->whereNotIn('status', ['cancelled'])
      ->orderBy('kode_jadwal')
      ->get()
      ->map(fn($j) => [
        'id' => $j->id,
        'label' => $j->kode_jadwal . ' — ' . $j->nama_fasilitas_display,
        'info' => $j->armada_display,
        'status' => $j->status,
      ])
      ->all();
  }

  private function loadNotifBuktiKurang(): void
  {
    $this->notifBuktiKurang = JadwalPengangkutan::buktiBelumLengkap()
      ->orderByDesc('tanggal_pengangkutan')
      ->limit(10)
      ->get()
      ->map(fn($j) => [
        'id' => $j->id,
        'label' => $j->kode_jadwal . ' — ' . $j->nama_fasilitas_display,
        'info' => 'Selesai ' . ($j->tanggal_pengangkutan ? Carbon::parse($j->tanggal_pengangkutan)->format('d/m/Y') : '—'),
        'punya_manifest' => !empty($j->manifest_elektronik_path),
        'punya_foto' => !empty($j->bukti_foto_pengangkutan_path),
      ])
      ->all();
  }

  private function loadNotifFasilitasKendala(): void
  {
    $this->notifFasilitasKendala = FasilitasKesehatan::whereNotNull('kendala')
      ->where('kendala', '!=', '')
      ->orderBy('nama')
      ->get()
      ->map(fn($f) => [
        'label' => $f->nama,
        'info' => \Illuminate\Support\Str::limit($f->kendala, 80),
      ])
      ->all();
  }

  public function render(): View
  {
    return view('livewire.dashboard');
  }
}