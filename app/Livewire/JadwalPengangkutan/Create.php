<?php

namespace App\Livewire\JadwalPengangkutan;

use App\Models\Armada;
use App\Models\JadwalPengangkutan;
use App\Models\KerjaSama;
use App\Models\Petugas;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public string $kode_jadwal             = '';
    public string $tanggal_pengangkutan    = '';
    public ?int   $kerja_sama_id           = null;
    public ?int   $armada_id               = null;
    public array  $petugas_ids             = [];
    public string $status                  = 'draft';

    // Field realisasi — hanya wajib saat status = completed
    public string $tanggal_realisasi       = '';
    public $manifest_elektronik            = null;
    public $bukti_foto_pengangkutan        = null;

    public function mount(): void
    {
        $this->kode_jadwal = $this->generateKodeJadwal();
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
        // Validasi inti — selalu berlaku
        $rules = [
            'kode_jadwal'          => 'required|string|max:50|unique:jadwal_pengangkutans,kode_jadwal',
            'tanggal_pengangkutan' => 'required|date',
            'kerja_sama_id'        => 'required|exists:kerja_samas,id',
            'armada_id'            => 'required|exists:armadas,id',
            'petugas_ids'          => 'required|array|min:1',
            'petugas_ids.*'        => 'exists:petugas,id',
            'status'               => 'required|in:draft,scheduled,in_progress,completed,cancelled',
        ];

        // Validasi kondisional — hanya wajib saat status = completed
        if ($this->status === 'completed') {
            $rules['tanggal_realisasi']      = 'required|date';
            $rules['manifest_elektronik']    = 'required|file|mimes:pdf|max:10240';
            $rules['bukti_foto_pengangkutan']= 'required|file|mimes:jpg,jpeg,png|max:10240';
        } else {
            $rules['tanggal_realisasi']      = 'nullable|date';
            $rules['manifest_elektronik']    = 'nullable';
            $rules['bukti_foto_pengangkutan']= 'nullable';
        }

        $messages = [
            'kode_jadwal.required'               => 'Kode jadwal wajib diisi.',
            'kode_jadwal.unique'                 => 'Kode jadwal sudah digunakan.',
            'tanggal_pengangkutan.required'      => 'Tanggal pengangkutan wajib diisi.',
            'kerja_sama_id.required'             => 'Kerja sama wajib dipilih.',
            'armada_id.required'                 => 'Armada wajib dipilih.',
            'petugas_ids.required'               => 'Minimal 1 petugas wajib dipilih.',
            'petugas_ids.min'                    => 'Minimal 1 petugas wajib dipilih.',
            'status.required'                    => 'Status wajib dipilih.',
            'status.in'                          => 'Status tidak valid.',
            'tanggal_realisasi.required'         => 'Tanggal realisasi wajib diisi saat status Selesai.',
            'manifest_elektronik.required'       => 'Manifest elektronik wajib diunggah saat status Selesai.',
            'manifest_elektronik.mimes'          => 'Manifest harus berformat PDF.',
            'manifest_elektronik.max'            => 'Ukuran manifest maksimal 10 MB.',
            'bukti_foto_pengangkutan.required'   => 'Bukti foto wajib diunggah saat status Selesai.',
            'bukti_foto_pengangkutan.mimes'      => 'Bukti foto harus berformat JPG atau PNG.',
            'bukti_foto_pengangkutan.max'        => 'Ukuran foto maksimal 10 MB.',
        ];

        $this->validate($rules, $messages);

        // Load relasi untuk fallback legacy
        $kerjaSama   = KerjaSama::with('fasilitasKesehatan')->find($this->kerja_sama_id);
        $armada      = Armada::find($this->armada_id);
        $namaPetugas = Petugas::whereIn('id', $this->petugas_ids)
            ->orderBy('nama_petugas')
            ->pluck('nama_petugas');

        // Simpan file bukti jika status completed
        $manifestPath  = null;
        $buktiFotoPath = null;

        if ($this->status === 'completed') {
            $manifestPath  = $this->manifest_elektronik->store('jadwal/manifest', 'public');
            $buktiFotoPath = $this->bukti_foto_pengangkutan->store('jadwal/bukti', 'public');
        }

        $jadwal = JadwalPengangkutan::create([
            'kode_jadwal'                   => $this->kode_jadwal,
            'tanggal_pengangkutan'          => $this->tanggal_pengangkutan,
            'kerja_sama_id'                 => $this->kerja_sama_id,
            'armada_id'                     => $this->armada_id,
            'status'                        => $this->status,
            'tanggal_realisasi'             => $this->status === 'completed' ? $this->tanggal_realisasi : null,
            'manifest_elektronik_path'      => $manifestPath,
            'bukti_foto_pengangkutan_path'  => $buktiFotoPath,

            // Fallback legacy
            'nama_fasilitas' => $kerjaSama?->nama_fasilitas_display ?: '',
            'armada'         => $armada
                ? $armada->nomor_polisi . ' (' . $armada->jenis_kendaraan . ')'
                : '',
            'petugas_pic'    => $namaPetugas->join(', '),
        ]);

        $jadwal->petugas()->sync($this->petugas_ids);

        session()->flash('success', 'Jadwal pengangkutan berhasil dibuat.');

        $this->redirect(route('jadwal-pengangkutan.index'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.jadwal-pengangkutan.create');
    }
}