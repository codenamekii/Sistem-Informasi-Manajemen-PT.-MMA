<div>

    {{-- Flash Message --}}
    <x-alert type="success" :message="session('success')" />

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <x-page-header title="Detail Kerja Sama" description="Informasi lengkap perjanjian kerja sama yang dipilih."
            class="mb-0" />
        <a href="{{ route('kerja-sama.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600
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
        $badge = match($kerjaSama->status) {
        'active' => 'bg-green-100 text-green-700',
        'draft' => 'bg-blue-100 text-blue-700',
        'expired' => 'bg-red-100 text-red-700',
        'terminated' => 'bg-gray-100 text-gray-500',
        default => 'bg-gray-100 text-gray-500',
        };
        $label = match($kerjaSama->status) {
        'active' => 'Aktif',
        'draft' => 'Draft',
        'expired' => 'Kadaluarsa',
        'terminated' => 'Dihentikan',
        default => $kerjaSama->status,
        };
        @endphp

        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3
                    px-5 py-4 border-b border-gray-100">

            {{-- Judul --}}
            <div>
                <h2 class="text-base font-semibold text-gray-800 font-mono">
                    {{ $kerjaSama->nomor_perjanjian }}
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">
                    {{ $kerjaSama->nama_fasilitas_kesehatan }}
                </p>
            </div>

            {{-- Badge + Aksi --}}
            <div class="flex flex-wrap items-center gap-2 shrink-0">

                <span class="inline-flex items-center px-3 py-1 rounded-full
                             text-xs font-medium {{ $badge }}">
                    {{ $label }}
                </span>

                {{-- Tombol Edit --}}
                <a href="{{ route('kerja-sama.edit', $kerjaSama) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium
                          text-white bg-blue-700 rounded-lg hover:bg-blue-800
                          focus:ring-4 focus:ring-blue-300 transition-colors duration-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                                 m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>

                {{-- Tombol Akhiri Kerja Sama --}}
                @if ($kerjaSama->status !== 'terminated')
                <div x-data="{ confirm: false }">
                    <button x-show="!confirm" @click="confirm = true" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium
                                   text-white bg-red-600 rounded-lg hover:bg-red-700
                                   focus:ring-4 focus:ring-red-300 transition-colors duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728
                                         A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                        Akhiri Kerja Sama
                    </button>
                    <div x-show="confirm" x-transition class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">Yakin mengakhiri?</span>
                        <button wire:click="terminate" wire:loading.attr="disabled" type="button" class="px-2.5 py-1.5 text-xs font-medium text-white bg-red-600
                                       rounded-lg hover:bg-red-700 transition-colors duration-200">
                            Ya
                        </button>
                        <button @click="confirm = false" type="button" class="px-2.5 py-1.5 text-xs font-medium text-gray-600 bg-white
                                       border border-gray-300 rounded-lg hover:bg-gray-50
                                       transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </div>
                @endif

                {{-- Tombol Aktifkan Kembali --}}
                @if ($kerjaSama->status === 'terminated')
                <div x-data="{ confirm: false }">
                    <button x-show="!confirm" @click="confirm = true" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium
                                   text-white bg-green-600 rounded-lg hover:bg-green-700
                                   focus:ring-4 focus:ring-green-300 transition-colors duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Aktifkan Kembali
                    </button>
                    <div x-show="confirm" x-transition class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">Yakin mengaktifkan?</span>
                        <button wire:click="activate" wire:loading.attr="disabled" type="button" class="px-2.5 py-1.5 text-xs font-medium text-white bg-green-600
                                       rounded-lg hover:bg-green-700 transition-colors duration-200">
                            Ya
                        </button>
                        <button @click="confirm = false" type="button" class="px-2.5 py-1.5 text-xs font-medium text-gray-600 bg-white
                                       border border-gray-300 rounded-lg hover:bg-gray-50
                                       transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </div>
                @endif

            </div>
        </div>

        {{-- Field Grid --}}
        {{-- Informasi Utama (REPLACE FIELD GRID) --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 space-y-6">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700">Informasi Utama</h3>
                    </div>

                    <dl class="grid grid-cols-1 md:grid-cols-2">
                        <div class="px-5 py-4 border-b md:border-r border-gray-100">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Nomor Perjanjian</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $kerjaSama->nomor_perjanjian }}
                            </dd>
                        </div>

                        <div class="px-5 py-4 border-b border-gray-100">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Fasilitas Kesehatan
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $kerjaSama->nama_fasilitas_display }}
                            </dd>

                            @if ($kerjaSama->is_connected_to_fasilitas)
                            <p class="mt-1 text-xs text-gray-500">
                                Tersambung ke data fasilitas kesehatan
                            </p>
                            @else
                            <p class="mt-1 text-xs text-amber-600">
                                Masih memakai nama fasilitas lama
                            </p>
                            @endif
                        </div>

                        <div class="px-5 py-4 border-b md:border-r border-gray-100">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Harga per Kilogram
                            </dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $kerjaSama->harga_per_kilogram_rupiah }}
                            </dd>
                        </div>

                        <div class="px-5 py-4 border-b border-gray-100">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Status</dt>
                            <dd class="mt-1">
                                @php
                                $badge = match($kerjaSama->status) {
                                'draft' => 'bg-gray-100 text-gray-600',
                                'active' => 'bg-green-100 text-green-700',
                                'expired' => 'bg-yellow-100 text-yellow-700',
                                'terminated' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-500',
                                };

                                $label = match($kerjaSama->status) {
                                'draft' => 'Draft',
                                'active' => 'Aktif',
                                'expired' => 'Expired',
                                'terminated' => 'Terminated',
                                default => $kerjaSama->status,
                                };
                                @endphp

                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">
                                    {{ $label }}
                                </span>
                            </dd>
                        </div>

                        <div class="px-5 py-4 border-b md:border-r border-gray-100">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Tanggal Mulai</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ optional($kerjaSama->tanggal_mulai)->format('d/m/Y') ?: '—' }}
                            </dd>
                        </div>

                        <div class="px-5 py-4 border-b border-gray-100">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Tanggal Berakhir</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ optional($kerjaSama->tanggal_berakhir)->format('d/m/Y') ?: '—' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700">Status Koneksi</h3>
                    </div>

                    <div class="px-5 py-4">
                        @if ($kerjaSama->is_connected_to_fasilitas)
                        <div class="space-y-2">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                Sudah Tersambung
                            </span>
                            <p class="text-sm text-gray-600">
                                Record ini sudah menggunakan relasi ke data Fasilitas Kesehatan.
                            </p>
                        </div>
                        @else
                        <div class="space-y-2">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                Masih Data Lama
                            </span>
                            <p class="text-sm text-gray-600">
                                Record ini masih mengandalkan kolom nama fasilitas lama dan belum tersambung ke relasi
                                fasilitas.
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700">Metadata</h3>
                    </div>

                    <dl class="px-5 py-4 space-y-4">
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Dibuat</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ optional($kerjaSama->created_at)->format('d/m/Y H:i') ?: '—' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Diperbarui</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ optional($kerjaSama->updated_at)->format('d/m/Y H:i') ?: '—' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Card Footer --}}
        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 rounded-b-lg">
            <p class="text-xs text-gray-400">
                ID Perjanjian: <span class="font-mono">{{ $kerjaSama->id }}</span>
            </p>
        </div>

    </div>

</div>