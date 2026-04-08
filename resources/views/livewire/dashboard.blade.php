<div>

  {{-- Page Header --}}
  <x-page-header title="Selamat datang, {{ auth()->user()->name }}"
    description="{{ now()->locale('id')->translatedFormat('l, d F Y') }} — Ringkasan operasional PT. Mitra Mecca Abadi" />

  {{-- Stat Cards --}}
  <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-4 mb-6">

    <a href="{{ route('fasilitas-kesehatan.index') }}" class="block group">
      <x-stat-card title="Fasilitas Kesehatan" :value="$totalFasilitas" description="Terdaftar di sistem" color="blue"
        class="group-hover:border-blue-300 transition-colors duration-150">
        <x-slot:icon>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16" />
          </svg>
        </x-slot:icon>
      </x-stat-card>
    </a>

    <a href="{{ route('kerja-sama.index') }}" class="block group">
      <x-stat-card title="Kerja Sama Aktif" :value="$kerjaSamaAktif" description="Perjanjian berjalan" color="green"
        class="group-hover:border-green-300 transition-colors duration-150">
        <x-slot:icon>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
        </x-slot:icon>
      </x-stat-card>
    </a>

    <a href="{{ route('dokumen.index') }}" class="block group">
      <x-stat-card title="Dokumen Expired" :value="$dokumenExpiredCount" description="Perlu perhatian"
        color="{{ $dokumenExpiredCount > 0 ? 'red' : 'green' }}"
        class="group-hover:border-red-300 transition-colors duration-150">
        <x-slot:icon>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </x-slot:icon>
      </x-stat-card>
    </a>

    <a href="{{ route('jadwal-pengangkutan.index') }}" class="block group">
      <x-stat-card title="Jadwal Hari Ini" :value="$jadwalHariIniCount"
        description="{{ now()->locale('id')->translatedFormat('d F') }}" color="yellow"
        class="group-hover:border-yellow-300 transition-colors duration-150">
        <x-slot:icon>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </x-slot:icon>
      </x-stat-card>
    </a>

    <a href="{{ route('realisasi.index') }}" class="block group">
      <x-stat-card title="Bukti Kurang" :value="$buktiKurangCount" description="Realisasi belum lengkap"
        color="{{ $buktiKurangCount > 0 ? 'red' : 'green' }}"
        class="group-hover:border-orange-300 transition-colors duration-150">
        <x-slot:icon>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </x-slot:icon>
      </x-stat-card>
    </a>

  </div>

  {{-- Panel Notifikasi --}}
  <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

    {{-- Kolom Kiri --}}
    <div class="space-y-5">

      {{-- Jadwal Hari Ini --}}
      <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
          <div class="flex items-center gap-2">
            <span class="inline-block w-2 h-2 rounded-full bg-yellow-400"></span>
            <h3 class="text-sm font-semibold text-gray-700">Jadwal Hari Ini</h3>
          </div>
          <a href="{{ route('jadwal-pengangkutan.index') }}" class="text-xs text-blue-600 hover:underline">Lihat
            semua</a>
        </div>
        <div class="divide-y divide-gray-50">
          @forelse ($notifJadwalHariIni as $item)
            @php
              $statusBadge = match ($item['status']) {
                'draft' => 'bg-gray-100 text-gray-600',
                'scheduled' => 'bg-yellow-100 text-yellow-700',
                'in_progress' => 'bg-purple-100 text-purple-700',
                'completed' => 'bg-green-100 text-green-700',
                default => 'bg-gray-100 text-gray-500',
              };
              $statusLabel = match ($item['status']) {
                'draft' => 'Draft',
                'scheduled' => 'Terjadwal',
                'in_progress' => 'Berlangsung',
                'completed' => 'Selesai',
                default => $item['status'],
              };
            @endphp
            <div class="flex items-start justify-between px-5 py-3 hover:bg-gray-50">
              <div>
                <p class="text-sm font-medium text-gray-800">{{ $item['label'] }}</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ $item['info'] }}</p>
              </div>
              <span class="ml-3 shrink-0 inline-flex items-center px-2 py-0.5 rounded-full
                                         text-xs font-medium {{ $statusBadge }}">
                {{ $statusLabel }}
              </span>
            </div>
          @empty
            <div class="px-5 py-8 text-center">
              <p class="text-sm text-gray-400">Tidak ada jadwal untuk hari ini.</p>
            </div>
          @endforelse
        </div>
      </div>

      {{-- Kerja Sama Akan Habis --}}
      @if (count($notifKerjaSamaHabis) > 0)
        <div class="bg-white rounded-xl border border-orange-200 shadow-sm">
          <div class="flex items-center justify-between px-5 py-4 border-b border-orange-100">
            <div class="flex items-center gap-2">
              <span class="inline-block w-2 h-2 rounded-full bg-orange-400"></span>
              <h3 class="text-sm font-semibold text-gray-700">Kerja Sama Akan Berakhir</h3>
              <span class="text-xs text-orange-600 font-medium">dalam 30 hari</span>
            </div>
            <a href="{{ route('kerja-sama.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua</a>
          </div>
          <div class="divide-y divide-orange-50">
            @foreach ($notifKerjaSamaHabis as $item)
              <div class="flex items-start justify-between px-5 py-3 hover:bg-orange-50">
                <div>
                  <p class="text-sm font-medium text-gray-800">{{ $item['label'] }}</p>
                  <p class="text-xs text-orange-600 mt-0.5">{{ $item['info'] }}</p>
                </div>
                <span class="ml-3 shrink-0 text-xs font-semibold text-orange-600">
                  {{ $item['hari'] }} hari
                </span>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      {{-- Fasilitas dengan Kendala --}}
      @if (count($notifFasilitasKendala) > 0)
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
          <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div class="flex items-center gap-2">
              <span class="inline-block w-2 h-2 rounded-full bg-gray-400"></span>
              <h3 class="text-sm font-semibold text-gray-700">Fasilitas dengan Kendala</h3>
            </div>
            <a href="{{ route('fasilitas-kesehatan.index') }}" class="text-xs text-blue-600 hover:underline">Lihat
              semua</a>
          </div>
          <div class="divide-y divide-gray-50">
            @foreach ($notifFasilitasKendala as $item)
              <div class="px-5 py-3 hover:bg-gray-50">
                <p class="text-sm font-medium text-gray-800">{{ $item['label'] }}</p>
                <p class="text-xs text-gray-500 mt-0.5 italic">{{ $item['info'] }}</p>
              </div>
            @endforeach
          </div>
        </div>
      @endif

    </div>

    {{-- Kolom Kanan --}}
    <div class="space-y-5">

      {{-- Realisasi Bukti Kurang --}}
      @if (count($notifBuktiKurang) > 0)
        <div class="bg-white rounded-xl border border-orange-200 shadow-sm">
          <div class="flex items-center justify-between px-5 py-4 border-b border-orange-100">
            <div class="flex items-center gap-2">
              <span class="inline-block w-2 h-2 rounded-full bg-orange-500"></span>
              <h3 class="text-sm font-semibold text-gray-700">Realisasi Bukti Belum Lengkap</h3>
            </div>
            <a href="{{ route('realisasi.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua</a>
          </div>
          <div class="divide-y divide-orange-50">
            @foreach ($notifBuktiKurang as $item)
              <div class="flex items-start justify-between px-5 py-3 hover:bg-orange-50">
                <div>
                  <p class="text-sm font-medium text-gray-800">{{ $item['label'] }}</p>
                  <p class="text-xs text-gray-500 mt-0.5">{{ $item['info'] }}</p>
                  <div class="flex gap-2 mt-1">
                    <span class="text-[10px] {{ $item['punya_manifest'] ? 'text-green-600' : 'text-red-500' }}">
                      {{ $item['punya_manifest'] ? '✓ Manifest' : '✗ Manifest' }}
                    </span>
                    <span class="text-[10px] {{ $item['punya_foto'] ? 'text-green-600' : 'text-red-500' }}">
                      {{ $item['punya_foto'] ? '✓ Foto' : '✗ Foto' }}
                    </span>
                  </div>
                </div>
                <a href="{{ route('realisasi.show', $item['id']) }}"
                  class="ml-3 shrink-0 text-xs text-blue-600 hover:underline">
                  Detail
                </a>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      {{-- Dokumen Expired --}}
      @if (count($notifDokumenExpired) > 0)
        <div class="bg-white rounded-xl border border-red-200 shadow-sm">
          <div class="flex items-center justify-between px-5 py-4 border-b border-red-100">
            <div class="flex items-center gap-2">
              <span class="inline-block w-2 h-2 rounded-full bg-red-500"></span>
              <h3 class="text-sm font-semibold text-gray-700">Dokumen Expired</h3>
            </div>
            <a href="{{ route('dokumen.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua</a>
          </div>
          <div class="divide-y divide-red-50">
            @foreach ($notifDokumenExpired as $item)
              <div class="px-5 py-3 hover:bg-red-50">
                <p class="text-sm font-medium text-gray-800">{{ $item['label'] }}</p>
                <p class="text-xs text-red-600 mt-0.5">{{ $item['info'] }}</p>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      {{-- Dokumen Segera Expired --}}
      @if (count($notifDokumenSegera) > 0)
        <div class="bg-white rounded-xl border border-yellow-200 shadow-sm">
          <div class="flex items-center justify-between px-5 py-4 border-b border-yellow-100">
            <div class="flex items-center gap-2">
              <span class="inline-block w-2 h-2 rounded-full bg-yellow-400"></span>
              <h3 class="text-sm font-semibold text-gray-700">Dokumen Segera Berakhir</h3>
              <span class="text-xs text-yellow-600 font-medium">dalam 30 hari</span>
            </div>
            <a href="{{ route('dokumen.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua</a>
          </div>
          <div class="divide-y divide-yellow-50">
            @foreach ($notifDokumenSegera as $item)
              <div class="px-5 py-3 hover:bg-yellow-50">
                <p class="text-sm font-medium text-gray-800">{{ $item['label'] }}</p>
                <p class="text-xs text-yellow-700 mt-0.5">{{ $item['info'] }}</p>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      {{-- Semua bersih --}}
      @if (count($notifBuktiKurang) === 0 && count($notifDokumenExpired) === 0 && count($notifDokumenSegera) === 0)
        <div class="bg-white rounded-xl border border-green-200 shadow-sm">
          <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
            <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mb-4">
              <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <p class="text-sm font-medium text-green-700">Semua dalam kondisi baik</p>
            <p class="text-xs text-gray-400 mt-1">Tidak ada dokumen expired atau bukti yang perlu dilengkapi.</p>
          </div>
        </div>
      @endif

    </div>

  </div>

</div>