<?php

namespace App\Livewire\Armada;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\Armada;

#[Layout('layouts.app')]
#[Title('Tambah Armada')]
class Create extends Component
{
    #[Validate('required|string|max:50|unique:armadas,kode_armada')]
    public string $kode_armada = '';

    #[Validate('required|string|max:20|unique:armadas,nomor_polisi')]
    public string $nomor_polisi = '';

    #[Validate('required|string|max:100')]
    public string $jenis_kendaraan = '';

    #[Validate('required|string|max:50')]
    public string $kapasitas = '';

    #[Validate('required|in:available,in_use,maintenance,inactive')]
    public string $status = 'available';

    public array $jenisOptions = [
        'Truk Pengangkut',
        'Truk Kecil',
        'Pick-up',
        'Van',
        'Lainnya',
    ];

    public array $statusOptions = [
        'available'   => 'Tersedia',
        'in_use'      => 'Digunakan',
        'maintenance' => 'Perawatan',
        'inactive'    => 'Tidak Aktif',
    ];

    public function save(): void
    {
        $this->validate();

        Armada::create([
            'kode_armada'     => strtoupper(trim($this->kode_armada)),
            'nomor_polisi'    => strtoupper(trim($this->nomor_polisi)),
            'jenis_kendaraan' => $this->jenis_kendaraan,
            'kapasitas'       => $this->kapasitas,
            'status'          => $this->status,
        ]);

        session()->flash('success', 'Armada berhasil ditambahkan.');

        $this->redirect(route('armada.index'), navigate: false);
    }

    public function render()
    {
        return view('livewire.armada.create');
    }
}
