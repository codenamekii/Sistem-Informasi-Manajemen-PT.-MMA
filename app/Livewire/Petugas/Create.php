<?php

namespace App\Livewire\Petugas;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\Petugas;

#[Layout('layouts.app')]
#[Title('Tambah Petugas')]
class Create extends Component
{
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

    public function save(): void
    {
        $this->validate();

        Petugas::create([
            'nama_petugas'  => $this->nama_petugas,
            'jabatan'       => $this->jabatan,
            'nomor_telepon' => $this->nomor_telepon,
            'wilayah_tugas' => $this->wilayah_tugas,
            'status'        => $this->status,
        ]);

        session()->flash('success', 'Petugas berhasil ditambahkan.');

        $this->redirect(route('petugas.index'), navigate: false);
    }

    public function render()
    {
        return view('livewire.petugas.create');
    }
}
