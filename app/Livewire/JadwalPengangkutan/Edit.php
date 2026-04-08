<?php

namespace App\Livewire\JadwalPengangkutan;

use App\Models\Armada;
use App\Models\JadwalPengangkutan;
use App\Models\KerjaSama;
use App\Models\Petugas;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
  use WithFileUploads;

  public JadwalPengangkutan $jadwal;

  public string $kode_jadwal = '';
  public string $tanggal_pengangkutan = '';
  public ?int $kerja_sama_id = null;
  public ?int $armada_id = null;
  public array $petugas_ids = [];
  public string $status = 'draft';

  // Field realisasi
  public string $tanggal_realisasi = '';
  public $manifest_elektronik = null;
  public $bukti_foto_pengangkutan = null;

  public function mount(JadwalPengangkutan $jadwalPengangkutan): void
  {
    $this->jadwal = $jadwalPengangkutan->load('petugas');

    // Pre-populate dari data existing
    $this->kode_jadwal = $jadwalPengangkutan->kode_jadwal;
    $this->tanggal_pengangkutan = Carbon::parse($jadwalPengangkutan->tanggal_pengangkutan)->format('Y-m-d') ?? '';
    $this->kerja_sama_id = $jadwalPengangkutan->kerja_sama_id;
    $this->armada_id = $jadwalPengangkutan->armada_id;
    $this->status = $jadwalPengangkutan->status;
    $this->tanggal_realisasi = Carbon::parse($jadwalPengangkutan->tanggal_realisasi)->format('Y-m-d') ?? '';

    // Pre-populate petugas dari pivot
    $this->petugas_ids = $jadwalPengangkutan->petugas->pluck('id')->toArray();
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
    // Validasi inti
    $rules = [
      'kode_jadwal' => 'required|string|max:50|unique:jadwal_pengangkutans,kode_jadwal,' . $this->jadwal->id,
      'tanggal_pengangkutan' => 'required|date',
      'kerja_sama_id' => 'required|exists:kerja_samas,id',
      'armada_id' => 'required|exists:armadas,id',
      'petugas_ids' => 'required|array|min:1',
      'petugas_ids.*' => 'exists:petugas,id',
      'status' => 'required|in:draft,scheduled,in_progress,completed,cancelled',
    ];

    // Validasi kondisional saat completed
    if ($this->status === 'completed') {
      $rules['tanggal_realisasi'] = 'required|date';

      // File baru hanya wajib jika belum ada file lama
      $rules['manifest_elektronik'] = $this->jadwal->manifest_elektronik_path
        ? 'nullable|file|mimes:pdf|max:10240'
        : 'required|file|mimes:pdf|max:10240';

      $rules['bukti_foto_pengangkutan'] = $this->jadwal->bukti_foto_pengangkutan_path
        ? 'nullable|file|mimes:jpg,jpeg,png|max:10240'
        : 'required|file|mimes:jpg,jpeg,png|max:10240';
    } else {
      $rules['tanggal_realisasi'] = 'nullable|date';
      $rules['manifest_elektronik'] = 'nullable';
      $rules['bukti_foto_pengangkutan'] = 'nullable';
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
      'manifest_elektronik.required' => 'Manifest elektronik wajib diunggah saat status Selesai.',
      'manifest_elektronik.mimes' => 'Manifest harus berformat PDF.',
      'manifest_elektronik.max' => 'Ukuran manifest maksimal 10 MB.',
      'bukti_foto_pengangkutan.required' => 'Bukti foto wajib diunggah saat status Selesai.',
      'bukti_foto_pengangkutan.mimes' => 'Bukti foto harus berformat JPG atau PNG.',
      'bukti_foto_pengangkutan.max' => 'Ukuran foto maksimal 10 MB.',
    ];

    $this->validate($rules, $messages);

    // Load relasi untuk fallback legacy
    $kerjaSama = KerjaSama::with('fasilitasKesehatan')->find($this->kerja_sama_id);
    $armada = Armada::find($this->armada_id);
    $namaPetugas = Petugas::whereIn('id', $this->petugas_ids)
      ->orderBy('nama_petugas')
      ->pluck('nama_petugas');

    // Simpan file bukti — jika ada file baru, ganti; jika tidak, pertahankan yang lama
    $manifestPath = $this->jadwal->manifest_elektronik_path;
    $buktiFotoPath = $this->jadwal->bukti_foto_pengangkutan_path;

    if ($this->status === 'completed') {
      if ($this->manifest_elektronik) {
        $manifestPath = $this->manifest_elektronik->store('jadwal/manifest', 'public');
      }
      if ($this->bukti_foto_pengangkutan) {
        $buktiFotoPath = $this->bukti_foto_pengangkutan->store('jadwal/bukti', 'public');
      }
    }

    $this->jadwal->update([
      'kode_jadwal' => $this->kode_jadwal,
      'tanggal_pengangkutan' => $this->tanggal_pengangkutan,
      'kerja_sama_id' => $this->kerja_sama_id,
      'armada_id' => $this->armada_id,
      'status' => $this->status,
      'tanggal_realisasi' => $this->status === 'completed' ? $this->tanggal_realisasi : $this->jadwal->tanggal_realisasi,
      'manifest_elektronik_path' => $manifestPath,
      'bukti_foto_pengangkutan_path' => $buktiFotoPath,

      // Fallback legacy
      'nama_fasilitas' => $kerjaSama?->nama_fasilitas_display ?: $this->jadwal->nama_fasilitas,
      'armada' => $armada
        ? $armada->nomor_polisi . ' (' . $armada->jenis_kendaraan . ')'
        : $this->jadwal->armada,
      'petugas_pic' => $namaPetugas->join(', '),
    ]);

    $this->jadwal->petugas()->sync($this->petugas_ids);

    session()->flash('success', 'Jadwal pengangkutan berhasil diperbarui.');

    $this->redirect(route('jadwal-pengangkutan.index'), navigate: true);
  }

  public function render(): View
  {
    return view('livewire.jadwal-pengangkutan.edit');
  }
}