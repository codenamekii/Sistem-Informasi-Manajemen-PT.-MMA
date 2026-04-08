<?php

namespace App\Livewire\Laporan;

use App\Exports\LaporanExport;
use App\Models\Armada;
use App\Models\Dokumen;
use App\Models\FasilitasKesehatan;
use App\Models\JadwalPengangkutan;
use App\Models\KerjaSama;
use App\Models\Petugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('layouts.app')]
class Index extends Component
{
  public string $jenisLaporan = '';

  public string $filterTanggalDari = '';
  public string $filterTanggalSampai = '';
  public string $filterStatus = '';
  public string $filterProvinsi = '';
  public int $filterHari = 30;

  public array $hasil = [];
  public array $kolom = [];
  public bool $sudahCari = false;

  // ─── Jenis laporan ────────────────────────────────────

  public function getJenisOptions(): array
  {
    return [
      '' => '— Pilih Jenis Laporan —',
      'fasilitas_kesehatan' => 'Fasilitas Kesehatan',
      'kerja_sama_aktif' => 'Kerja Sama Aktif',
      'kontrak_habis' => 'Kontrak Akan Berakhir',
      'dokumen_expired' => 'Dokumen Expired / Segera Expired',
      'jadwal_harian' => 'Jadwal Pengangkutan',
      'realisasi_pengangkutan' => 'Realisasi Pengangkutan',
      'armada' => 'Armada',
      'petugas' => 'Petugas',
    ];
  }

  protected function labelJenis(): string
  {
    return match ($this->jenisLaporan) {
      'fasilitas_kesehatan' => 'Fasilitas-Kesehatan',
      'kerja_sama_aktif' => 'Kerja-Sama-Aktif',
      'kontrak_habis' => 'Kontrak-Habis',
      'dokumen_expired' => 'Dokumen-Expired',
      'jadwal_harian' => 'Jadwal-Pengangkutan',
      'realisasi_pengangkutan' => 'Realisasi-Pengangkutan',
      'armada' => 'Armada',
      'petugas' => 'Petugas',
      default => 'Laporan',
    };
  }

  /**
   * Ringkasan filter aktif untuk ditampilkan di PDF/print.
   */
  protected function ringkasanFilter(): string
  {
    $parts = [];

    if ($this->filterTanggalDari !== '') {
      $parts[] = 'Dari: ' . Carbon::parse($this->filterTanggalDari)->format('d/m/Y');
    }
    if ($this->filterTanggalSampai !== '') {
      $parts[] = 'Sampai: ' . Carbon::parse($this->filterTanggalSampai)->format('d/m/Y');
    }
    if ($this->filterStatus !== '') {
      $parts[] = 'Status: ' . $this->filterStatus;
    }
    if ($this->filterProvinsi !== '') {
      $parts[] = 'Provinsi: ' . $this->filterProvinsi;
    }
    if ($this->jenisLaporan === 'kontrak_habis') {
      $parts[] = 'Dalam ' . $this->filterHari . ' hari ke depan';
    }

    return empty($parts) ? '' : implode(' | ', $parts);
  }

  // ─── Reset ────────────────────────────────────────────

  public function updatedJenisLaporan(): void
  {
    $this->hasil = [];
    $this->kolom = [];
    $this->sudahCari = false;
    $this->filterStatus = '';
    $this->filterTanggalDari = '';
    $this->filterTanggalSampai = '';
    $this->filterProvinsi = '';
    $this->filterHari = 30;
  }

  // ─── Generate ─────────────────────────────────────────

  public function generate(): void
  {
    $this->sudahCari = true;
    $this->hasil = [];
    $this->kolom = [];

    match ($this->jenisLaporan) {
      'fasilitas_kesehatan' => $this->queryFasilitasKesehatan(),
      'kerja_sama_aktif' => $this->queryKerjaSamaAktif(),
      'kontrak_habis' => $this->queryKontrakHabis(),
      'dokumen_expired' => $this->queryDokumenExpired(),
      'jadwal_harian' => $this->queryJadwalHarian(),
      'realisasi_pengangkutan' => $this->queryRealisasi(),
      'armada' => $this->queryArmada(),
      'petugas' => $this->queryPetugas(),
      default => null,
    };
  }

  // ─── Export Excel ─────────────────────────────────────

  public function exportExcel(): mixed
  {
    if ($this->jenisLaporan === '') {
      return null;
    }

    $this->generate();

    if (empty($this->hasil)) {
      session()->flash('info', 'Tidak ada data untuk diekspor.');
      return null;
    }

    $namaFile = 'Laporan-' . $this->labelJenis() . '-' . now()->format('Ymd-His') . '.xlsx';
    $judulSheet = $this->getJenisOptions()[$this->jenisLaporan] ?? 'Laporan';

    return Excel::download(
      new LaporanExport($this->kolom, $this->hasil, $judulSheet),
      $namaFile
    );
  }

  // ─── Export PDF ───────────────────────────────────────

  public function exportPdf(): mixed
  {
    if ($this->jenisLaporan === '') {
      return null;
    }

    $this->generate();

    if (empty($this->hasil)) {
      session()->flash('info', 'Tidak ada data untuk diekspor.');
      return null;
    }

    $judul = $this->getJenisOptions()[$this->jenisLaporan] ?? 'Laporan';
    $namaFile = 'Laporan-' . $this->labelJenis() . '-' . now()->format('Ymd-His') . '.pdf';

    $pdf = Pdf::loadView('laporan.pdf', [
      'judul' => $judul,
      'kolom' => $this->kolom,
      'hasil' => $this->hasil,
      'filter' => $this->ringkasanFilter(),
    ])->setPaper('a4', 'landscape');

    return response()->streamDownload(
      fn() => print ($pdf->output()),
      $namaFile
    );
  }

  // ─── Cetak (window.print) ─────────────────────────────

  public function cetakLaporan(): void
  {
    if ($this->jenisLaporan === '' || empty($this->hasil)) {
      return;
    }

    $this->dispatch('do-print');
  }

  // ─── Query methods ────────────────────────────────────

  protected function queryFasilitasKesehatan(): void
  {
    $this->kolom = ['Nama', 'Jenis', 'Kota/Kabupaten', 'Provinsi', 'Status', 'PIC', 'Kendala'];

    $this->hasil = FasilitasKesehatan::query()
      ->when($this->filterStatus !== '', fn($q) =>
        $q->where('status', $this->filterStatus))
      ->when($this->filterProvinsi !== '', fn($q) =>
        $q->where('provinsi', 'like', '%' . $this->filterProvinsi . '%'))
      ->orderBy('nama')
      ->get()
      ->map(fn($f) => [
        $f->nama,
        $f->jenis_fasilitas ?: '—',
        $f->kota_kabupaten ?: '—',
        $f->provinsi ?: '—',
        $f->status ?: '—',
        $f->pic_nama ?: '—',
        $f->kendala ? \Illuminate\Support\Str::limit($f->kendala, 60) : '—',
      ])->all();
  }

  protected function queryKerjaSamaAktif(): void
  {
    $this->kolom = ['No. Perjanjian', 'Fasilitas', 'Tgl. Mulai', 'Tgl. Berakhir', 'Harga/kg', 'Status'];

    $this->hasil = KerjaSama::with('fasilitasKesehatan')
      ->where('status', 'aktif')
      ->when($this->filterTanggalDari !== '', fn($q) =>
        $q->where('tanggal_mulai', '>=', $this->filterTanggalDari))
      ->when($this->filterTanggalSampai !== '', fn($q) =>
        $q->where('tanggal_berakhir', '<=', $this->filterTanggalSampai))
      ->orderBy('tanggal_berakhir')
      ->get()
      ->map(fn($ks) => [
        $ks->nomor_perjanjian,
        $ks->nama_fasilitas_display,
        $ks->tanggal_mulai?->format('d/m/Y') ?: '—',
        $ks->tanggal_berakhir?->format('d/m/Y') ?: '—',
        $ks->harga_per_kilogram_rupiah,
        $ks->status,
      ])->all();
  }

  protected function queryKontrakHabis(): void
  {
    $this->kolom = ['No. Perjanjian', 'Fasilitas', 'Tgl. Berakhir', 'Sisa Hari', 'Status'];

    $today = Carbon::today();
    $batas = Carbon::today()->addDays(max(1, (int) $this->filterHari));

    $this->hasil = KerjaSama::with('fasilitasKesehatan')
      ->whereNotNull('tanggal_berakhir')
      ->whereBetween('tanggal_berakhir', [$today, $batas])
      ->orderBy('tanggal_berakhir')
      ->get()
      ->map(fn($ks) => [
        $ks->nomor_perjanjian,
        $ks->nama_fasilitas_display,
        $ks->tanggal_berakhir->format('d/m/Y'),
        $today->diffInDays($ks->tanggal_berakhir) . ' hari',
        $ks->status,
      ])->all();
  }

  protected function queryDokumenExpired(): void
  {
    $this->kolom = ['Nama Dokumen', 'Kategori', 'No. Referensi', 'Terkait', 'Tgl. Berlaku Sampai', 'Status'];

    $today = Carbon::today();
    $batas = Carbon::today()->addDays(30);

    $this->hasil = Dokumen::query()
      ->where(function ($q) use ($today, $batas) {
        $q->where('status', 'expired')
          ->orWhere(function ($q2) use ($today) {
            $q2->whereNotNull('tanggal_berlaku_sampai')
              ->where('tanggal_berlaku_sampai', '<', $today);
          })
          ->orWhere(function ($q3) use ($today, $batas) {
            $q3->whereNotNull('tanggal_berlaku_sampai')
              ->whereBetween('tanggal_berlaku_sampai', [$today, $batas])
              ->where('status', '!=', 'expired');
          });
      })
      ->when($this->filterStatus !== '', fn($q) =>
        $q->where('status', $this->filterStatus))
      ->orderBy('tanggal_berlaku_sampai')
      ->get()
      ->map(fn($d) => [
        $d->nama_dokumen,
        $d->kategori_dokumen ?: '—',
        $d->nomor_referensi ?: '—',
        $d->terkait_dengan_display,
        $d->tanggal_berlaku_sampai?->format('d/m/Y') ?: '—',
        $d->status,
      ])->all();
  }

  protected function queryJadwalHarian(): void
  {
    $this->kolom = ['Kode Jadwal', 'Tgl. Pengangkutan', 'Fasilitas', 'Armada', 'Petugas', 'Status'];

    $this->hasil = JadwalPengangkutan::with(['kerjaSama.fasilitasKesehatan', 'armadaRelasi', 'petugas'])
      ->when($this->filterTanggalDari !== '', fn($q) =>
        $q->where('tanggal_pengangkutan', '>=', $this->filterTanggalDari))
      ->when($this->filterTanggalSampai !== '', fn($q) =>
        $q->where('tanggal_pengangkutan', '<=', $this->filterTanggalSampai))
      ->when($this->filterStatus !== '', fn($q) =>
        $q->where('status', $this->filterStatus))
      ->orderBy('tanggal_pengangkutan')
      ->orderBy('kode_jadwal')
      ->get()
      ->map(fn($j) => [
        $j->kode_jadwal,
        $j->tanggal_pengangkutan?->format('d/m/Y') ?: '—',
        $j->nama_fasilitas_display,
        $j->armada_display,
        $j->petugas->isNotEmpty()
        ? $j->petugas->pluck('nama_petugas')->join(', ')
        : ($j->petugas_pic ?: '—'),
        match ($j->status) {
          'draft' => 'Draft',
          'scheduled' => 'Terjadwal',
          'in_progress' => 'Berlangsung',
          'completed' => 'Selesai',
          'cancelled' => 'Dibatalkan',
          default => $j->status,
        },
      ])->all();
  }

  protected function queryRealisasi(): void
  {
    $this->kolom = ['Kode Jadwal', 'Fasilitas', 'Tgl. Pengangkutan', 'Tgl. Realisasi', 'Armada', 'Petugas', 'Bukti'];

    $this->hasil = JadwalPengangkutan::realisasi()
      ->with(['kerjaSama.fasilitasKesehatan', 'armadaRelasi', 'petugas'])
      ->when($this->filterTanggalDari !== '', fn($q) =>
        $q->where('tanggal_pengangkutan', '>=', $this->filterTanggalDari))
      ->when($this->filterTanggalSampai !== '', fn($q) =>
        $q->where('tanggal_pengangkutan', '<=', $this->filterTanggalSampai))
      ->orderByDesc('tanggal_pengangkutan')
      ->get()
      ->map(fn($j) => [
        $j->kode_jadwal,
        $j->nama_fasilitas_display,
        $j->tanggal_pengangkutan?->format('d/m/Y') ?: '—',
        $j->tanggal_realisasi?->format('d/m/Y') ?: '—',
        $j->armada_display,
        $j->petugas->isNotEmpty()
        ? $j->petugas->pluck('nama_petugas')->join(', ')
        : ($j->petugas_pic ?: '—'),
        $j->has_bukti_lengkap ? 'Lengkap' : 'Belum Lengkap',
      ])->all();
  }

  protected function queryArmada(): void
  {
    $this->kolom = ['Kode Armada', 'No. Polisi', 'Jenis Kendaraan', 'Kapasitas', 'Status'];

    $this->hasil = Armada::query()
      ->when($this->filterStatus !== '', fn($q) =>
        $q->where('status', $this->filterStatus))
      ->orderBy('nomor_polisi')
      ->get()
      ->map(fn($a) => [
        $a->kode_armada ?: '—',
        $a->nomor_polisi ?: '—',
        $a->jenis_kendaraan ?: '—',
        $a->kapasitas ? $a->kapasitas . ' kg' : '—',
        $a->status ?: '—',
      ])->all();
  }

  protected function queryPetugas(): void
  {
    $this->kolom = ['Nama Petugas', 'Jabatan', 'No. Telepon', 'Wilayah Tugas', 'Status'];

    $this->hasil = Petugas::query()
      ->when($this->filterStatus !== '', fn($q) =>
        $q->where('status', $this->filterStatus))
      ->orderBy('nama_petugas')
      ->get()
      ->map(fn($p) => [
        $p->nama_petugas ?: '—',
        $p->jabatan ?: '—',
        $p->nomor_telepon ?: '—',
        $p->wilayah_tugas ?: '—',
        $p->status ?: '—',
      ])->all();
  }

  public function render(): View
  {
    return view('livewire.laporan.index', [
      'jenisOptions' => $this->getJenisOptions(),
    ]);
  }
}