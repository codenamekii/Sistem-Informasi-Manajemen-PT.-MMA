<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>{{ $judul }} — PT. Mitra Mecca Abadi</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'DejaVu Sans', Arial, sans-serif;
      font-size: 10px;
      color: #1f2937;
      background: #fff;
      padding: 20px 24px;
    }

    .kop {
      border-bottom: 2px solid #1d4ed8;
      padding-bottom: 10px;
      margin-bottom: 14px;
    }

    .kop-nama {
      font-size: 13px;
      font-weight: bold;
      color: #1d4ed8;
    }

    .kop-sub {
      font-size: 9px;
      color: #6b7280;
      margin-top: 2px;
    }

    .judul {
      font-size: 12px;
      font-weight: bold;
      color: #111827;
      margin-top: 14px;
      margin-bottom: 3px;
    }

    .meta {
      font-size: 9px;
      color: #6b7280;
      margin-bottom: 10px;
    }

    .filter-box {
      background: #f0f9ff;
      border: 1px solid #bae6fd;
      border-radius: 3px;
      padding: 6px 10px;
      margin-bottom: 12px;
      font-size: 9px;
      color: #0369a1;
    }

    .filter-box strong {
      color: #0c4a6e;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 9px;
    }

    thead tr {
      background-color: #1d4ed8;
      color: #fff;
    }

    thead th {
      padding: 6px 8px;
      text-align: left;
      font-weight: bold;
      white-space: nowrap;
    }

    tbody tr:nth-child(even) {
      background-color: #f9fafb;
    }

    tbody td {
      padding: 5px 8px;
      border-bottom: 1px solid #e5e7eb;
      vertical-align: top;
    }

    .total {
      margin-top: 10px;
      font-size: 9px;
      color: #374151;
      font-style: italic;
    }

    .footer {
      margin-top: 14px;
      padding-top: 8px;
      border-top: 1px solid #e5e7eb;
      font-size: 9px;
      color: #9ca3af;
    }

    .footer-inner {
      display: table;
      width: 100%;
    }

    .footer-left {
      display: table-cell;
      text-align: left;
    }

    .footer-right {
      display: table-cell;
      text-align: right;
    }
  </style>
</head>

<body>

  <div class="kop">
    <div class="kop-nama">PT. Mitra Mecca Abadi</div>
    <div class="kop-sub">Sistem Manajemen Internal — Laporan Operasional</div>
  </div>

  <div class="judul">{{ $judul }}</div>
  <div class="meta">
    Dicetak pada: {{ now()->locale('id')->isoFormat('dddd, D MMMM Y — HH:mm') }} WIB
  </div>

  @if (!empty($filter))
    <div class="filter-box">
      <strong>Filter:</strong> {{ $filter }}
    </div>
  @endif

  <table>
    <thead>
      <tr>
        <th style="width:26px; text-align:center;">No.</th>
        @foreach ($kolom as $header)
          <th>{{ $header }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @forelse ($hasil as $i => $baris)
        <tr>
          <td style="text-align:center;">{{ $i + 1 }}</td>
          @foreach ($baris as $sel)
            <td>{{ $sel }}</td>
          @endforeach
        </tr>
      @empty
        <tr>
          <td colspan="{{ count($kolom) + 1 }}"
            style="text-align:center; padding:16px; color:#9ca3af; font-style:italic;">
            Tidak ada data
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <div class="total">Total: {{ count($hasil) }} baris data</div>

  <div class="footer">
    <div class="footer-inner">
      <div class="footer-left">PT. Mitra Mecca Abadi — Dokumen Internal</div>
      <div class="footer-right">{{ now()->format('d/m/Y H:i') }}</div>
    </div>
  </div>

</body>

</html>