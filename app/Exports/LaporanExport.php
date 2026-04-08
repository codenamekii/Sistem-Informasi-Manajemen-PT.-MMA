<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LaporanExport implements
  FromArray,
  WithHeadings,
  WithStyles,
  WithTitle,
  ShouldAutoSize
{
  public function __construct(
    protected array $kolom,
    protected array $hasil,
    protected string $judulLaporan = 'Laporan',
  ) {
  }

  public function array(): array
  {
    // Tambahkan nomor urut di setiap baris
    return array_map(
      fn($i, $baris) => array_merge([$i + 1], $baris),
      array_keys($this->hasil),
      $this->hasil
    );
  }

  public function headings(): array
  {
    return array_merge(['No.'], $this->kolom);
  }

  public function title(): string
  {
    return $this->judulLaporan;
  }

  public function styles(Worksheet $sheet): array
  {
    return [
      // Baris header — background biru, teks putih, bold
      1 => [
        'font' => [
          'bold' => true,
          'color' => ['argb' => 'FFFFFFFF'],
        ],
        'fill' => [
          'fillType' => Fill::FILL_SOLID,
          'startColor' => ['argb' => 'FF1D4ED8'],
        ],
        'alignment' => [
          'horizontal' => Alignment::HORIZONTAL_CENTER,
        ],
      ],
    ];
  }
}