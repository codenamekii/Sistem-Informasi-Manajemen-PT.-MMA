<?php

namespace App\Livewire\FasilitasKesehatan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\FasilitasKesehatan;

#[Layout('layouts.app')]
#[Title('Edit Fasilitas Kesehatan')]
class Edit extends Component
{
    public FasilitasKesehatan $fasilitas;

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

    public function mount(FasilitasKesehatan $fasilitasKesehatan): void
    {
        $this->fasilitas       = $fasilitasKesehatan;
        $this->nama            = $fasilitasKesehatan->nama;
        $this->jenis_fasilitas = $fasilitasKesehatan->jenis_fasilitas;
        $this->kota_kabupaten  = $fasilitasKesehatan->kota_kabupaten;
        $this->status          = $fasilitasKesehatan->status;
    }

    public function update(): void
    {
        $this->validate();

        $this->fasilitas->update([
            'nama'            => $this->nama,
            'jenis_fasilitas' => $this->jenis_fasilitas,
            'kota_kabupaten'  => $this->kota_kabupaten,
            'status'          => $this->status,
        ]);

        session()->flash('success', 'Data fasilitas kesehatan berhasil diperbarui.');

        $this->redirect(
            route('fasilitas-kesehatan.show', $this->fasilitas),
            navigate: false
        );
    }

    public function render()
    {
        return view('livewire.fasilitas-kesehatan.edit');
    }
}
