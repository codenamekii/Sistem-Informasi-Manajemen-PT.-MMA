<div>

    {{-- Flash Message --}}
    <x-alert type="success" :message="session('success')" />

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <x-page-header title="Jadwal Pengangkutan"
            description="Daftar jadwal pengangkutan limbah infeksius PT. Mitra Mecca Abadi." class="mb-0" />
        <a href="#" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium
                  text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4
                  focus:ring-blue-300 transition-colors duration-200 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Buat Jadwal
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">

        <x-stat-card title="Total Jadwal" :value="$this->total" description="Semua status" color="blue">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0
                             00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
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

    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">

        {{-- Toolbar --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3
                    px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700">Daftar Jadwal</h3>
            <div class="w-full sm:w-72">
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari kode, fasilitas, atau petugas..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm
                           rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
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
                        <th class="px-5 py-3 font-medium">PIC</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @forelse ($this->jadwal as $item)
                    @php
                    $badge = match($item['status']) {
                    'draft' => 'bg-gray-100 text-gray-600',
                    'scheduled' => 'bg-yellow-100 text-yellow-700',
                    'in_progress' => 'bg-purple-100 text-purple-700',
                    'completed' => 'bg-green-100 text-green-700',
                    'cancelled' => 'bg-red-100 text-red-700',
                    default => 'bg-gray-100 text-gray-500',
                    };
                    $label = match($item['status']) {
                    'draft' => 'Draft',
                    'scheduled' => 'Terjadwal',
                    'in_progress' => 'Berlangsung',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                    default => $item['status'],
                    };
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors duration-150">

                        <td class="px-5 py-3 font-mono text-xs font-medium text-gray-700 whitespace-nowrap">
                            {{ $item['kode_jadwal'] }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($item['tanggal_pengangkutan'])->format('d/m/Y') }}
                        </td>

                        <td class="px-5 py-3 max-w-[180px]">
                            <span class="block truncate" title="{{ $item['nama_fasilitas'] }}">
                                {{ $item['nama_fasilitas'] }}
                            </span>
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap font-mono text-xs text-gray-600">
                            {{ $item['armada'] }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            {{ $item['petugas_pic'] }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                             text-xs font-medium {{ $badge }}">
                                {{ $label }}
                            </span>
                        </td>

                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="#" class="text-xs font-medium text-blue-600
                                          hover:text-blue-800 transition-colors duration-150">
                                Detail
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center">
                            <p class="text-sm text-gray-400">
                                Tidak ada jadwal yang cocok dengan pencarian.
                            </p>
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