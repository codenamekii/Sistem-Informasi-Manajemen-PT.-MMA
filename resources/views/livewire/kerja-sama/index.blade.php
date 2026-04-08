<div>
    {{-- Flash Message --}}
    <x-alert type="success" :message="session('success')" />

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <x-page-header title="Kerja Sama" description="Daftar kerja sama fasilitas kesehatan PT. Mitra Mecca Abadi."
            class="mb-0" />

        <a href="{{ route('kerja-sama.create') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 transition-colors duration-200 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kerja Sama
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <x-stat-card title="Total Kerja Sama" :value="$this->total" description="Hasil sesuai filter aktif"
            color="blue">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Aktif" :value="$this->aktif" description="Status aktif" color="green">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Draft" :value="$this->draft" description="Belum final" color="yellow">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Tersambung" :value="$this->tersambung" description="Sudah pakai relasi fasilitas"
            color="purple">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 010 5.656l-1.414 1.414a4 4 0 01-5.657-5.657l1.414-1.414m3.536-3.536a4 4 0 015.657 5.657l-1.414 1.414a4 4 0 01-5.657-5.657l1.414-1.414" />
                </svg>
            </x-slot:icon>
        </x-stat-card>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        {{-- Toolbar --}}
        <div
            class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3 px-5 py-4 border-b border-gray-100">
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Cari</h3>
            </div>

            <div class="flex flex-col sm:flex-row lg:flex-row gap-3 w-full xl:w-auto">
                <div class="w-full sm:w-80">
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Cari nomor, fasilitas, atau status..."
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                </div>

                <div class="w-full sm:w-52">
                    <select wire:model.live="status"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                        <option value="">Semua Status</option>
                        <option value="draft">Draft</option>
                        <option value="active">Aktif</option>
                        <option value="expired">Expired</option>
                        <option value="terminated">Terminated</option>
                    </select>
                </div>

                <div class="w-full sm:w-56">
                    <select wire:model.live="koneksiFasilitas"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                        <option value="">Semua Koneksi</option>
                        <option value="connected">Sudah Tersambung</option>
                        <option value="legacy">Masih Nama Lama</option>
                    </select>
                </div>

                <button type="button" wire:click="resetFilters"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 transition-colors duration-200">
                    Reset
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 font-medium">Nomor Perjanjian</th>
                        <th class="px-5 py-3 font-medium">Fasilitas</th>
                        <th class="px-5 py-3 font-medium">Periode</th>
                        <th class="px-5 py-3 font-medium">Harga</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($this->kerjaSamas as $item)
                    @php
                    $badge = match($item['status']) {
                    'draft' => 'bg-gray-100 text-gray-600',
                    'active' => 'bg-green-100 text-green-700',
                    'expired' => 'bg-yellow-100 text-yellow-700',
                    'terminated' => 'bg-red-100 text-red-700',
                    default => 'bg-gray-100 text-gray-500',
                    };

                    $label = match($item['status']) {
                    'draft' => 'Draft',
                    'active' => 'Aktif',
                    'expired' => 'Expired',
                    'terminated' => 'Terminated',
                    default => $item['status'],
                    };
                    @endphp

                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-5 py-3 whitespace-nowrap">
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $item['nomor_perjanjian'] }}
                            </p>
                        </td>

                        <td class="px-5 py-3">
                            <div class="min-w-0">
                                <p class="text-sm text-gray-900 truncate" title="{{ $item['nama_fasilitas_display'] }}">
                                    {{ $item['nama_fasilitas_display'] }}
                                </p>

                                @if ($item['is_connected'])
                                <p class="mt-1 text-xs text-gray-500">
                                    Tersambung ke data fasilitas
                                </p>
                                @else
                                <p class="mt-1 text-xs text-amber-600">
                                    Masih memakai nama fasilitas lama
                                </p>
                                @endif
                            </div>
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            <div class="min-w-0">
                                <p class="text-sm text-gray-900">
                                    {{ $item['tanggal_mulai'] ?
                                    \Carbon\Carbon::parse($item['tanggal_mulai'])->format('d/m/Y') : '—' }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    s/d {{ $item['tanggal_berakhir'] ?
                                    \Carbon\Carbon::parse($item['tanggal_berakhir'])->format('d/m/Y') : '—' }}
                                </p>
                            </div>
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">
                                {{ $item['harga_per_kilogram_rupiah'] }}
                            </span>
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }}">
                                {{ $label }}
                            </span>
                        </td>

                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('kerja-sama.show', $item['id']) }}"
                                class="text-xs font-medium text-blue-600 hover:text-blue-800 transition-colors duration-150">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center">
                            <div class="max-w-md mx-auto">
                                <p class="text-sm font-medium text-gray-500">
                                    Tidak ada data kerja sama yang cocok dengan pencarian atau filter.
                                </p>
                                <p class="mt-1 text-xs text-gray-400">
                                    Coba ubah kata kunci pencarian atau tekan tombol reset untuk menampilkan semua data
                                    kembali.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="px-5 py-3 border-t border-gray-100">
            <p class="text-xs text-gray-400">
                Menampilkan {{ count($this->kerjaSamas) }} kerja sama
            </p>
        </div>
    </div>
</div>