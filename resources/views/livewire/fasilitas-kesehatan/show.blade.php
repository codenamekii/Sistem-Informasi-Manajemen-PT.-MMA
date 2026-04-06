<div>
    {{-- Flash Message --}}
    <x-alert type="success" :message="session('success')" />

    @php
    $statusProspek = $fasilitas->status;

    $statusProspekBadge = match ($statusProspek) {
    'prospect' => 'bg-yellow-100 text-yellow-700',
    'active' => 'bg-green-100 text-green-700',
    'inactive' => 'bg-gray-100 text-gray-600',
    default => 'bg-gray-100 text-gray-500',
    };

    $statusProspekLabel = match ($statusProspek) {
    'prospect' => 'Prospek',
    'active' => 'Aktif',
    'inactive' => 'Non-aktif',
    default => $statusProspek,
    };

    $statusPenawaran = $fasilitas->status_penawaran ?? 'belum_masuk_penawaran';

    $statusPenawaranBadge = match ($statusPenawaran) {
    'masuk_penawaran' => 'bg-blue-100 text-blue-700',
    'belum_masuk_penawaran' => 'bg-gray-100 text-gray-600',
    default => 'bg-gray-100 text-gray-500',
    };

    $statusPenawaranLabel = match ($statusPenawaran) {
    'masuk_penawaran' => 'Masuk Penawaran',
    'belum_masuk_penawaran' => 'Belum Masuk Penawaran',
    default => $statusPenawaran,
    };
    @endphp

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-6">
        <x-page-header title="Detail Fasilitas Kesehatan" :description="$fasilitas->nama" class="mb-0" />

        <div class="flex flex-col sm:flex-row gap-2 shrink-0">
            <a href="{{ route('fasilitas-kesehatan.edit', $fasilitas->id) }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>

            <a href="{{ route('fasilitas-kesehatan.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 transition-colors duration-200">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Konten utama --}}
        <div class="xl:col-span-2 space-y-6">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-700">Informasi Utama</h3>
                </div>

                <dl class="grid grid-cols-1 md:grid-cols-2">
                    <div class="px-5 py-4 border-b md:border-r border-gray-100">
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Nama Fasilitas</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">
                            {{ $fasilitas->nama }}
                        </dd>
                    </div>

                    <div class="px-5 py-4 border-b border-gray-100">
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Jenis Fasilitas</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $fasilitas->jenis_fasilitas }}
                        </dd>
                    </div>

                    <div class="px-5 py-4 border-b md:border-r border-gray-100">
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Kota/Kabupaten</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $fasilitas->kota_kabupaten }}
                        </dd>
                    </div>

                    <div class="px-5 py-4 border-b border-gray-100">
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Provinsi</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $fasilitas->provinsi ?: '—' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-700">Informasi PIC</h3>
                </div>

                <dl class="grid grid-cols-1 md:grid-cols-2">
                    <div class="px-5 py-4 border-b md:border-r border-gray-100">
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Nama PIC</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $fasilitas->pic_nama ?: '—' }}
                        </dd>
                    </div>

                    <div class="px-5 py-4 border-b border-gray-100">
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Nomor Telepon PIC</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $fasilitas->pic_nomor_telepon ?: '—' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-700">Kendala</h3>
                </div>

                <div class="px-5 py-4">
                    @if (filled($fasilitas->kendala))
                    <p class="text-sm leading-6 text-gray-700 whitespace-pre-line">
                        {{ $fasilitas->kendala }}
                    </p>
                    @else
                    <p class="text-sm text-gray-400">
                        Belum ada kendala yang dicatat.
                    </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar kanan --}}
        <div class="space-y-6">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-700">Status</h3>
                </div>

                <div class="px-5 py-4 space-y-4">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500 mb-2">Status Prospek</p>
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusProspekBadge }}">
                            {{ $statusProspekLabel }}
                        </span>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500 mb-2">Status Penawaran</p>
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusPenawaranBadge }}">
                            {{ $statusPenawaranLabel }}
                        </span>
                    </div>
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
                            {{ optional($fasilitas->created_at)->format('d/m/Y H:i') ?: '—' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Diperbarui</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ optional($fasilitas->updated_at)->format('d/m/Y H:i') ?: '—' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>