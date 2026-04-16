<?php

namespace App\Livewire\JadwalPengangkutan;

use App\Livewire\Concerns\HasRoleGuard;
use App\Models\Armada;
use App\Models\JadwalPengangkutan;
use App\Models\KerjaSama;
use App\Models\Petugas;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
  use WithFileUploads;
  use HasRoleGuard;

  public string $kode_jadwal = '';
  public string $tanggal_pengangkutan = '';
  public ?int $kerja_sama_id = null;
  public ?int $armada_id = null;
  public array $petugas_ids = [];
  public string $status = 'draft';

  // Field realisasi
  public string $tanggal_realisasi = '';
  public ?string $total_limbah_kg = null;
  public $manifest_elektronik = null;
  public $bukti_foto_pengangkutan = null;

  public function mount(): void
  {
    $this->kode_jadwal = $this->generateKodeJadwal();
  }

  public function updatedStatus(string $value): void
  {
    if ($value !== 'completed') {
      $this->tanggal_realisasi = '';
      $this->total_limbah_kg = null;
      $this->manifest_elektronik = null;
      $this->bukti_foto_pengangkutan = null;
    }
  }

  protected function generateKodeJadwal(): string
  {
    $prefix = 'JPG-' . now()->format('Ymd') . '-';

    $last = JadwalPengangkutan::where('kode_jadwal', 'like', $prefix . '%')
      ->orderByDesc('kode_jadwal')
      ->value('kode_jadwal');

    $seq = $last ? ((int) substr($last, -3)) + 1 : 1;

    return $prefix . str_pad($seq, 3, '0', STR_PAD_LEFT);
  }

  public function getKerjaSamaOptionsProperty()
  {
    return KerjaSama::with('fasilitasKesehatan')
      ->orderBy('nomor_perjanjian')
      ->get();
  }

  public function getArmadaOptionsProperty()
  {
    return Armada::orderBy('nomor_polisi')->get();
  }

  public function getPetugasOptionsProperty()
  {
    return Petugas::orderBy('nama_petugas')->get();
  }

  public function save(): void
  {
    if (!$this->guardAction('jadwal')) {
      return;
    }

    $rules = [
      'kode_jadwal' => 'required|string|max:50|unique:jadwal_pengangkutans,kode_jadwal',
      'tanggal_pengangkutan' => 'required|date',
      'kerja_sama_id' => 'required|exists:kerja_samas,id',
      'armada_id' => 'required|exists:armadas,id',
      'petugas_ids' => 'required|array|min:1',
      'petugas_ids.*' => 'exists:petugas,id',
      'status' => 'required|in:draft,scheduled,in_progress,completed,cancelled',
    ];

    if ($this->status === 'completed') {
      $rules['tanggal_realisasi'] = 'required|date';
      $rules['total_limbah_kg'] = 'required|numeric|min:0.01';
      $rules['manifest_elektronik'] = 'required|file|mimes:pdf|max:10240';
      $rules['bukti_foto_pengangkutan'] = 'required|file|mimes:jpg,jpeg,png|max:10240';
    } else {
      $rules['tanggal_realisasi'] = 'nullable|date';
      $rules['total_limbah_kg'] = 'nullable|numeric|min:0.01';
      $rules['manifest_elektronik'] = 'nullable|file|mimes:pdf|max:10240';
      $rules['bukti_foto_pengangkutan'] = 'nullable|file|mimes:jpg,jpeg,png|max:10240';
    }

    $messages = [
      'kode_jadwal.required' => 'Kode jadwal wajib diisi.',
      'kode_jadwal.unique' => 'Kode jadwal sudah digunakan.',
      'tanggal_pengangkutan.required' => 'Tanggal pengangkutan wajib diisi.',
      'kerja_sama_id.required' => 'Kerja sama wajib dipilih.',
      'armada_id.required' => 'Armada wajib dipilih.',
      'petugas_ids.required' => 'Minimal 1 petugas wajib dipilih.',
      'petugas_ids.min' => 'Minimal 1 petugas wajib dipilih.',
      'status.required' => 'Status wajib dipilih.',
      'status.in' => 'Status tidak valid.',
      'tanggal_realisasi.required' => 'Tanggal realisasi wajib diisi saat status Selesai.',
      'total_limbah_kg.required' => 'Total limbah wajib diisi saat status Selesai.',
      'total_limbah_kg.numeric' => 'Total limbah harus berupa angka.',
      'total_limbah_kg.min' => 'Total limbah harus lebih besar dari 0.',
      'manifest_elektronik.required' => 'Manifest elektronik wajib diunggah saat status Selesai.',
      'manifest_elektronik.mimes' => 'Manifest harus berformat PDF.',
      'manifest_elektronik.max' => 'Ukuran manifest maksimal 10 MB.',
      'bukti_foto_pengangkutan.required' => 'Bukti foto wajib diunggah saat status Selesai.',
      'bukti_foto_pengangkutan.mimes' => 'Bukti foto harus berformat JPG atau PNG.',
      'bukti_foto_pengangkutan.max' => 'Ukuran foto maksimal 10 MB.',
    ];

    $this->validate($rules, $messages);

    DB::transaction(function () {
      $kerjaSama = KerjaSama::with('fasilitasKesehatan')->find($this->kerja_sama_id);
      $armada = Armada::find($this->armada_id);

      $namaPetugas = Petugas::whereIn('id', $this->petugas_ids)
        ->orderBy('nama_petugas')
        ->pluck('nama_petugas')
        ->toArray();

      $manifestPath = null;
      $buktiFotoPath = null;
      $hargaPerKgRealisasi = null;
      $totalBiayaRealisasi = null;
      $totalLimbahKg = null;

      if ($this->status === 'completed') {
        if ($this->manifest_elektronik) {
          $manifestPath = $this->manifest_elektronik->store('jadwal/manifest', 'public');
        }

        if ($this->bukti_foto_pengangkutan) {
          $buktiFotoPath = $this->bukti_foto_pengangkutan->store('jadwal/bukti', 'public');
        }

        $hargaPerKgRealisasi = $kerjaSama?->harga_per_kilogram !== null
          ? (float) $kerjaSama->harga_per_kilogram
          : null;

        $totalLimbahKg = $this->total_limbah_kg !== null && $this->total_limbah_kg !== ''
          ? (float) $this->total_limbah_kg
          : null;

        $totalBiayaRealisasi = ($hargaPerKgRealisasi !== null && $totalLimbahKg !== null)
          ? $hargaPerKgRealisasi * $totalLimbahKg
          : null;
      }

      $jadwal = JadwalPengangkutan::create([
        'kode_jadwal' => $this->kode_jadwal,
        'tanggal_pengangkutan' => $this->tanggal_pengangkutan,
        'kerja_sama_id' => $this->kerja_sama_id,
        'armada_id' => $this->armada_id,
        'status' => $this->status,
        'tanggal_realisasi' => $this->status === 'completed' ? $this->tanggal_realisasi : null,
        'total_limbah_kg' => $this->status === 'completed' ? $totalLimbahKg : null,
        'harga_per_kg_realisasi' => $this->status === 'completed' ? $hargaPerKgRealisasi : null,
        'total_biaya_realisasi' => $this->status === 'completed' ? $totalBiayaRealisasi : null,
        'manifest_elektronik_path' => $manifestPath,
        'bukti_foto_pengangkutan_path' => $buktiFotoPath,

        'nama_fasilitas' => $kerjaSama?->nama_fasilitas_display ?? '',
        'armada' => $armada
          ? $armada->nomor_polisi . ' (' . $armada->jenis_kendaraan . ')'
          : '',
        'petugas_pic' => implode(', ', $namaPetugas),
      ]);

      $jadwal->petugas()->sync($this->petugas_ids);
    });

    session()->flash('success', 'Jadwal pengangkutan berhasil dibuat.');

    $this->redirect(route('jadwal-pengangkutan.index'), navigate: true);
  }

  public function render(): View
  {
    return view('livewire.jadwal-pengangkutan.create');
  }
}