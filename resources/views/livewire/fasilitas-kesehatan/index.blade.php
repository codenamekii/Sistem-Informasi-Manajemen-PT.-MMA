<div>

  {{-- Flash Message --}}
  <x-alert type="success" :message="session('success')" />

  {{-- Page Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <x-page-header title="Fasilitas Kesehatan" description="Daftar fasilitas kesehatan mitra PT. Mitra Mecca Abadi."
      class="mb-0" />
    <a href="{{ route('fasilitas-kesehatan.create') }}"
      class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium
                  text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4
                  focus:ring-blue-300 transition-colors duration-200 shrink-0">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Tambah Fasilitas
    </a>
  </div>

  {{-- Summary Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

    <x-stat-card title="Total Fasilitas" :value="$this->total" description="Semua status" color="blue">
      <x-slot:icon>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5
                             m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0
                             011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
      </x-slot:icon>
    </x-stat-card>

    <x-stat-card title="Aktif" :value="$this->aktif" description="Kerja sama berjalan" color="green">
      <x-slot:icon>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </x-slot:icon>
    </x-stat-card>

    <x-stat-card title="Prospek" :value="$this->prospect" description="Dalam penjajakan" color="yellow">
      <x-slot:icon>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </x-slot:icon>
    </x-stat-card>

  </div>

  {{-- Tabel --}}
  <div class="bg-white rounded-lg border border-gray-200 shadow-sm">

    {{-- Toolbar --}}
    <div
      class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-5 py-4
                    border-b border-gray-100">
      <h3 class="text-sm font-semibold text-gray-700">Daftar Fasilitas</h3>
      <div class="w-full sm:w-64">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, kota, jenis..."
          class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm
                           rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
      </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-600">
        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
          <tr>
            <th class="px-5 py-3 font-medium">Nama Fasilitas</th>
            <th class="px-5 py-3 font-medium">Jenis</th>
            <th class="px-5 py-3 font-medium">Kota / Kabupaten</th>
            <th class="px-5 py-3 font-medium">Status</th>
            <th class="px-5 py-3 font-medium text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">

          @forelse ($this->fasilitas as $item)
            <tr class="hover:bg-gray-50 transition-colors duration-150">

              <td class="px-5 py-3 font-medium text-gray-800 whitespace-nowrap">
                {{ $item->nama }}
              </td>

              <td class="px-5 py-3 whitespace-nowrap">
                {{ $item->jenis_fasilitas }}
              </td>

              <td class="px-5 py-3 whitespace-nowrap">
                {{ $item->kota_kabupaten }}
              </td>

              <td class="px-5 py-3 whitespace-nowrap">
                @php
                  $badge = match ($item->status) {
                      'active' => 'bg-green-100 text-green-700',
                      'prospect' => 'bg-yellow-100 text-yellow-700',
                      'inactive' => 'bg-gray-100 text-gray-500',
                      default => 'bg-gray-100 text-gray-500',
                  };
                  $label = match ($item->status) {
                      'active' => 'Aktif',
                      'prospect' => 'Prospek',
                      'inactive' => 'Tidak Aktif',
                      default => $item->status,
                  };
                @endphp
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                             text-xs font-medium {{ $badge }}">
                  {{ $label }}
                </span>
              </td>

              <td class="px-5 py-3 text-right whitespace-nowrap">
                <a href="{{ route('fasilitas-kesehatan.show', $item) }}"
                  class="text-xs font-medium text-blue-600
          hover:text-blue-800 transition-colors duration-150">
                  Detail
                </a>
              </td>

            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-5 py-12 text-center">
                <p class="text-sm text-gray-400">
                  Tidak ada fasilitas yang cocok dengan pencarian.
                </p>
              </td>
            </tr>
          @endforelse

        </tbody>
      </table>
    </div>

    {{-- Footer tabel --}}
    <div class="px-5 py-3 border-t border-gray-100">
      <p class="text-xs text-gray-400">
        Menampilkan {{ count($this->fasilitas) }} fasilitas
      </p>
    </div>

  </div>

</div>
