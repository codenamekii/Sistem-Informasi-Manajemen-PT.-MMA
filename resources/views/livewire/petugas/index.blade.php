<div>

    {{-- Flash Message --}}
    <x-alert type="success" :message="session('success')" />

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <x-page-header title="Petugas"
            description="Daftar petugas lapangan pengangkutan limbah infeksius PT. Mitra Mecca Abadi." class="mb-0" />
        <a href="{{ route('petugas.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium
                  text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4
                  focus:ring-blue-300 transition-colors duration-200 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Petugas
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">

        <x-stat-card title="Total Petugas" :value="$this->total" description="Semua status" color="blue">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283
                             -.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283
                             .356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Aktif" :value="$this->active" description="Siap bertugas" color="green">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Cuti" :value="$this->onLeave" description="Sedang cuti" color="yellow">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0
                             00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Tidak Aktif" :value="$this->inactive" description="Tidak bertugas" color="red">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728
                             A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">

        {{-- Toolbar --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3
                    px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700">Daftar Petugas</h3>
            <div class="w-full sm:w-64">
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama, jabatan, atau wilayah..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm
                           rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 font-medium">Nama Petugas</th>
                        <th class="px-5 py-3 font-medium">Jabatan</th>
                        <th class="px-5 py-3 font-medium">Nomor Telepon</th>
                        <th class="px-5 py-3 font-medium">Wilayah Tugas</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @forelse ($this->petugas as $item)
                    @php
                    $badge = match($item->status) {
                    'active' => 'bg-green-100 text-green-700',
                    'on_leave' => 'bg-yellow-100 text-yellow-700',
                    'inactive' => 'bg-gray-100 text-gray-500',
                    default => 'bg-gray-100 text-gray-500',
                    };
                    $label = match($item->status) {
                    'active' => 'Aktif',
                    'on_leave' => 'Cuti',
                    'inactive' => 'Tidak Aktif',
                    default => $item->status,
                    };
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors duration-150">

                        <td class="px-5 py-3 font-medium text-gray-800 whitespace-nowrap">
                            {{ $item->nama_petugas }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            {{ $item->jabatan }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap font-mono text-xs text-gray-600">
                            {{ $item->nomor_telepon }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            {{ $item->wilayah_tugas }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                             text-xs font-medium {{ $badge }}">
                                {{ $label }}
                            </span>
                        </td>

                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('petugas.show', $item) }}" class="text-xs font-medium text-blue-600
                                      hover:text-blue-800 transition-colors duration-150">
                                Detail
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center">
                            <p class="text-sm text-gray-400">
                                Tidak ada petugas yang cocok dengan pencarian.
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
                Menampilkan {{ $this->petugas->count() }} petugas
            </p>
        </div>

    </div>

</div>