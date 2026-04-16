<div>
  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-6">
    <x-page-header title="Detail Jadwal Pengangkutan" :description="$detail['kode_jadwal']" class="mb-0" />

    <div class="flex flex-col sm:flex-row gap-2 shrink-0">
      <a href="{{ route('jadwal-pengangkutan.edit', $detail['id']) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium
                       text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4
                       focus:ring-blue-300 transition-colors duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2
                           0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        Edit
      </a>
      <a href="{{ route('jadwal-pengangkutan.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium
                       text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50
                       focus:ring-4 focus:ring-gray-200 transition-colors duration-200">
        Kembali
      </a>
    </div>
  </div>

  <div class="space-y-5">

    {{-- Informasi Jadwal --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
      <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-sm font-semibold text-gray-700">Informasi Jadwal</h3>
      </div>
      <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">

        <div>
          <p class="text-xs text-gray-500 mb-1">Kode Jadwal</p>
          <p class="text-sm font-mono font-medium text-gray-800">
            {{ $detail['kode_jadwal'] }}
          </p>
          @if ($detail['is_connected'])
            <span class="text-[10px] text-blue-500">● Tersambung ke relasi baru</span>
          @else
            <span class="text-[10px] text-gray-400">○ Masih data lama</span>
          @endif
        </div>

        <div>
          <p class="text-xs text-gray-500 mb-1">Status</p>
          @php
            $badge = match ($detail['status']) {
              'draft' => 'bg-gray-100 text-gray-600',
              'scheduled' => 'bg-yellow-100 text-yellow-700',
              'in_progress' => 'bg-purple-100 text-purple-700',
              'completed' => 'bg-green-100 text-green-700',
              'cancelled' => 'bg-red-100 text-red-700',
              default => 'bg-gray-100 text-gray-500',
            };
            $label = match ($detail['status']) {
              'draft' => 'Draft',
              'scheduled' => 'Terjadwal',
              'in_progress' => 'Berlangsung',
              'completed' => 'Selesai',
              'cancelled' => 'Dibatalkan',
              default => $detail['status'],
            };
          @endphp
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                 text-xs font-medium {{ $badge }}">
            {{ $label }}
          </span>
        </div>

        <div>
          <p class="text-xs text-gray-500 mb-1">Tanggal Pengangkutan</p>
          <p class="text-sm text-gray-800">{{ $detail['tanggal_pengangkutan'] }}</p>
        </div>

        @if ($detail['status'] === 'completed')
          <div>
            <p class="text-xs text-gray-500 mb-1">Tanggal Realisasi</p>
            <p class="text-sm text-gray-800">{{ $detail['tanggal_realisasi'] }}</p>
          </div>
        @endif

        <div>
          <p class="text-xs text-gray-500 mb-1">Fasilitas Kesehatan</p>
          <p class="text-sm text-gray-800">{{ $detail['nama_fasilitas_display'] }}</p>
          @if ($detail['nomor_perjanjian'] !== '—')
            <p class="text-xs text-gray-400 mt-0.5">
              No. Perjanjian: {{ $detail['nomor_perjanjian'] }}
            </p>
          @endif
        </div>

        <div>
          <p class="text-xs text-gray-500 mb-1">Armada</p>
          <p class="text-sm font-mono text-gray-800">{{ $detail['armada_display'] }}</p>
        </div>

      </div>
    </div>

    {{-- Petugas --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
      <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-sm font-semibold text-gray-700">Petugas Pengangkutan</h3>
      </div>
      <div class="px-6 py-5">
        @if (count($detail['petugas_list']) > 0)
          <ul class="divide-y divide-gray-100">
            @foreach ($detail['petugas_list'] as $p)
              <li class="flex items-center justify-between py-2.5 first:pt-0 last:pb-0">
                <span class="text-sm text-gray-800">{{ $p['nama'] }}</span>
                <span class="text-xs text-gray-500">{{ $p['jabatan'] }}</span>
              </li>
            @endforeach
          </ul>
        @else
          <p class="text-sm text-gray-500">
            {{ $detail['petugas_fallback'] }}
            <span class="text-xs text-gray-400 ml-1">(data lama)</span>
          </p>
        @endif
      </div>
    </div>

    {{-- Ringkasan Realisasi --}}
    @if ($detail['status'] === 'completed')
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
          <h3 class="text-sm font-semibold text-gray-700">Ringkasan Realisasi</h3>
        </div>
        <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
            <p class="text-xs text-gray-500 mb-1">Total Limbah Diangkut</p>
            <p class="text-sm font-semibold text-gray-800">
              {{ $detail['total_limbah_kg_display'] }}
            </p>
          </div>

          <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
            <p class="text-xs text-gray-500 mb-1">Harga per Kg</p>
            <p class="text-sm font-semibold text-gray-800">
              {{ $detail['harga_per_kg_realisasi_rupiah'] }}
            </p>
          </div>

          <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
            <p class="text-xs text-gray-500 mb-1">Total Biaya Realisasi</p>
            <p class="text-sm font-semibold text-gray-800">
              {{ $detail['total_biaya_realisasi_rupiah'] }}
            </p>
          </div>
        </div>
      </div>
    @endif

    {{-- Bukti Realisasi — hanya tampil jika completed --}}
    @if ($detail['status'] === 'completed')
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
          <h3 class="text-sm font-semibold text-gray-700">Bukti Realisasi</h3>
          @if ($detail['has_bukti_lengkap'])
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full
                                         text-xs font-medium bg-green-100 text-green-700">
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Bukti Lengkap
            </span>
          @else
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full
                                         text-xs font-medium bg-orange-100 text-orange-600">
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01" />
              </svg>
              Bukti Belum Lengkap
            </span>
          @endif
        </div>
        <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-5">

          <div class="border border-gray-100 rounded-lg p-4 bg-gray-50">
            <p class="text-xs text-gray-500 mb-2 font-medium">Manifest Elektronik</p>
            @if ($detail['manifest_url'])
              <a href="{{ $detail['manifest_url'] }}" target="_blank" class="inline-flex items-center gap-2 text-sm text-blue-600
                                           hover:text-blue-800 hover:underline transition-colors duration-150">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0
                                               0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Buka Manifest (PDF)
              </a>
            @else
              <p class="text-sm text-gray-400 italic">Belum ada file</p>
            @endif
          </div>

          <div class="border border-gray-100 rounded-lg p-4 bg-gray-50">
            <p class="text-xs text-gray-500 mb-2 font-medium">Bukti Foto Pengangkutan</p>
            @if ($detail['bukti_foto_url'])
              <a href="{{ $detail['bukti_foto_url'] }}" target="_blank" class="inline-flex items-center gap-2 text-sm text-blue-600
                                           hover:text-blue-800 hover:underline transition-colors duration-150">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2
                                               0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0
                                               00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Buka Foto Bukti
              </a>
            @else
              <p class="text-sm text-gray-400 italic">Belum ada file</p>
            @endif
          </div>

        </div>
      </div>
    @endif

  </div>
</div>