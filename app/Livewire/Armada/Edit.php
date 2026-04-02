<?php

namespace App\Livewire\Armada;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\Armada;

#[Layout('layouts.app')]
#[Title('Edit Armada')]
class Edit extends Component
{
    public Armada $armada;

    #[Validate('required|string|max:50')]
    public string $kode_armada = '';

    #[Validate('required|string|max:20')]
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

    public function mount(Armada $armada): void
    {
        $this->armada          = $armada;
        $this->kode_armada     = $armada->kode_armada;
        $this->nomor_polisi    = $armada->nomor_polisi;
        $this->jenis_kendaraan = $armada->jenis_kendaraan;
        $this->kapasitas       = $armada->kapasitas;
        $this->status          = $armada->status;
    }

    public function update(): void
    {
        $this->validate();

        $this->validateUnique();

        $this->armada->update([
            'kode_armada'     => strtoupper(trim($this->kode_armada)),
            'nomor_polisi'    => strtoupper(trim($this->nomor_polisi)),
            'jenis_kendaraan' => $this->jenis_kendaraan,
            'kapasitas'       => $this->kapasitas,
            'status'          => $this->status,
        ]);

        session()->flash('success', 'Data armada berhasil diperbarui.');

        $this->redirect(
            route('armada.show', $this->armada),
            navigate: false
        );
    }

    protected function validateUnique(): void
    {
        $kodeExists = Armada::where('kode_armada', strtoupper(trim($this->kode_armada)))
            ->where('id', '!=', $this->armada->id)
            ->exists();

        if ($kodeExists) {
            $this->addError('kode_armada', 'Kode armada sudah digunakan oleh kendaraan lain.');
            return;
        }

        $polisiExists = Armada::where('nomor_polisi', strtoupper(trim($this->nomor_polisi)))
            ->where('id', '!=', $this->armada->id)
            ->exists();

        if ($polisiExists) {
            $this->addError('nomor_polisi', 'Nomor polisi sudah digunakan oleh kendaraan lain.');
        }
    }

    public function render()
    {
        return view('livewire.armada.edit');
    }
}
