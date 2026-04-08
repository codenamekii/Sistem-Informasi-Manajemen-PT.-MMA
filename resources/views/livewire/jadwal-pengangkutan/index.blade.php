<div>

  {{-- Flash Message --}}
  <x-alert type="success" :message="session('success')" />

  {{-- Page Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <x-page-header title="Jadwal Pengangkutan"
      description="Daftar jadwal pengangkutan limbah infeksius PT. Mitra Mecca Abadi." class="mb-0" />
    <a href="{{ route('jadwal-pengangkutan.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium
                   text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4
                   focus:ring-blue-300 transition-colors duration-200 shrink-0">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Buat Jadwal
    </a>
  </div>

  {{-- Summary Cards --}}
  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">

    <x-stat-card title="Total Jadwal" :value="$this->total" description="Semua status" color="blue">
      <x-slot:icon>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
      </x-slot:icon>
    </x-stat-card>

    <x-stat-card title="Terjadwal" :value="$this->scheduled" description="Menunggu pelaksanaan" color="yellow">
      <x-slot:icon>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </x-slot:icon>
    </x-stat-card>

    <x-stat-card title="Berlangsung" :value="$this->inProgress" description="Sedang dijalankan" color="purple">
      <x-slot:icon>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
      </x-slot:icon>
    </x-stat-card>

    <x-stat-card title="Selesai" :value="$this->completed" description="Berhasil diselesaikan" color="green">
      <x-slot:icon>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </x-slot:icon>
    </x-stat-card>

    <x-stat-card title="Bukti Lengkap" :value="$this->completedWithBukti" description="Selesai + bukti tersedia"
      color="green">
      <x-slot:icon>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
      </x-slot:icon>
    </x-stat-card>

  </div>

  {{-- Tabel --}}
  <div class="bg-white rounded-lg border border-gray-200 shadow-sm">

    {{-- Toolbar --}}
    <div class="flex flex-col gap-3 px-5 py-4 border-b border-gray-100">

      {{-- Baris 1: judul + search --}}
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <h3 class="text-sm font-semibold text-gray-700">Daftar Jadwal</h3>
        <div class="w-full sm:w-72">
          <input type="text" wire:model.live.debounce.300ms="search"
            placeholder="Cari kode, fasilitas, armada, atau petugas..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm
                               rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
        </div>
      </div>

      {{-- Baris 2: filter --}}
      <div class="flex flex-wrap items-center gap-2">

        {{-- Filter Status --}}
        <select wire:model.live="filterStatus" class="bg-gray-50 border border-gray-300 text-gray-700 text-xs rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
          <option value="">Semua Status</option>
          <option value="draft">Draft</option>
          <option value="scheduled">Terjadwal</option>
          <option value="in_progress">Berlangsung</option>
          <option value="completed">Selesai</option>
          <option value="cancelled">Dibatalkan</option>
        </select>

        {{-- Filter Koneksi --}}
        <select wire:model.live="filterKoneksi" class="bg-gray-50 border border-gray-300 text-gray-700 text-xs rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
          <option value="">Semua Koneksi</option>
          <option value="connected">Tersambung ke relasi</option>
          <option value="legacy">Masih data lama</option>
        </select>

        {{-- Filter Bukti --}}
        <select wire:model.live="filterBukti" class="bg-gray-50 border border-gray-300 text-gray-700 text-xs rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
          <option value="">Semua Bukti</option>
          <option value="lengkap">Selesai + Bukti Lengkap</option>
          <option value="belum">Selesai + Bukti Belum Lengkap</option>
          <option value="bukan_completed">Belum Selesai</option>
        </select>

        {{-- Reset --}}
        @if ($search !== '' || $filterStatus !== '' || $filterKoneksi !== '' || $filterBukti !== '')
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
            <th class="px-5 py-3 font-medium">Kode Jadwal</th>
            <th class="px-5 py-3 font-medium">Tgl. Pengangkutan</th>
            <th class="px-5 py-3 font-medium">Fasilitas</th>
            <th class="px-5 py-3 font-medium">Armada</th>
            <th class="px-5 py-3 font-medium">Petugas</th>
            <th class="px-5 py-3 font-medium">Status</th>
            <th class="px-5 py-3 font-medium text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">

          @forelse ($this->jadwal as $item)
            @php
              $badge = match ($item['status']) {
                'draft' => 'bg-gray-100 text-gray-600',
                'scheduled' => 'bg-yellow-100 text-yellow-700',
                'in_progress' => 'bg-purple-100 text-purple-700',
                'completed' => 'bg-green-100 text-green-700',
                'cancelled' => 'bg-red-100 text-red-700',
                default => 'bg-gray-100 text-gray-500',
              };
              $label = match ($item['status']) {
                'draft' => 'Draft',
                'scheduled' => 'Terjadwal',
                'in_progress' => 'Berlangsung',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
                default => $item['status'],
              };
            @endphp
            <tr class="hover:bg-gray-50 transition-colors duration-150">

              {{-- Kode + indikator koneksi --}}
              <td class="px-5 py-3 whitespace-nowrap">
                <div class="font-mono text-xs font-medium text-gray-700">
                  {{ $item['kode_jadwal'] }}
                </div>
                @if ($item['is_connected'])
                  <span class="text-[10px] text-blue-500">● Tersambung</span>
                @else
                  <span class="text-[10px] text-gray-400">○ Data lama</span>
                @endif
              </td>

              <td class="px-5 py-3 whitespace-nowrap text-sm">
                {{ $item['tanggal_pengangkutan'] }}
              </td>

              <td class="px-5 py-3 max-w-[160px]">
                <span class="block truncate text-sm text-gray-800" title="{{ $item['nama_fasilitas_display'] }}">
                  {{ $item['nama_fasilitas_display'] }}
                </span>
              </td>

              <td class="px-5 py-3 whitespace-nowrap">
                <span class="font-mono text-xs text-gray-600">
                  {{ $item['armada_display'] }}
                </span>
              </td>

              <td class="px-5 py-3 max-w-[160px]">
                <span class="block truncate text-sm text-gray-700" title="{{ $item['petugas_display'] }}">
                  {{ $item['petugas_display'] }}
                </span>
              </td>

              {{-- Status + indikator bukti --}}
              <td class="px-5 py-3 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                           text-xs font-medium {{ $badge }}">
                  {{ $label }}
                </span>
                @if ($item['status'] === 'completed')
                  @if ($item['has_bukti_lengkap'])
                    <div class="mt-1">
                      <span class="inline-flex items-center gap-1 text-[10px] text-green-600 font-medium">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        </svg>
                        Bukti Lengkap
                      </span>
                    </div>
                  @else
                    <div class="mt-1">
                      <span class="inline-flex items-center gap-1 text-[10px] text-orange-500 font-medium">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01" />
                        </svg>
                        Bukti Belum Lengkap
                      </span>
                    </div>
                  @endif
                @endif
              </td>

              <td class="px-5 py-3 text-right whitespace-nowrap">
                <div class="flex items-center justify-end gap-3">
                  <a href="{{ route('jadwal-pengangkutan.show', $item['id']) }}"
                    class="text-xs font-medium text-blue-600 hover:text-blue-800 transition-colors duration-150">
                    Detail
                  </a>
                  <a href="{{ route('jadwal-pengangkutan.edit', $item['id']) }}"
                    class="text-xs font-medium text-gray-500 hover:text-gray-700 transition-colors duration-150">
                    Edit
                  </a>
                </div>
              </td>

            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-5 py-12 text-center">
                @if ($search !== '' || $filterStatus !== '' || $filterKoneksi !== '' || $filterBukti !== '')
                  <p class="text-sm text-gray-500 mb-2">
                    Tidak ada jadwal yang cocok dengan filter aktif.
                  </p>
                  <button wire:click="resetFilters" class="text-sm text-blue-600 hover:underline">
                    Reset filter
                  </button>
                @else
                  <p class="text-sm text-gray-400">
                    Belum ada jadwal pengangkutan. Mulai dengan membuat jadwal baru.
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
        Menampilkan {{ count($this->jadwal) }} jadwal
      </p>
    </div>

  </div>

</div>