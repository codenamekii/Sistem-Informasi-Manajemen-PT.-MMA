<?php

namespace App\Livewire\Petugas;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\Petugas;

#[Layout('layouts.app')]
#[Title('Edit Petugas')]
class Edit extends Component
{
    public Petugas $petugas;

    #[Validate('required|string|max:255')]
    public string $nama_petugas = '';

    #[Validate('required|string|max:100')]
    public string $jabatan = '';

    #[Validate('required|string|max:20')]
    public string $nomor_telepon = '';

    #[Validate('required|string|max:100')]
    public string $wilayah_tugas = '';

    #[Validate('required|in:active,on_leave,inactive')]
    public string $status = 'active';

    public array $jabatanOptions = [
        'Sopir Pengangkut',
        'Koordinator Lapangan',
        'Teknisi',
        'Supervisor',
        'Lainnya',
    ];

    public array $statusOptions = [
        'active'   => 'Aktif',
        'on_leave' => 'Cuti',
        'inactive' => 'Tidak Aktif',
    ];

    public function mount(Petugas $petugas): void
    {
        $this->petugas       = $petugas;
        $this->nama_petugas  = $petugas->nama_petugas;
        $this->jabatan       = $petugas->jabatan;
        $this->nomor_telepon = $petugas->nomor_telepon;
        $this->wilayah_tugas = $petugas->wilayah_tugas;
        $this->status        = $petugas->status;
    }

    public function update(): void
    {
        $this->validate();

        $this->petugas->update([
            'nama_petugas'  => $this->nama_petugas,
            'jabatan'       => $this->jabatan,
            'nomor_telepon' => $this->nomor_telepon,
            'wilayah_tugas' => $this->wilayah_tugas,
            'status'        => $this->status,
        ]);

        session()->flash('success', 'Data petugas berhasil diperbarui.');

        $this->redirect(
            route('petugas.show', $this->petugas),
            navigate: false
        );
    }

    public function render()
    {
        return view('livewire.petugas.edit');
    }
}
