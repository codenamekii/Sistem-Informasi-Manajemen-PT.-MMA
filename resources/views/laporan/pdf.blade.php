<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $judul }} — PT. Mitra Mecca Abadi</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'DejaVu Sans', Arial, sans-serif;
      font-size: 11px;
      color: #1f2937;
      background: #fff;
      padding: 24px;
    }

    .header {
      border-bottom: 2px solid #1d4ed8;
      padding-bottom: 12px;
      margin-bottom: 16px;
    }

    .header .perusahaan {
      font-size: 14px;
      font-weight: bold;
      color: #1d4ed8;
    }

    .header .alamat {
      font-size: 10px;
      color: #6b7280;
      margin-top: 2px;
    }

    .judul-laporan {
      font-size: 13px;
      font-weight: bold;
      color: #111827;
      margin-top: 16px;
      margin-bottom: 4px;
    }

    .meta {
      font-size: 10px;
      color: #6b7280;
      margin-bottom: 12px;
    }

    .filter-info {
      background: #f0f9ff;
      border: 1px solid #bae6fd;
      border-radius: 4px;
      padding: 8px 12px;
      margin-bottom: 14px;
      font-size: 10px;
      color: #0369a1;
    }

    .filter-info strong {
      color: #0c4a6e;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 10px;
    }

    thead tr {
      background-color: #1d4ed8;
      color: #fff;
    }

    thead th {
      padding: 7px 10px;
      text-align: left;
      font-weight: bold;
      white-space: nowrap;
    }

    tbody tr:nth-child(even) {
      background-color: #f9fafb;
    }

    tbody tr:hover {
      background-color: #eff6ff;
    }

    tbody td {
      padding: 6px 10px;
      border-bottom: 1px solid #e5e7eb;
      vertical-align: top;
    }

    .footer {
      margin-top: 16px;
      padding-top: 8px;
      border-top: 1px solid #e5e7eb;
      font-size: 10px;
      color: #9ca3af;
      display: flex;
      justify-content: space-between;
    }

    .total-baris {
      font-size: 10px;
      color: #374151;
      margin-top: 10px;
      font-style: italic;
    }
  </style>
</head>

<body>

  {{-- Kop --}}
  <div class="header">
    <div class="perusahaan">PT. Mitra Mecca Abadi</div>
    <div class="alamat">Sistem Manajemen Internal — Laporan Operasional</div>
  </div>

  {{-- Judul laporan --}}
  <div class="judul-laporan">{{ $judul }}</div>
  <div class="meta">
    Dicetak pada: {{ now()->locale('id')->translatedFormat('l, d F Y — H:i') }} WIB
  </div>

  {{-- Ringkasan filter --}}
  @if (!empty($filter))
    <div class="filter-info">
      <strong>Filter aktif:</strong> {{ $filter }}
    </div>
  @endif

  {{-- Tabel data --}}
  <table>
    <thead>
      <tr>
        <th style="width:30px;">No.</th>
        @foreach ($kolom as $header)
          <th>{{ $header }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @forelse ($hasil as $i => $baris)
        <tr>
          <td>{{ $i + 1 }}</td>
          @foreach ($baris as $sel)
            <td>{{ $sel }}</td>
          @endforeach
        </tr>
      @empty
        <tr>
          <td colspan="{{ count($kolom) + 1 }}"
            style="text-align:center; padding:20px; color:#9ca3af; font-style:italic;">
            Tidak ada data
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <div class="total-baris">Total: {{ count($hasil) }} baris data</div>

  {{-- Footer --}}
  <div class="footer">
    <span>PT. Mitra Mecca Abadi — Dokumen Internal</span>
    <span>{{ now()->format('d/m/Y H:i') }}</span>
  </div>

</body>

</html>