<div>

    {{-- Flash Message --}}
    <x-alert type="success" :message="session('success')" />

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <x-page-header title="Kerja Sama"
            description="Daftar perjanjian kerja sama PT. Mitra Mecca Abadi dengan fasilitas kesehatan." class="mb-0" />
        <a href="{{ route('kerja-sama.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium
                  text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4
                  focus:ring-blue-300 transition-colors duration-200 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kerja Sama
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

        <x-stat-card title="Total Kerja Sama" :value="$this->total" description="Semua status" color="blue">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586
                             a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Aktif" :value="$this->aktif" description="Perjanjian berjalan" color="green">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Kadaluarsa" :value="$this->expired" description="Perlu diperpanjang" color="red">
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
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3
                    px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700">Daftar Perjanjian</h3>
            <div class="w-full sm:w-72">
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari nomor atau nama fasilitas..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm
                           rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 font-medium">Nomor Perjanjian</th>
                        <th class="px-5 py-3 font-medium">Fasilitas Kesehatan</th>
                        <th class="px-5 py-3 font-medium">Tgl. Mulai</th>
                        <th class="px-5 py-3 font-medium">Tgl. Berakhir</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @forelse ($this->kerjaSama as $item)
                    @php
                    $badge = match($item->status) {
                    'active' => 'bg-green-100 text-green-700',
                    'draft' => 'bg-blue-100 text-blue-700',
                    'expired' => 'bg-red-100 text-red-700',
                    'terminated' => 'bg-gray-100 text-gray-500',
                    default => 'bg-gray-100 text-gray-500',
                    };
                    $label = match($item->status) {
                    'active' => 'Aktif',
                    'draft' => 'Draft',
                    'expired' => 'Kadaluarsa',
                    'terminated' => 'Dihentikan',
                    default => $item->status,
                    };
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors duration-150">

                        <td class="px-5 py-3 font-mono text-xs text-gray-700 whitespace-nowrap">
                            {{ $item->nomor_perjanjian }}
                        </td>

                        <td class="px-5 py-3 font-medium text-gray-800 whitespace-nowrap">
                            {{ $item->nama_fasilitas_kesehatan }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            {{ $item->tanggal_mulai->format('d/m/Y') }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            {{ $item->tanggal_berakhir->format('d/m/Y') }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                             text-xs font-medium {{ $badge }}">
                                {{ $label }}
                            </span>
                        </td>

                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('kerja-sama.show', $item) }}" class="text-xs font-medium text-blue-600
                                      hover:text-blue-800 transition-colors duration-150">
                                Detail
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center">
                            <p class="text-sm text-gray-400">
                                Tidak ada data kerja sama yang cocok dengan pencarian.
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
                Menampilkan {{ $this->kerjaSama->count() }} perjanjian
            </p>
        </div>

    </div>

</div>
