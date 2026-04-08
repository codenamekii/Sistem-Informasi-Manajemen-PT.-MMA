<?php

namespace App\Livewire\Dokumen;

use App\Models\Dokumen;
use App\Models\KerjaSama;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Dokumen $dokumen;

    public array $form = [
        'nama_dokumen' => '',
        'kategori_dokumen' => '',
        'nomor_referensi' => '',
        'kerja_sama_id' => '',
        'tanggal_berlaku_sampai' => '',
        'status' => 'valid',
    ];

    public function mount(Dokumen $dokumen): void
    {
        $this->dokumen = $dokumen;

        $this->form = [
            'nama_dokumen' => $dokumen->nama_dokumen,
            'kategori_dokumen' => $dokumen->kategori_dokumen,
            'nomor_referensi' => $dokumen->nomor_referensi,
            'kerja_sama_id' => $dokumen->kerja_sama_id ?? '',
            'tanggal_berlaku_sampai' => optional($dokumen->tanggal_berlaku_sampai)->format('Y-m-d'),
            'status' => $dokumen->status,
        ];
    }

    public function getKerjaSamaOptionsProperty(): Collection
    {
        return KerjaSama::query()
            ->with('fasilitasKesehatan:id,nama')
            ->orderByDesc('tanggal_mulai')
            ->orderBy('nomor_perjanjian')
            ->get();
    }

    public function updatedFormKategoriDokumen($value): void
    {
        if (! in_array($value, ['perjanjian', 'MoU'], true)) {
            $this->form['kerja_sama_id'] = '';
        }
    }

    protected function requiresKerjaSama(): bool
    {
        return in_array($this->form['kategori_dokumen'] ?? '', ['perjanjian', 'MoU'], true);
    }

    public function update()
    {
        $validated = $this->validate([
            'form.nama_dokumen' => ['required', 'string', 'max:255'],
            'form.kategori_dokumen' => ['required', 'in:perjanjian,MoU,izin,legalitas,administrasi,lainnya'],
            'form.nomor_referensi' => ['required', 'string', 'max:255'],
            'form.kerja_sama_id' => [
                Rule::requiredIf(fn() => $this->requiresKerjaSama()),
                'nullable',
                'integer',
                'exists:kerja_samas,id',
            ],
            'form.tanggal_berlaku_sampai' => ['nullable', 'date'],
            'form.status' => ['required', 'in:valid,expiring_soon,expired,missing'],
        ]);

        $payload = [
            'nama_dokumen' => $validated['form']['nama_dokumen'],
            'kategori_dokumen' => $validated['form']['kategori_dokumen'],
            'nomor_referensi' => $validated['form']['nomor_referensi'],
            'tanggal_berlaku_sampai' => $validated['form']['tanggal_berlaku_sampai'] ?: null,
            'status' => $validated['form']['status'],
            'kerja_sama_id' => null,
            'terkait_dengan' => null,
        ];

        if ($this->requiresKerjaSama()) {
            $kerjaSama = KerjaSama::with('fasilitasKesehatan')->findOrFail($validated['form']['kerja_sama_id']);

            $payload['kerja_sama_id'] = $kerjaSama->id;
            $payload['terkait_dengan'] = $kerjaSama->nomor_perjanjian . ' - ' . $kerjaSama->nama_fasilitas_display;
        }

        $this->dokumen->update($payload);

        session()->flash('success', 'Dokumen berhasil diperbarui.');

        return redirect()->route('dokumen.index');
    }

    public function render(): View
    {
        return view('livewire.dokumen.edit');
    }
}
