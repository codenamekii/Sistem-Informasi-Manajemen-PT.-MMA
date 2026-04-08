<?php

namespace App\Livewire\KerjaSama;

use App\Livewire\Concerns\HasRoleGuard;
use App\Models\FasilitasKesehatan;
use App\Models\KerjaSama;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
  use HasRoleGuard;

  public KerjaSama $kerjaSama;

  public array $form = [
    'nomor_perjanjian' => '',
    'fasilitas_kesehatan_id' => '',
    'harga_per_kilogram' => '',
    'tanggal_mulai' => '',
    'tanggal_berakhir' => '',
    'status' => 'draft',
  ];

  public function mount(KerjaSama $kerjaSama): void
  {
    $this->kerjaSama = $kerjaSama;

    $this->form = [
      'nomor_perjanjian' => $kerjaSama->nomor_perjanjian,
      'fasilitas_kesehatan_id' => $kerjaSama->fasilitas_kesehatan_id ?? '',
      'harga_per_kilogram' => $kerjaSama->harga_per_kilogram ?? '',
      'tanggal_mulai' => optional($kerjaSama->tanggal_mulai)->format('Y-m-d'),
      'tanggal_berakhir' => optional($kerjaSama->tanggal_berakhir)->format('Y-m-d'),
      'status' => $kerjaSama->status,
    ];
  }

  public function getFasilitasOptionsProperty(): Collection
  {
    return FasilitasKesehatan::query()
      ->orderBy('nama')
      ->get(['id', 'nama']);
  }

  public function update(): mixed
  {
    if (!$this->guardAction('kerja_sama'))
      return null;

    $validated = $this->validate([
      'form.nomor_perjanjian' => ['required', 'string', 'max:255'],
      'form.fasilitas_kesehatan_id' => [
        'required',
        'integer',
        'exists:fasilitas_kesehatans,id',
        Rule::unique('kerja_samas', 'fasilitas_kesehatan_id')->ignore($this->kerjaSama->id),
      ],
      'form.harga_per_kilogram' => ['required', 'numeric', 'min:0'],
      'form.tanggal_mulai' => ['required', 'date'],
      'form.tanggal_berakhir' => ['required', 'date', 'after_or_equal:form.tanggal_mulai'],
      'form.status' => ['required', 'in:draft,active,expired,terminated'],
    ]);

    $fasilitas = FasilitasKesehatan::findOrFail($validated['form']['fasilitas_kesehatan_id']);

    $this->kerjaSama->update([
      'nomor_perjanjian' => $validated['form']['nomor_perjanjian'],
      'fasilitas_kesehatan_id' => $fasilitas->id,
      'nama_fasilitas_kesehatan' => $fasilitas->nama,
      'harga_per_kilogram' => $validated['form']['harga_per_kilogram'],
      'tanggal_mulai' => $validated['form']['tanggal_mulai'],
      'tanggal_berakhir' => $validated['form']['tanggal_berakhir'],
      'status' => $validated['form']['status'],
    ]);

    session()->flash('success', 'Kerja sama berhasil diperbarui.');

    return redirect()->route('kerja-sama.index');
  }

  public function render(): View
  {
    return view('livewire.kerja-sama.edit');
  }
}