<?php

namespace App\Livewire\JadwalPengangkutan;

use App\Models\JadwalPengangkutan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Show extends Component
{
    public JadwalPengangkutan $jadwalPengangkutan;
    public array $detail = [];

    public function mount(JadwalPengangkutan $jadwalPengangkutan): void
    {
        $jadwalPengangkutan->load(['kerjaSama.fasilitasKesehatan', 'armadaRelasi', 'petugas']);

        $this->jadwalPengangkutan = $jadwalPengangkutan;

        // Petugas dari pivot atau fallback legacy
        $petugasList = $jadwalPengangkutan->petugas->isNotEmpty()
            ? $jadwalPengangkutan->petugas->map(fn ($p) => [
                'nama'    => $p->nama_petugas,
                'jabatan' => $p->jabatan ?: '—',
              ])->all()
            : [];

        // URL file bukti
        $manifestUrl  = $jadwalPengangkutan->manifest_elektronik_path
            ? Storage::url($jadwalPengangkutan->manifest_elektronik_path)
            : null;

        $buktiFotoUrl = $jadwalPengangkutan->bukti_foto_pengangkutan_path
            ? Storage::url($jadwalPengangkutan->bukti_foto_pengangkutan_path)
            : null;

        $this->detail = [
            'id'                     => $jadwalPengangkutan->id,
            'kode_jadwal'            => $jadwalPengangkutan->kode_jadwal,
            'tanggal_pengangkutan'   => $jadwalPengangkutan->tanggal_pengangkutan ? Carbon::parse($jadwalPengangkutan->tanggal_pengangkutan)->format('d/m/Y') : '—',
            'tanggal_realisasi'      => $jadwalPengangkutan->tanggal_realisasi ? Carbon::parse($jadwalPengangkutan->tanggal_realisasi)->format('d/m/Y') : '—',
            'nama_fasilitas_display' => $jadwalPengangkutan->nama_fasilitas_display,
            'armada_display'         => $jadwalPengangkutan->armada_display,
            'petugas_list'           => $petugasList,
            'petugas_fallback'       => $jadwalPengangkutan->petugas_pic ?: '—',
            'is_connected'           => ! is_null($jadwalPengangkutan->kerja_sama_id),
            'status'                 => $jadwalPengangkutan->status,
            'has_bukti_lengkap'      => $jadwalPengangkutan->has_bukti_lengkap,
            'manifest_url'           => $manifestUrl,
            'bukti_foto_url'         => $buktiFotoUrl,
            'nomor_perjanjian'       => $jadwalPengangkutan->kerjaSama?->nomor_perjanjian ?: '—',
        ];
    }

    public function render(): View
    {
        return view('livewire.jadwal-pengangkutan.show');
    }
}