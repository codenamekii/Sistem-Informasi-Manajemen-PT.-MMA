<div x-data="{}" x-on:do-print.window="window.print()">

  {{-- Print CSS — hanya tabel yang tercetak --}}
  <style>
    @media print {

      body>div>aside,
      body>div>div>header,
      body>div>div>footer,
      [wire\:id]>div>.print-hidden {
        display: none !important;
      }

      .print-area {
        display: block !important;
      }

      body {
        background: #fff !important;
        font-size: 11px;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
      }

      thead {
        background-color: #1d4ed8 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }

      thead th {
        color: #fff !important;
        padding: 6px 8px;
        text-align: left;
        font-weight: bold;
      }

      tbody td {
        padding: 5px 8px;
        border-bottom: 1px solid #e5e7eb;
      }

      tbody tr:nth-child(even) {
        background-color: #f9fafb !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }

      .print-header {
        display: block !important;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid #1d4ed8;
      }

      .print-header .nama-perusahaan {
        font-size: 14px;
        font-weight: bold;
        color: #1d4ed8;
      }

      .print-judul {
        font-size: 13px;
        font-weight: bold;
        margin: 12px 0 4px;
      }

      .print-meta {
        font-size: 10px;
        color: #6b7280;
        margin-bottom: 12px;
      }
    }

    @media screen {
      .print-header {
        display: none;
      }
    }
  </style>

  {{-- Print header — hanya muncul saat print --}}
  <div class="print-header">
    <div class="nama-perusahaan">PT. Mitra Mecca Abadi</div>
    <div style="font-size:10px; color:#6b7280;">Sistem Manajemen Internal — Laporan Operasional</div>
    <div class="print-judul">
      @php
        $judulPrint = match ($jenisLaporan) {
          'fasilitas_kesehatan' => 'Fasilitas Kesehatan',
          'kerja_sama_aktif' => 'Kerja Sama Aktif',
          'kontrak_habis' => 'Kontrak Akan Berakhir',
          'dokumen_expired' => 'Dokumen Expired / Segera Expired',
          'jadwal_harian' => 'Jadwal Pengangkutan',
          'realisasi_pengangkutan' => 'Realisasi Pengangkutan',
          'armada' => 'Armada',
          'petugas' => 'Petugas',
          default => 'Laporan',
        };
      @endphp
      {{ $judulPrint }}
    </div>
    <div class="print-meta">Dicetak: {{ now()->format('d/m/Y H:i') }} WIB &nbsp;|&nbsp; Total: {{ count($hasil) }} baris
    </div>
  </div>

  {{-- Konten halaman normal (bukan print) --}}
  <div class="print-hidden">
    <x-page-header title="Laporan" description="Pilih jenis laporan dan filter yang diinginkan, lalu klik Tampilkan." />
  </div>

  {{-- Panel Filter --}}
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-5 print-hidden">
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">

      {{-- Selector jenis laporan --}}
      <div class="sm:col-span-2 xl:col-span-3">
        <label class="block mb-2 text-sm font-medium text-gray-700">
          Jenis Laporan <span class="text-red-500">*</span>
        </label>
        <select wire:model.live="jenisLaporan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
          @foreach ($jenisOptions as $val => $label)
            <option value="{{ $val }}">{{ $label }}</option>
          @endforeach
        </select>
      </div>

      {{-- Filter tanggal --}}
      @if (in_array($jenisLaporan, ['kerja_sama_aktif', 'jadwal_harian', 'realisasi_pengangkutan']))
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Tanggal Dari</label>
          <input type="date" wire:model="filterTanggalDari" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
        </div>
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Tanggal Sampai</label>
          <input type="date" wire:model="filterTanggalSampai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
        </div>
      @endif

      {{-- Filter hari kontrak --}}
      @if ($jenisLaporan === 'kontrak_habis')
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">
            Tampilkan kontrak berakhir dalam
          </label>
          <select wire:model="filterHari" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="14">14 hari ke depan</option>
            <option value="30">30 hari ke depan</option>
            <option value="60">60 hari ke depan</option>
            <option value="90">90 hari ke depan</option>
          </select>
        </div>
      @endif

      {{-- Filter status fasilitas --}}
      @if ($jenisLaporan === 'fasilitas_kesehatan')
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Status</label>
          <select wire:model="filterStatus" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
          </select>
        </div>
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Provinsi</label>
          <input type="text" wire:model="filterProvinsi" placeholder="Contoh: Sulawesi Selatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
        </div>
      @endif

      {{-- Filter status dokumen --}}
      @if ($jenisLaporan === 'dokumen_expired')
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Filter Status</label>
          <select wire:model="filterStatus" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="">Expired + Segera Expired</option>
            <option value="expired">Hanya Expired</option>
          </select>
        </div>
      @endif

      {{-- Filter status jadwal --}}
      @if ($jenisLaporan === 'jadwal_harian')
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Status Jadwal</label>
          <select wire:model="filterStatus" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="">Semua Status</option>
            <option value="draft">Draft</option>
            <option value="scheduled">Terjadwal</option>
            <option value="in_progress">Berlangsung</option>
            <option value="completed">Selesai</option>
            <option value="cancelled">Dibatalkan</option>
          </select>
        </div>
      @endif

      {{-- Filter status armada --}}
      @if ($jenisLaporan === 'armada')
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Status Armada</label>
          <select wire:model="filterStatus" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
          </select>
        </div>
      @endif

      {{-- Filter status petugas --}}
      @if ($jenisLaporan === 'petugas')
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Status Petugas</label>
          <select wire:model="filterStatus" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
          </select>
        </div>
      @endif

    </div>

    {{-- Tombol generate --}}
    <div class="flex items-center justify-end mt-5 pt-4 border-t border-gray-100">
      @if ($jenisLaporan !== '')
        <button wire:click="generate" wire:loading.attr="disabled" wire:target="generate" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white
                               bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
                               transition-colors duration-200 disabled:opacity-60">
          <svg wire:loading.remove wire:target="generate" class="w-4 h-4" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586
                                   a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <svg wire:loading wire:target="generate" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
          </svg>
          <span wire:loading.remove wire:target="generate">Tampilkan Laporan</span>
          <span wire:loading wire:target="generate">Memuat...</span>
        </button>
      @else
        <span class="text-sm text-gray-400 italic">Pilih jenis laporan terlebih dahulu.</span>
      @endif
    </div>
  </div>

  {{-- Area Preview --}}
  @if ($jenisLaporan !== '' && $sudahCari)
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">

      {{-- Header preview --}}
      <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 print-hidden">
        <div>
          <h3 class="text-sm font-semibold text-gray-700">Hasil Laporan</h3>
          <p class="text-xs text-gray-400 mt-0.5">
            Menampilkan {{ count($hasil) }} baris data
          </p>
        </div>
        <div class="flex items-center gap-2">

          {{-- Export Excel --}}
          @if (count($hasil) > 0)
            <button wire:click="exportExcel" wire:loading.attr="disabled" wire:target="exportExcel" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium
                                           text-green-700 bg-green-50 border border-green-300 rounded-lg
                                           hover:bg-green-100 focus:ring-2 focus:ring-green-200
                                           transition-colors duration-150 disabled:opacity-60">
              <svg wire:loading.remove wire:target="exportExcel" class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
              </svg>
              <svg wire:loading wire:target="exportExcel" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
              </svg>
              <span wire:loading.remove wire:target="exportExcel">Excel</span>
              <span wire:loading wire:target="exportExcel">Mengekspor...</span>
            </button>

            {{-- Export PDF --}}
            <button wire:click="exportPdf" wire:loading.attr="disabled" wire:target="exportPdf" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium
                                           text-red-700 bg-red-50 border border-red-300 rounded-lg
                                           hover:bg-red-100 focus:ring-2 focus:ring-red-200
                                           transition-colors duration-150 disabled:opacity-60">
              <svg wire:loading.remove wire:target="exportPdf" class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0
                                               0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
              </svg>
              <svg wire:loading wire:target="exportPdf" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
              </svg>
              <span wire:loading.remove wire:target="exportPdf">PDF</span>
              <span wire:loading wire:target="exportPdf">Mengekspor...</span>
            </button>

            {{-- Cetak --}}
            <button wire:click="cetakLaporan" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium
                                           text-gray-700 bg-gray-50 border border-gray-300 rounded-lg
                                           hover:bg-gray-100 focus:ring-2 focus:ring-gray-200
                                           transition-colors duration-150">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0
                                               002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0
                                               002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
              </svg>
              Cetak
            </button>
          @else
            <span class="text-xs text-gray-300 cursor-not-allowed
                                             border border-gray-200 rounded-lg px-3 py-1.5">Excel</span>
            <span class="text-xs text-gray-300 cursor-not-allowed
                                             border border-gray-200 rounded-lg px-3 py-1.5">PDF</span>
            <span class="text-xs text-gray-300 cursor-not-allowed
                                             border border-gray-200 rounded-lg px-3 py-1.5">Cetak</span>
          @endif

        </div>
      </div>

      {{-- Tabel --}}
      @if (count($hasil) > 0)
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
              <tr>
                <th class="px-4 py-3 font-medium w-10">#</th>
                @foreach ($kolom as $header)
                  <th class="px-4 py-3 font-medium whitespace-nowrap">
                    {{ $header }}
                  </th>
                @endforeach
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              @foreach ($hasil as $i => $baris)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                  <td class="px-4 py-3 text-xs text-gray-400">{{ $i + 1 }}</td>
                  @foreach ($baris as $sel)
                    <td class="px-4 py-3 text-sm text-gray-700 max-w-[200px]">
                      <span class="block truncate" title="{{ $sel }}">
                        {{ $sel }}
                      </span>
                    </td>
                  @endforeach
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="px-5 py-3 border-t border-gray-100 print-hidden">
          <p class="text-xs text-gray-400">Total: {{ count($hasil) }} baris</p>
        </div>
      @else
        <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
          <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-4">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586
                                           a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <p class="text-sm font-medium text-gray-500">Tidak ada data ditemukan</p>
          <p class="text-xs text-gray-400 mt-1">Coba ubah filter dan tampilkan ulang.</p>
        </div>
      @endif

    </div>

  @elseif ($jenisLaporan === '' && !$sudahCari)
    <div class="bg-white border border-dashed border-gray-300 rounded-xl print-hidden">
      <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
        <div class="flex items-center justify-center w-14 h-14 bg-blue-50 rounded-full mb-4">
          <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586
                                   a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
        </div>
        <p class="text-sm font-medium text-gray-500">Pilih jenis laporan di atas</p>
        <p class="text-xs text-gray-400 mt-1">
          Filter dan pratinjau data akan muncul sesuai jenis laporan yang dipilih.
        </p>
      </div>
    </div>
  @endif

</div>