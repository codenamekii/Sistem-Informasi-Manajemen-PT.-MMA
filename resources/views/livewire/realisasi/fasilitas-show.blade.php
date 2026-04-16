<div>
  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-6">
    <x-page-header title="Riwayat Realisasi per Fasilitas" :description="$summary['nama_fasilitas_display']"
      class="mb-0" />

    <div class="shrink-0">
      <a href="{{ route('realisasi.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium
                       text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50
                       focus:ring-4 focus:ring-gray-200 transition-colors duration-200">
        Kembali
      </a>
    </div>
  </div>

  {{-- Informasi fasilitas --}}
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6">
    <div class="px-6 py-4 border-b border-gray-100">
      <h3 class="text-sm font-semibold text-gray-700">Informasi Fasilitas</h3>
    </div>
    <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
      <div>
        <p class="text-xs text-gray-500 mb-1">Fasilitas Kesehatan</p>
        <p class="text-sm text-gray-800">{{ $summary['nama_fasilitas_display'] }}</p>
      </div>

      <div>
        <p class="text-xs text-gray-500 mb-1">Nomor Perjanjian</p>
        <p class="text-sm text-gray-800">{{ $summary['nomor_perjanjian'] }}</p>
      </div>

      <div>
        <p class="text-xs text-gray-500 mb-1">Harga Kontrak Saat Ini</p>
        <p class="text-sm text-gray-800">{{ $summary['harga_per_kilogram_rupiah'] }}</p>
      </div>

      <div>
        <p class="text-xs text-gray-500 mb-1">Jumlah Realisasi</p>
        <p class="text-sm text-gray-800">{{ $summary['jumlah_realisasi'] }} pengangkutan</p>
      </div>
    </div>
  </div>

  {{-- Summary cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <x-stat-card title="Jumlah Realisasi" :value="$summary['jumlah_realisasi']" description="Total pengangkutan selesai"
      color="blue">
      <x-slot:icon>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </x-slot:icon>
    </x-stat-card>

    <x-stat-card title="Akumulasi Limbah" :value="$summary['total_limbah_kg_display']"
      description="Total kilogram terangkut" color="green">
      <x-slot:icon>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M20 13V7a2 2 0 00-2-2h-3V3H9v2H6a2 2 0 00-2 2v6m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4" />
        </svg>
      </x-slot:icon>
    </x-stat-card>

    <x-stat-card title="Akumulasi Nilai" :value="$summary['total_biaya_realisasi_rupiah']"
      description="Total biaya realisasi" color="yellow">
      <x-slot:icon>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10V6m0 12v-2m9-4a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </x-slot:icon>
    </x-stat-card>
  </div>

  {{-- Riwayat realisasi --}}
  <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
    <div class="px-5 py-4 border-b border-gray-100">
      <h3 class="text-sm font-semibold text-gray-700">Riwayat Pengangkutan Selesai</h3>
      <p class="text-xs text-gray-400 mt-0.5">
        Histori semua realisasi pengangkutan untuk fasilitas ini.
      </p>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-600">
        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
          <tr>
            <th class="px-5 py-3 font-medium">Kode Jadwal</th>
            <th class="px-5 py-3 font-medium">Tgl. Pengangkutan</th>
            <th class="px-5 py-3 font-medium">Tgl. Realisasi</th>
            <th class="px-5 py-3 font-medium">Armada</th>
            <th class="px-5 py-3 font-medium">Petugas</th>
            <th class="px-5 py-3 font-medium">Total Limbah</th>
            <th class="px-5 py-3 font-medium">Harga/Kg</th>
            <th class="px-5 py-3 font-medium">Total Biaya</th>
            <th class="px-5 py-3 font-medium">Bukti</th>
            <th class="px-5 py-3 font-medium text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse ($riwayat as $item)
            <tr class="hover:bg-gray-50 transition-colors duration-150">
              <td class="px-5 py-3 whitespace-nowrap">
                <span class="font-mono text-xs font-medium text-gray-700">
                  {{ $item['kode_jadwal'] }}
                </span>
              </td>

              <td class="px-5 py-3 whitespace-nowrap">{{ $item['tanggal_pengangkutan'] }}</td>
              <td class="px-5 py-3 whitespace-nowrap">{{ $item['tanggal_realisasi'] }}</td>

              <td class="px-5 py-3 whitespace-nowrap">
                <span class="font-mono text-xs text-gray-600">
                  {{ $item['armada_display'] }}
                </span>
              </td>

              <td class="px-5 py-3 max-w-[180px]">
                <span class="block truncate text-sm text-gray-700" title="{{ $item['petugas_display'] }}">
                  {{ $item['petugas_display'] }}
                </span>
              </td>

              <td class="px-5 py-3 whitespace-nowrap">{{ $item['total_limbah_kg_display'] }}</td>
              <td class="px-5 py-3 whitespace-nowrap">{{ $item['harga_per_kg_realisasi_rupiah'] }}</td>
              <td class="px-5 py-3 whitespace-nowrap">{{ $item['total_biaya_realisasi_rupiah'] }}</td>

              <td class="px-5 py-3 whitespace-nowrap">
                @if ($item['has_bukti_lengkap'])
                  <span
                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                    Lengkap
                  </span>
                @else
                  <span
                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-600">
                    Belum Lengkap
                  </span>
                @endif
              </td>

              <td class="px-5 py-3 text-right whitespace-nowrap">
                <a href="{{ route('realisasi.show', $item['id']) }}"
                  class="text-xs font-medium text-blue-600 hover:text-blue-800 transition-colors duration-150">
                  Detail
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="10" class="px-5 py-12 text-center">
                <p class="text-sm text-gray-400">
                  Belum ada realisasi pengangkutan selesai untuk fasilitas ini.
                </p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="px-5 py-3 border-t border-gray-100">
      <p class="text-xs text-gray-400">
        Menampilkan {{ count($riwayat) }} realisasi
      </p>
    </div>
  </div>
</div>