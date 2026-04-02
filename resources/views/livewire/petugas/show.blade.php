<div>

    {{-- Flash Message --}}
    <x-alert type="success" :message="session('success')" />

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <x-page-header title="Detail Petugas" description="Informasi lengkap petugas yang dipilih." class="mb-0" />
        <a href="{{ route('petugas.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600
                  bg-white border border-gray-300 rounded-lg hover:bg-gray-50
                  focus:ring-4 focus:ring-gray-200 transition-colors duration-200 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    {{-- Detail Card --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">

        {{-- Card Header --}}
        @php
        $badge = match($petugas->status) {
        'active' => 'bg-green-100 text-green-700',
        'on_leave' => 'bg-yellow-100 text-yellow-700',
        'inactive' => 'bg-gray-100 text-gray-500',
        default => 'bg-gray-100 text-gray-500',
        };
        $label = match($petugas->status) {
        'active' => 'Aktif',
        'on_leave' => 'Cuti',
        'inactive' => 'Tidak Aktif',
        default => $petugas->status,
        };
        @endphp

        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3
                    px-5 py-4 border-b border-gray-100">

            {{-- Judul --}}
            <div>
                <h2 class="text-base font-semibold text-gray-800">
                    {{ $petugas->nama_petugas }}
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">
                    {{ $petugas->jabatan }}
                </p>
            </div>

            {{-- Badge + Aksi --}}
            <div class="flex flex-wrap items-center gap-2 shrink-0">

                <span class="inline-flex items-center px-3 py-1 rounded-full
                             text-xs font-medium {{ $badge }}">
                    {{ $label }}
                </span>

                {{-- Tombol Edit --}}
                <a href="{{ route('petugas.edit', $petugas) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium
                          text-white bg-blue-700 rounded-lg hover:bg-blue-800
                          focus:ring-4 focus:ring-blue-300 transition-colors duration-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                                 m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>

                {{-- Aksi: active → on_leave atau inactive --}}
                @if ($petugas->status === 'active')
                <div x-data="{ confirm: false, action: '' }">
                    <div x-show="!confirm" class="flex items-center gap-2">
                        <button @click="confirm = true; action = 'on_leave'" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs
                                           font-medium text-gray-600 bg-white border border-gray-300
                                           rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            Cuti
                        </button>
                        <button @click="confirm = true; action = 'inactive'" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs
                                           font-medium text-white bg-red-600 rounded-lg
                                           hover:bg-red-700 transition-colors duration-200">
                            Nonaktifkan
                        </button>
                    </div>
                    <div x-show="confirm" x-transition class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">Yakin ubah status?</span>
                        <button x-show="action === 'on_leave'" wire:click="setOnLeave" wire:loading.attr="disabled"
                            type="button" class="px-2.5 py-1.5 text-xs font-medium text-gray-700
                                           bg-white border border-gray-300 rounded-lg
                                           hover:bg-gray-50 transition-colors duration-200">
                            Ya, Cuti
                        </button>
                        <button x-show="action === 'inactive'" wire:click="setInactive" wire:loading.attr="disabled"
                            type="button" class="px-2.5 py-1.5 text-xs font-medium text-white
                                           bg-red-600 rounded-lg hover:bg-red-700
                                           transition-colors duration-200">
                            Ya, Nonaktifkan
                        </button>
                        <button @click="confirm = false; action = ''" type="button" class="px-2.5 py-1.5 text-xs font-medium text-gray-600
                                           bg-white border border-gray-300 rounded-lg
                                           hover:bg-gray-50 transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </div>
                @endif

                {{-- Aksi: on_leave → active atau inactive --}}
                @if ($petugas->status === 'on_leave')
                <div x-data="{ confirm: false, action: '' }">
                    <div x-show="!confirm" class="flex items-center gap-2">
                        <button @click="confirm = true; action = 'active'" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs
                                           font-medium text-white bg-green-600 rounded-lg
                                           hover:bg-green-700 transition-colors duration-200">
                            Aktifkan
                        </button>
                        <button @click="confirm = true; action = 'inactive'" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs
                                           font-medium text-white bg-red-600 rounded-lg
                                           hover:bg-red-700 transition-colors duration-200">
                            Nonaktifkan
                        </button>
                    </div>
                    <div x-show="confirm" x-transition class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">Yakin ubah status?</span>
                        <button x-show="action === 'active'" wire:click="setActive" wire:loading.attr="disabled"
                            type="button" class="px-2.5 py-1.5 text-xs font-medium text-white
                                           bg-green-600 rounded-lg hover:bg-green-700
                                           transition-colors duration-200">
                            Ya, Aktifkan
                        </button>
                        <button x-show="action === 'inactive'" wire:click="setInactive" wire:loading.attr="disabled"
                            type="button" class="px-2.5 py-1.5 text-xs font-medium text-white
                                           bg-red-600 rounded-lg hover:bg-red-700
                                           transition-colors duration-200">
                            Ya, Nonaktifkan
                        </button>
                        <button @click="confirm = false; action = ''" type="button" class="px-2.5 py-1.5 text-xs font-medium text-gray-600
                                           bg-white border border-gray-300 rounded-lg
                                           hover:bg-gray-50 transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </div>
                @endif

                {{-- Aksi: inactive → active --}}
                @if ($petugas->status === 'inactive')
                <div x-data="{ confirm: false }">
                    <button x-show="!confirm" @click="confirm = true" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs
                                       font-medium text-white bg-green-600 rounded-lg
                                       hover:bg-green-700 focus:ring-4 focus:ring-green-300
                                       transition-colors duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Aktifkan Kembali
                    </button>
                    <div x-show="confirm" x-transition class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">Yakin aktifkan?</span>
                        <button wire:click="setActive" wire:loading.attr="disabled" type="button" class="px-2.5 py-1.5 text-xs font-medium text-white
                                           bg-green-600 rounded-lg hover:bg-green-700
                                           transition-colors duration-200">
                            Ya
                        </button>
                        <button @click="confirm = false" type="button" class="px-2.5 py-1.5 text-xs font-medium text-gray-600
                                           bg-white border border-gray-300 rounded-lg
                                           hover:bg-gray-50 transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </div>
                @endif

            </div>
        </div>

        {{-- Field Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0
                    sm:divide-x divide-gray-100">

            <div class="px-5 py-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">
                    Nama Petugas
                </p>
                <p class="text-sm font-medium text-gray-800">{{ $petugas->nama_petugas }}</p>
            </div>

            <div class="px-5 py-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">
                    Jabatan
                </p>
                <p class="text-sm font-medium text-gray-800">{{ $petugas->jabatan }}</p>
            </div>

            <div class="px-5 py-4 border-t border-gray-100">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">
                    Nomor Telepon
                </p>
                <p class="text-sm font-medium text-gray-800 font-mono">
                    {{ $petugas->nomor_telepon }}
                </p>
            </div>

            <div class="px-5 py-4 border-t border-gray-100">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">
                    Wilayah Tugas
                </p>
                <p class="text-sm font-medium text-gray-800">{{ $petugas->wilayah_tugas }}</p>
            </div>

            <div class="px-5 py-4 border-t border-gray-100">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">
                    Status
                </p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                             text-xs font-medium {{ $badge }}">
                    {{ $label }}
                </span>
            </div>

            <div class="px-5 py-4 border-t border-gray-100">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">
                    Tanggal Ditambahkan
                </p>
                <p class="text-sm text-gray-800">
                    {{ $petugas->created_at->format('d/m/Y H:i') }}
                </p>
            </div>

            <div class="px-5 py-4 border-t border-gray-100">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">
                    Terakhir Diperbarui
                </p>
                <p class="text-sm text-gray-800">
                    {{ $petugas->updated_at->format('d/m/Y H:i') }}
                </p>
            </div>

        </div>

        {{-- Card Footer --}}
        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 rounded-b-lg">
            <p class="text-xs text-gray-400">
                ID Petugas: <span class="font-mono">{{ $petugas->id }}</span>
            </p>
        </div>

    </div>

</div>