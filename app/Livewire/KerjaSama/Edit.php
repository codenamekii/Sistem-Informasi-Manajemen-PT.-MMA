<?php

namespace App\Livewire\KerjaSama;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\KerjaSama;

#[Layout('layouts.app')]
#[Title('Edit Kerja Sama')]
class Edit extends Component
{
    public KerjaSama $kerjaSama;

    #[Validate('required|string|max:100')]
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

    public function mount(KerjaSama $kerjaSama): void
    {
        $this->kerjaSama               = $kerjaSama;
        $this->nomor_perjanjian        = $kerjaSama->nomor_perjanjian;
        $this->nama_fasilitas_kesehatan = $kerjaSama->nama_fasilitas_kesehatan;
        $this->tanggal_mulai           = $kerjaSama->tanggal_mulai->format('Y-m-d');
        $this->tanggal_berakhir        = $kerjaSama->tanggal_berakhir->format('Y-m-d');
        $this->status                  = $kerjaSama->status;
    }

    public function update(): void
    {
        $this->validate();

        $this->validateUnique();

        $this->kerjaSama->update([
            'nomor_perjanjian'         => $this->nomor_perjanjian,
            'nama_fasilitas_kesehatan' => $this->nama_fasilitas_kesehatan,
            'tanggal_mulai'            => $this->tanggal_mulai,
            'tanggal_berakhir'         => $this->tanggal_berakhir,
            'status'                   => $this->status,
        ]);

        session()->flash('success', 'Data kerja sama berhasil diperbarui.');

        $this->redirect(
            route('kerja-sama.show', $this->kerjaSama),
            navigate: false
        );
    }

    protected function validateUnique(): void
    {
        $exists = KerjaSama::where('nomor_perjanjian', $this->nomor_perjanjian)
            ->where('id', '!=', $this->kerjaSama->id)
            ->exists();

        if ($exists) {
            $this->addError('nomor_perjanjian', 'Nomor perjanjian sudah digunakan oleh data lain.');
            $this->halt();
        }
    }

    public function render()
    {
        return view('livewire.kerja-sama.edit');
    }
}
