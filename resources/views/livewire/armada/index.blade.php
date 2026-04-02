<div>

    {{-- Flash Message --}}
    <x-alert type="success" :message="session('success')" />

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <x-page-header title="Armada" description="Daftar kendaraan pengangkut limbah infeksius PT. Mitra Mecca Abadi."
            class="mb-0" />
        <a href="{{ route('armada.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium
                  text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4
                  focus:ring-blue-300 transition-colors duration-200 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Armada
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">

        <x-stat-card title="Total Armada" :value="$this->total" description="Semua status" color="blue">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Tersedia" :value="$this->available" description="Siap digunakan" color="green">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Digunakan" :value="$this->inUse" description="Sedang beroperasi" color="yellow">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Perawatan" :value="$this->maintenance" description="Sedang servis" color="red">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0
                             002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0
                             001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0
                             00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0
                             00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0
                             00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0
                             00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0
                             001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07
                             2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">

        {{-- Toolbar --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3
                    px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700">Daftar Kendaraan</h3>
            <div class="w-full sm:w-64">
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari kode, polisi, atau jenis..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm
                           rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 font-medium">Kode Armada</th>
                        <th class="px-5 py-3 font-medium">Nomor Polisi</th>
                        <th class="px-5 py-3 font-medium">Jenis Kendaraan</th>
                        <th class="px-5 py-3 font-medium">Kapasitas</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @forelse ($this->armada as $item)
                    @php
                    $badge = match($item['status']) {
                    'available' => 'bg-green-100 text-green-700',
                    'in_use' => 'bg-yellow-100 text-yellow-700',
                    'maintenance' => 'bg-red-100 text-red-700',
                    'inactive' => 'bg-gray-100 text-gray-500',
                    default => 'bg-gray-100 text-gray-500',
                    };
                    $label = match($item['status']) {
                    'available' => 'Tersedia',
                    'in_use' => 'Digunakan',
                    'maintenance' => 'Perawatan',
                    'inactive' => 'Tidak Aktif',
                    default => $item['status'],
                    };
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors duration-150">

                        <td class="px-5 py-3 font-mono text-xs font-medium text-gray-700 whitespace-nowrap">
                            {{ $item['kode_armada'] }}
                        </td>

                        <td class="px-5 py-3 font-medium text-gray-800 whitespace-nowrap">
                            {{ $item['nomor_polisi'] }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            {{ $item['jenis_kendaraan'] }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            {{ $item['kapasitas'] }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                             text-xs font-medium {{ $badge }}">
                                {{ $label }}
                            </span>
                        </td>

                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('armada.show', $item) }}" class="text-xs font-medium text-blue-600
                                      hover:text-blue-800 transition-colors duration-150">
                                Detail
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center">
                            <p class="text-sm text-gray-400">
                                Tidak ada armada yang cocok dengan pencarian.
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
                Menampilkan {{ count($this->armada) }} kendaraan
            </p>
        </div>

    </div>

</div>
