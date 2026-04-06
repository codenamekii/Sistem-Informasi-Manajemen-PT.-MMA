<div>
    {{-- Flash Message --}}
    <x-alert type="success" :message="session('success')" />

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <x-page-header title="Fasilitas Kesehatan"
            description="Daftar fasilitas kesehatan yang tercatat dalam sistem PT. Mitra Mecca Abadi." class="mb-0" />

        <a href="{{ route('fasilitas-kesehatan.create') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 transition-colors duration-200 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Fasilitas
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4 mb-6">
        <x-stat-card title="Total Fasilitas" :value="$this->total" description="Hasil sesuai filter aktif" color="blue">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2m-16 0H3m2-8h14M9 9h.01M9 13h.01M9 17h.01M15 9h.01M15 13h.01M15 17h.01" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Aktif" :value="$this->aktif" description="Status prospek aktif" color="green">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Prospek" :value="$this->prospect" description="Masih tahap prospek" color="yellow">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Masuk Penawaran" :value="$this->masukPenawaran" description="Siap ditindaklanjuti"
            color="purple">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 11V6a1 1 0 112 0v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H6a1 1 0 110-2h5z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Dengan Kendala" :value="$this->denganKendala" description="Perlu perhatian admin"
            color="red">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
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
                        placeholder="Cari nama, jenis, wilayah, PIC, atau kendala..."
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                </div>

                <div class="w-full sm:w-52">
                    <select wire:model.live="status"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                        <option value="">Semua Status Prospek</option>
                        <option value="prospect">Prospek</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Non-aktif</option>
                    </select>
                </div>

                <div class="w-full sm:w-56">
                    <select wire:model.live="statusPenawaran"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                        <option value="">Semua Status Penawaran</option>
                        <option value="masuk_penawaran">Masuk Penawaran</option>
                        <option value="belum_masuk_penawaran">Belum Masuk Penawaran</option>
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
                        <th class="px-5 py-3 font-medium">Fasilitas</th>
                        <th class="px-5 py-3 font-medium">Wilayah</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">PIC</th>
                        <th class="px-5 py-3 font-medium">Catatan</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($this->fasilitas as $item)
                    @php
                    $status = data_get($item, 'status');
                    $statusPenawaran = data_get($item, 'status_penawaran') ?? 'belum_masuk_penawaran';

                    $statusBadge = match($status) {
                    'prospect' => 'bg-yellow-100 text-yellow-700',
                    'active' => 'bg-green-100 text-green-700',
                    'inactive' => 'bg-gray-100 text-gray-600',
                    default => 'bg-gray-100 text-gray-500',
                    };

                    $statusLabel = match($status) {
                    'prospect' => 'Prospek',
                    'active' => 'Aktif',
                    'inactive' => 'Non-aktif',
                    default => $status,
                    };

                    $statusPenawaranBadge = match($statusPenawaran) {
                    'masuk_penawaran' => 'bg-blue-100 text-blue-700',
                    'belum_masuk_penawaran' => 'bg-gray-100 text-gray-600',
                    default => 'bg-gray-100 text-gray-500',
                    };

                    $statusPenawaranLabel = match($statusPenawaran) {
                    'masuk_penawaran' => 'Masuk Penawaran',
                    'belum_masuk_penawaran' => 'Belum Masuk Penawaran',
                    default => $statusPenawaran,
                    };

                    $hasPic = filled(data_get($item, 'pic_nama')) || filled(data_get($item, 'pic_nomor_telepon'));
                    $hasKendala = filled(data_get($item, 'kendala'));
                    @endphp

                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-5 py-3">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate"
                                    title="{{ data_get($item, 'nama') }}">
                                    {{ data_get($item, 'nama') }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ data_get($item, 'jenis_fasilitas') }}
                                </p>
                            </div>
                        </td>

                        <td class="px-5 py-3">
                            <div class="min-w-0">
                                <p class="text-sm text-gray-900">
                                    {{ data_get($item, 'kota_kabupaten') }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ data_get($item, 'provinsi') ?: 'Provinsi belum diisi' }}
                                </p>
                            </div>
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            <div class="flex flex-col items-start gap-2">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusBadge }}">
                                    {{ $statusLabel }}
                                </span>

                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusPenawaranBadge }}">
                                    {{ $statusPenawaranLabel }}
                                </span>
                            </div>
                        </td>

                        <td class="px-5 py-3">
                            @if ($hasPic)
                            <div class="min-w-0">
                                <p class="text-sm text-gray-900 truncate">
                                    {{ data_get($item, 'pic_nama') ?: 'PIC tanpa nama' }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ data_get($item, 'pic_nomor_telepon') ?: 'Nomor belum diisi' }}
                                </p>
                            </div>
                            @else
                            <div class="flex flex-col items-start gap-2">
                                <span class="text-sm text-gray-400">—</span>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    PIC belum diisi
                                </span>
                            </div>
                            @endif
                        </td>

                        <td class="px-5 py-3">
                            @if ($hasKendala)
                            <div class="flex flex-col items-start gap-2 max-w-[220px]">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                    Ada Kendala
                                </span>
                                <p class="text-xs text-gray-500 line-clamp-2">
                                    {{ data_get($item, 'kendala') }}
                                </p>
                            </div>
                            @else
                            <span class="text-sm text-gray-400">Tidak ada</span>
                            @endif
                        </td>

                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('fasilitas-kesehatan.show', data_get($item, 'id')) }}"
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
                                    Tidak ada fasilitas kesehatan yang cocok dengan pencarian atau filter.
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
                Menampilkan {{ $this->fasilitas->count() }} fasilitas kesehatan
            </p>
        </div>
    </div>
</div>