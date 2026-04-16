<div>

  {{-- Flash Message --}}
  <x-alert type="success" :message="session('success')" />

  {{-- Page Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <x-page-header title="Realisasi Pengangkutan"
      description="Rekap realisasi pengangkutan limbah infeksius per fasilitas kesehatan." class="mb-0" />
  </div>

  {{-- Stat Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

    <x-stat-card title="Total Realisasi" :value="$this->totalRealisasi" description="Semua jadwal selesai"
      color="green">
      <x-slot:icon>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </x-slot:icon>
    </x-stat-card>

    <x-stat-card title="Bukti Lengkap" :value="$this->buktiLengkap" description="Manifest + foto tersedia" color="blue">
      <x-slot:icon>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
      </x-slot:icon>
    </x-stat-card>

    <x-stat-card title="Bukti Belum Lengkap" :value="$this->buktiBelumLengkap" description="Perlu dilengkapi"
      color="yellow">
      <x-slot:icon>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </x-slot:icon>
    </x-stat-card>

  </div>

  {{-- Tabel --}}
  <div class="bg-white rounded-lg border border-gray-200 shadow-sm">

    {{-- Toolbar --}}
    <div class="flex flex-col gap-3 px-5 py-4 border-b border-gray-100">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <h3 class="text-sm font-semibold text-gray-700">Rekap per Fasilitas</h3>
        <div class="w-full sm:w-72">
          <input type="text" wire:model.live.debounce.300ms="search"
            placeholder="Cari fasilitas atau nomor perjanjian..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm
                               rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
        </div>
      </div>

      <div class="flex flex-wrap items-center gap-2">
        <select wire:model.live="filterBukti" class="bg-gray-50 border border-gray-300 text-gray-700 text-xs rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
          <option value="">Semua Bukti</option>
          <option value="lengkap">Bukti Lengkap</option>
          <option value="belum">Bukti Belum Lengkap</option>
        </select>

        @if ($search !== '' || $filterBukti !== '')
          <button wire:click="resetFilters"
            class="text-xs text-gray-500 hover:text-red-600 underline underline-offset-2 transition-colors duration-150">
            Reset filter
          </button>
        @endif
      </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-600">
        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
          <tr>
            <th class="px-5 py-3 font-medium">Fasilitas</th>
            <th class="px-5 py-3 font-medium">No. Perjanjian</th>
            <th class="px-5 py-3 font-medium">Jumlah Realisasi</th>
            <th class="px-5 py-3 font-medium">Akumulasi Limbah</th>
            <th class="px-5 py-3 font-medium">Akumulasi Nilai</th>
            <th class="px-5 py-3 font-medium">Status Bukti</th>
            <th class="px-5 py-3 font-medium text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">

          @forelse ($this->realisasi as $item)
            <tr class="hover:bg-gray-50 transition-colors duration-150">

              <td class="px-5 py-3 max-w-[220px]">
                <span class="block truncate text-sm text-gray-800" title="{{ $item['nama_fasilitas_display'] }}">
                  {{ $item['nama_fasilitas_display'] }}
                </span>
              </td>

              <td class="px-5 py-3 whitespace-nowrap">
                <span class="font-mono text-xs text-gray-600">
                  {{ $item['nomor_perjanjian'] }}
                </span>
              </td>

              <td class="px-5 py-3 whitespace-nowrap">
                {{ $item['jumlah_realisasi'] }} kali
              </td>

              <td class="px-5 py-3 whitespace-nowrap">
                {{ $item['total_limbah_kg_display'] }}
              </td>

              <td class="px-5 py-3 whitespace-nowrap font-medium text-gray-800">
                {{ $item['total_biaya_realisasi_rupiah'] }}
              </td>

              <td class="px-5 py-3 whitespace-nowrap">
                @if (!$item['has_any_bukti_belum_lengkap'])
                  <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full
                                                     text-xs font-medium bg-green-100 text-green-700">
                    Lengkap
                  </span>
                  <div class="mt-1 text-[10px] text-gray-500">
                    {{ $item['jumlah_bukti_lengkap'] }}/{{ $item['jumlah_realisasi'] }} realisasi
                  </div>
                @else
                  <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full
                                                     text-xs font-medium bg-orange-100 text-orange-600">
                    Belum Lengkap
                  </span>
                  <div class="mt-1 text-[10px] text-gray-500">
                    {{ $item['jumlah_bukti_lengkap'] }}/{{ $item['jumlah_realisasi'] }} lengkap
                  </div>
                @endif
              </td>

              <td class="px-5 py-3 text-right whitespace-nowrap">
                <a href="{{ route('realisasi.fasilitas.show', $item['kerja_sama_id']) }}"
                  class="text-xs font-medium text-blue-600 hover:text-blue-800 transition-colors duration-150">
                  Detail
                </a>
              </td>

            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-5 py-12 text-center">
                @if ($search !== '' || $filterBukti !== '')
                  <p class="text-sm text-gray-500 mb-2">
                    Tidak ada rekap realisasi yang cocok dengan filter aktif.
                  </p>
                  <button wire:click="resetFilters" class="text-sm text-blue-600 hover:underline">
                    Reset filter
                  </button>
                @else
                  <p class="text-sm text-gray-400">
                    Belum ada data realisasi pengangkutan.
                  </p>
                @endif
              </td>
            </tr>
          @endforelse

        </tbody>
      </table>
    </div>

    {{-- Footer --}}
    <div class="px-5 py-3 border-t border-gray-100">
      <p class="text-xs text-gray-400">
        Menampilkan {{ count($this->realisasi) }} fasilitas
      </p>
    </div>

  </div>

</div>