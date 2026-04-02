<?php

namespace App\Livewire\FasilitasKesehatan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\FasilitasKesehatan;

#[Layout('layouts.app')]
#[Title('Tambah Fasilitas Kesehatan')]
class Create extends Component
{
    #[Validate('required|string|max:255')]
    public string $nama = '';

    #[Validate('required|string|max:255')]
    public string $jenis_fasilitas = '';

    #[Validate('required|string|max:255')]
    public string $kota_kabupaten = '';

    #[Validate('required|in:prospect,active,inactive')]
    public string $status = 'prospect';

    public array $jenisOptions = [
        'Rumah Sakit',
        'Klinik',
        'Puskesmas',
        'Klinik Pratama',
        'Rumah Sakit Umum',
        'Rumah Sakit Khusus',
    ];

    public array $statusOptions = [
        'prospect' => 'Prospek',
        'active'   => 'Aktif',
        'inactive' => 'Tidak Aktif',
    ];

    public function save(): void
    {
        $this->validate();

        FasilitasKesehatan::create([
            'nama'            => $this->nama,
            'jenis_fasilitas' => $this->jenis_fasilitas,
            'kota_kabupaten'  => $this->kota_kabupaten,
            'status'          => $this->status,
        ]);

        session()->flash('success', 'Fasilitas kesehatan berhasil ditambahkan.');

        $this->redirect(route('fasilitas-kesehatan.index'), navigate: false);
    }

    public function render()
    {
        return view('livewire.fasilitas-kesehatan.create');
    }
}
