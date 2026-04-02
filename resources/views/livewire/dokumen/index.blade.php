<div>

    {{-- Flash Message --}}
    <x-alert type="success" :message="session('success')" />

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <x-page-header title="Dokumen"
            description="Daftar dokumen perjanjian, izin, dan sertifikat PT. Mitra Mecca Abadi." class="mb-0" />
        <a href="{{ route('dokumen.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium
                  text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4
                  focus:ring-blue-300 transition-colors duration-200 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Dokumen
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">

        <x-stat-card title="Total Dokumen" :value="$this->total" description="Semua status" color="blue">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414
                             A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Valid" :value="$this->valid" description="Masih berlaku" color="green">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Segera Berakhir" :value="$this->expiringSoon" description="Perlu diperpanjang"
            color="yellow">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94
                             a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Kadaluarsa" :value="$this->expired" description="Tidak berlaku" color="red">
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
            <h3 class="text-sm font-semibold text-gray-700">Daftar Dokumen</h3>
            <div class="w-full sm:w-72">
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama, kategori, atau terkait..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm
                           rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 font-medium">Nama Dokumen</th>
                        <th class="px-5 py-3 font-medium">Kategori</th>
                        <th class="px-5 py-3 font-medium">No. Referensi</th>
                        <th class="px-5 py-3 font-medium">Terkait Dengan</th>
                        <th class="px-5 py-3 font-medium">Berlaku Sampai</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @forelse ($this->dokumen as $item)
                    @php
                    $badge = match($item->status) {
                    'valid' => 'bg-green-100 text-green-700',
                    'expiring_soon' => 'bg-yellow-100 text-yellow-700',
                    'expired' => 'bg-red-100 text-red-700',
                    'missing' => 'bg-gray-100 text-gray-500',
                    default => 'bg-gray-100 text-gray-500',
                    };
                    $label = match($item->status) {
                    'valid' => 'Valid',
                    'expiring_soon' => 'Segera Berakhir',
                    'expired' => 'Kadaluarsa',
                    'missing' => 'Tidak Ada',
                    default => $item->status,
                    };
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors duration-150">

                        <td class="px-5 py-3 font-medium text-gray-800 max-w-xs">
                            <span class="line-clamp-2">{{ $item->nama_dokumen }}</span>
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            {{ $item->kategori_dokumen }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap font-mono text-xs text-gray-600">
                            {{ $item->nomor_referensi ?? '—' }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            {{ $item->terkait_dengan }}
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            @if ($item->tanggal_berlaku_sampai)
                            {{ $item->tanggal_berlaku_sampai->format('d/m/Y') }}
                            @else
                            <span class="text-gray-400">—</span>
                            @endif
                        </td>

                        <td class="px-5 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                             text-xs font-medium {{ $badge }}">
                                {{ $label }}
                            </span>
                        </td>

                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('dokumen.show', $item) }}" class="text-xs font-medium text-blue-600
                                      hover:text-blue-800 transition-colors duration-150">
                                Detail
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center">
                            <p class="text-sm text-gray-400">
                                Tidak ada dokumen yang cocok dengan pencarian.
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
                Menampilkan {{ $this->dokumen->count() }} dokumen
            </p>
        </div>

    </div>

</div>
