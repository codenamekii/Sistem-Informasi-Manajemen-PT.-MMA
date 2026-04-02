<?php

namespace App\Livewire\Dokumen;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\Dokumen;

#[Layout('layouts.app')]
#[Title('Tambah Dokumen')]
class Create extends Component
{
    #[Validate('required|string|max:255')]
    public string $nama_dokumen = '';

    #[Validate('required|string|max:100')]
    public string $kategori_dokumen = '';

    #[Validate('nullable|string|max:100')]
    public ?string $nomor_referensi = null;

    #[Validate('required|string|max:255')]
    public string $terkait_dengan = '';

    #[Validate('nullable|date')]
    public ?string $tanggal_berlaku_sampai = null;

    #[Validate('required|in:valid,expiring_soon,expired,missing')]
    public string $status = 'valid';

    public array $kategoriOptions = [
        'Perjanjian',
        'MOU',
        'Izin',
        'Sertifikat',
        'Lingkungan',
        'Lainnya',
    ];

    public array $statusOptions = [
        'valid'         => 'Valid',
        'expiring_soon' => 'Segera Berakhir',
        'expired'       => 'Kadaluarsa',
        'missing'       => 'Tidak Ada',
    ];

    public function save(): void
    {
        $this->validate();

        Dokumen::create([
            'nama_dokumen'           => $this->nama_dokumen,
            'kategori_dokumen'       => $this->kategori_dokumen,
            'nomor_referensi'        => $this->nomor_referensi ?: null,
            'terkait_dengan'         => $this->terkait_dengan,
            'tanggal_berlaku_sampai' => $this->tanggal_berlaku_sampai ?: null,
            'status'                 => $this->status,
        ]);

        session()->flash('success', 'Dokumen berhasil ditambahkan.');

        $this->redirect(route('dokumen.index'), navigate: false);
    }

    public function render()
    {
        return view('livewire.dokumen.create');
    }
}
