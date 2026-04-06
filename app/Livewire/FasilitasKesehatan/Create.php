<?php

namespace App\Livewire\FasilitasKesehatan;

use App\Models\FasilitasKesehatan;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    public array $form = [
        'nama' => '',
        'jenis_fasilitas' => '',
        'kota_kabupaten' => '',
        'provinsi' => '',
        'status' => 'prospect',
        'status_penawaran' => 'belum_masuk_penawaran',
        'pic_nama' => '',
        'pic_nomor_telepon' => '',
        'kendala' => '',
    ];

    public function save()
    {
        $validated = $this->validate([
            'form.nama' => ['required', 'string', 'max:255'],
            'form.jenis_fasilitas' => ['required', 'string', 'max:255'],
            'form.kota_kabupaten' => ['required', 'string', 'max:255'],
            'form.provinsi' => ['nullable', 'string', 'max:255'],
            'form.status' => ['required', 'in:prospect,active,inactive'],
            'form.status_penawaran' => ['required', 'in:masuk_penawaran,belum_masuk_penawaran'],
            'form.pic_nama' => ['nullable', 'string', 'max:255'],
            'form.pic_nomor_telepon' => ['nullable', 'string', 'max:255'],
            'form.kendala' => ['nullable', 'string'],
        ]);

        FasilitasKesehatan::create($this->normalizePayload($validated['form']));

        session()->flash('success', 'Fasilitas kesehatan berhasil ditambahkan.');

        return redirect()->route('fasilitas-kesehatan.index');
    }

    protected function normalizePayload(array $payload): array
    {
        foreach (['provinsi', 'pic_nama', 'pic_nomor_telepon', 'kendala'] as $field) {
            if (array_key_exists($field, $payload) && trim((string) $payload[$field]) === '') {
                $payload[$field] = null;
            }
        }

        return $payload;
    }

    public function render(): View
    {
        return view('livewire.fasilitas-kesehatan.create');
    }
}
