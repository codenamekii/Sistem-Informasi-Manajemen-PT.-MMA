<?php

namespace App\Livewire\KerjaSama;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\KerjaSama;

#[Layout('layouts.app')]
#[Title('Tambah Kerja Sama')]
class Create extends Component
{
    #[Validate('required|string|max:100|unique:kerja_samas,nomor_perjanjian')]
    public string $nomor_perjanjian = '';

    #[Validate('required|string|max:255')]
    public string $nama_fasilitas_kesehatan = '';

    #[Validate('required|date')]
    public string $tanggal_mulai = '';

    #[Validate('required|date|after_or_equal:tanggal_mulai')]
    public string $tanggal_berakhir = '';

    #[Validate('required|in:draft,active,expired,terminated')]
    public string $status = 'draft';

    public array $statusOptions = [
        'draft'      => 'Draft',
        'active'     => 'Aktif',
        'expired'    => 'Kadaluarsa',
        'terminated' => 'Dihentikan',
    ];

    public function save(): void
    {
        $this->validate();

        KerjaSama::create([
            'nomor_perjanjian'        => $this->nomor_perjanjian,
            'nama_fasilitas_kesehatan' => $this->nama_fasilitas_kesehatan,
            'tanggal_mulai'           => $this->tanggal_mulai,
            'tanggal_berakhir'        => $this->tanggal_berakhir,
            'status'                  => $this->status,
        ]);

        session()->flash('success', 'Data kerja sama berhasil ditambahkan.');

        $this->redirect(route('kerja-sama.index'), navigate: false);
    }

    public function render()
    {
        return view('livewire.kerja-sama.create');
    }
}
