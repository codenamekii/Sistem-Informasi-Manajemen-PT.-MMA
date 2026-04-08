<div>

    {{-- Flash Message --}}
    <x-alert type="success" :message="session('success')" />

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <x-page-header title="Detail Dokumen" description="Informasi lengkap dokumen yang dipilih." class="mb-0" />
        <a href="{{ route('dokumen.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600
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
        $badge = match($dokumen->status) {
        'valid' => 'bg-green-100 text-green-700',
        'expiring_soon' => 'bg-yellow-100 text-yellow-700',
        'expired' => 'bg-red-100 text-red-700',
        'missing' => 'bg-gray-100 text-gray-500',
        default => 'bg-gray-100 text-gray-500',
        };
        $label = match($dokumen->status) {
        'valid' => 'Valid',
        'expiring_soon' => 'Segera Berakhir',
        'expired' => 'Kadaluarsa',
        'missing' => 'Tidak Ada',
        default => $dokumen->status,
        };
        @endphp

        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3
                    px-5 py-4 border-b border-gray-100">

            {{-- Judul --}}
            <div>
                <h2 class="text-base font-semibold text-gray-800">
                    {{ $dokumen->nama_dokumen }}
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">
                    {{ $dokumen->kategori_dokumen }}
                </p>
            </div>

            {{-- Badge + Aksi --}}
            <div class="flex flex-wrap items-center gap-2 shrink-0">

                <span class="inline-flex items-center px-3 py-1 rounded-full
                             text-xs font-medium {{ $badge }}">
                    {{ $label }}
                </span>

                {{-- Tombol Edit --}}
                <a href="{{ route('dokumen.edit', $dokumen) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium
                          text-white bg-blue-700 rounded-lg hover:bg-blue-800
                          focus:ring-4 focus:ring-blue-300 transition-colors duration-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                                 m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>

                {{-- Aksi: status valid --}}
                @if ($dokumen->status === 'valid')
                <div x-data="{ confirm: false, action: '' }">
                    <div x-show="!confirm" class="flex items-center gap-2">
                        <button @click="confirm = true; action = 'expired'" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs
                                           font-medium text-white bg-red-600 rounded-lg
                                           hover:bg-red-700 focus:ring-4 focus:ring-red-300
                                           transition-colors duration-200">
                            Tandai Kadaluarsa
                        </button>
                        <button @click="confirm = true; action = 'missing'" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs
                                           font-medium text-gray-600 bg-white border border-gray-300
                                           rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            Tandai Tidak Ada
                        </button>
                    </div>
                    <div x-show="confirm" x-transition class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">Yakin ubah status?</span>
                        <button x-show="action === 'expired'" wire:click="markAsExpired" wire:loading.attr="disabled"
                            type="button" class="px-2.5 py-1.5 text-xs font-medium text-white
                                           bg-red-600 rounded-lg hover:bg-red-700
                                           transition-colors duration-200">
                            Ya, Kadaluarsa
                        </button>
                        <button x-show="action === 'missing'" wire:click="markAsMissing" wire:loading.attr="disabled"
                            type="button" class="px-2.5 py-1.5 text-xs font-medium text-white
                                           bg-gray-600 rounded-lg hover:bg-gray-700
                                           transition-colors duration-200">
                            Ya, Tidak Ada
                        </button>
                        <button @click="confirm = false; action = ''" type="button" class="px-2.5 py-1.5 text-xs font-medium text-gray-600
                                           bg-white border border-gray-300 rounded-lg
                                           hover:bg-gray-50 transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </div>
                @endif

                {{-- Aksi: status expiring_soon --}}
                @if ($dokumen->status === 'expiring_soon')
                <div x-data="{ confirm: false, action: '' }">
                    <div x-show="!confirm" class="flex items-center gap-2">
                        <button @click="confirm = true; action = 'renew'" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs
                                           font-medium text-white bg-green-600 rounded-lg
                                           hover:bg-green-700 focus:ring-4 focus:ring-green-300
                                           transition-colors duration-200">
                            Perpanjang
                        </button>
                        <button @click="confirm = true; action = 'expired'" type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs
                                           font-medium text-white bg-red-600 rounded-lg
                                           hover:bg-red-700 transition-colors duration-200">
                            Tandai Kadaluarsa
                        </button>
                    </div>
                    <div x-show="confirm" x-transition class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">Yakin ubah status?</span>
                        <button x-show="action === 'renew'" wire:click="renew" wire:loading.attr="disabled"
                            type="button" class="px-2.5 py-1.5 text-xs font-medium text-white
                                           bg-green-600 rounded-lg hover:bg-green-700
                                           transition-colors duration-200">
                            Ya, Perpanjang
                        </button>
                        <button x-show="action === 'expired'" wire:click="markAsExpired" wire:loading.attr="disabled"
                            type="button" class="px-2.5 py-1.5 text-xs font-medium text-white
                                           bg-red-600 rounded-lg hover:bg-red-700
                                           transition-colors duration-200">
                            Ya, Kadaluarsa
                        </button>
                        <button @click="confirm = false; action = ''" type="button" class="px-2.5 py-1.5 text-xs font-medium text-gray-600
                                           bg-white border border-gray-300 rounded-lg
                                           hover:bg-gray-50 transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </div>
                @endif

                {{-- Aksi: status expired atau missing --}}
                @if (in_array($dokumen->status, ['expired', 'missing']))
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
                        <button wire:click="restore" wire:loading.attr="disabled" type="button" class="px-2.5 py-1.5 text-xs font-medium text-white
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
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 space-y-6">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700">Informasi Utama</h3>
                    </div>

                    <dl class="grid grid-cols-1 md:grid-cols-2">
                        <div class="px-5 py-4 border-b md:border-r border-gray-100">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Nama Dokumen</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $dokumen->nama_dokumen }}
                            </dd>
                        </div>

                        <div class="px-5 py-4 border-b border-gray-100">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Kategori Dokumen</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $dokumen->kategori_dokumen }}
                            </dd>
                        </div>

                        <div class="px-5 py-4 border-b md:border-r border-gray-100">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Nomor Referensi</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $dokumen->nomor_referensi }}
                            </dd>
                        </div>

                        <div class="px-5 py-4 border-b border-gray-100">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Tanggal Berlaku Sampai
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ optional($dokumen->tanggal_berlaku_sampai)->format('d/m/Y') ?: '—' }}
                            </dd>
                        </div>

                        <div class="px-5 py-4 border-b md:border-r border-gray-100">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Status</dt>
                            <dd class="mt-1">
                                @php
                                $badge = match($dokumen->status) {
                                'valid' => 'bg-green-100 text-green-700',
                                'expiring_soon' => 'bg-yellow-100 text-yellow-700',
                                'expired' => 'bg-red-100 text-red-700',
                                'missing' => 'bg-gray-100 text-gray-600',
                                default => 'bg-gray-100 text-gray-500',
                                };

                                $label = match($dokumen->status) {
                                'valid' => 'Valid',
                                'expiring_soon' => 'Segera Berakhir',
                                'expired' => 'Expired',
                                'missing' => 'Missing',
                                default => $dokumen->status,
                                };
                                @endphp

                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">
                                    {{ $label }}
                                </span>
                            </dd>
                        </div>

                        <div class="px-5 py-4 border-b border-gray-100">
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Sumber Keterkaitan
                            </dt>
                            <dd class="mt-1">
                                @if ($dokumen->is_connected_to_kerja_sama)
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    Tersambung ke Kerja Sama
                                </span>
                                @else
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    Masih Data Lama
                                </span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700">Keterkaitan Dokumen</h3>
                    </div>

                    <div class="px-5 py-4 space-y-4">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Terkait</p>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $dokumen->kerja_sama_display }}
                            </p>
                        </div>

                        @if ($dokumen->is_connected_to_kerja_sama && $dokumen->kerjaSama)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Nomor Perjanjian
                                </p>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $dokumen->kerjaSama->nomor_perjanjian }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Fasilitas Kesehatan
                                </p>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $dokumen->kerjaSama->fasilitasKesehatan?->nama ?:
                                    ($dokumen->kerjaSama->nama_fasilitas_kesehatan ?: '—') }}
                                </p>
                            </div>
                        </div>
                        @else
                        <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3">
                            <p class="text-sm text-amber-800">
                                Dokumen ini belum tersambung ke relasi Kerja Sama. Sistem masih memakai nilai lama pada
                                field
                                <span class="font-medium">terkait_dengan</span>.
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700">Status Koneksi</h3>
                    </div>

                    <div class="px-5 py-4">
                        @if ($dokumen->is_connected_to_kerja_sama)
                        <div class="space-y-2">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                Sudah Tersambung
                            </span>
                            <p class="text-sm text-gray-600">
                                Dokumen ini sudah menggunakan relasi ke data Kerja Sama.
                            </p>
                        </div>
                        @else
                        <div class="space-y-2">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                Belum Tersambung
                            </span>
                            <p class="text-sm text-gray-600">
                                Dokumen ini masih mengandalkan data lama dan belum terhubung ke relasi Kerja Sama.
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
                                {{ optional($dokumen->created_at)->format('d/m/Y H:i') ?: '—' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Diperbarui</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ optional($dokumen->updated_at)->format('d/m/Y H:i') ?: '—' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Card Footer --}}
        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 rounded-b-lg">
            <p class="text-xs text-gray-400">
                ID Dokumen: <span class="font-mono">{{ $dokumen->id }}</span>
            </p>
        </div>

    </div>

</div>