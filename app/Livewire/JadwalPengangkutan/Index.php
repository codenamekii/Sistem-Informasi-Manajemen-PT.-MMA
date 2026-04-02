<?php

namespace App\Livewire\JadwalPengangkutan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Jadwal Pengangkutan')]
class Index extends Component
{
    public string $search = '';

    public function getJadwalProperty(): array
    {
        $data = [
            [
                'kode_jadwal'          => 'JPK-2025-001',
                'tanggal_pengangkutan' => '2025-07-01',
                'nama_fasilitas'       => 'RSUD Dr. Wahidin Sudirohusodo',
                'armada'               => 'DD 1234 AB',
                'petugas_pic'          => 'Ahmad Fauzi',
                'status'               => 'completed',
            ],
            [
                'kode_jadwal'          => 'JPK-2025-002',
                'tanggal_pengangkutan' => '2025-07-05',
                'nama_fasilitas'       => 'RS Islam Faisal',
                'armada'               => 'DD 3456 GH',
                'petugas_pic'          => 'Budi Santoso',
                'status'               => 'completed',
            ],
            [
                'kode_jadwal'          => 'JPK-2025-003',
                'tanggal_pengangkutan' => '2025-07-10',
                'nama_fasilitas'       => 'Puskesmas Antang',
                'armada'               => 'DD 5678 CD',
                'petugas_pic'          => 'Siti Rahma',
                'status'               => 'in_progress',
            ],
            [
                'kode_jadwal'          => 'JPK-2025-004',
                'tanggal_pengangkutan' => '2025-07-15',
                'nama_fasilitas'       => 'Klinik Pratama Sehat Bersama',
                'armada'               => 'DD 1234 AB',
                'petugas_pic'          => 'Ahmad Fauzi',
                'status'               => 'scheduled',
            ],
            [
                'kode_jadwal'          => 'JPK-2025-005',
                'tanggal_pengangkutan' => '2025-07-20',
                'nama_fasilitas'       => 'RS Bhayangkara Makassar',
                'armada'               => 'DD 9012 EF',
                'petugas_pic'          => 'Rina Marlina',
                'status'               => 'draft',
            ],
            [
                'kode_jadwal'          => 'JPK-2025-006',
                'tanggal_pengangkutan' => '2025-06-28',
                'nama_fasilitas'       => 'Klinik Utama Medistra',
                'armada'               => 'DD 7890 IJ',
                'petugas_pic'          => 'Deni Kurniawan',
                'status'               => 'cancelled',
            ],
        ];

        if ($this->search === '') {
            return $data;
        }

        $keyword = strtolower($this->search);

        return array_values(array_filter($data, function ($item) use ($keyword) {
            return str_contains(strtolower($item['kode_jadwal']), $keyword)
                || str_contains(strtolower($item['nama_fasilitas']), $keyword)
                || str_contains(strtolower($item['petugas_pic']), $keyword);
        }));
    }

    public function getTotalProperty(): int
    {
        return count($this->jadwal);
    }

    public function getScheduledProperty(): int
    {
        return count(array_filter($this->jadwal, fn($j) => $j['status'] === 'scheduled'));
    }

    public function getInProgressProperty(): int
    {
        return count(array_filter($this->jadwal, fn($j) => $j['status'] === 'in_progress'));
    }

    public function getCompletedProperty(): int
    {
        return count(array_filter($this->jadwal, fn($j) => $j['status'] === 'completed'));
    }

    public function render()
    {
        return view('livewire.jadwal-pengangkutan.index');
    }
}
