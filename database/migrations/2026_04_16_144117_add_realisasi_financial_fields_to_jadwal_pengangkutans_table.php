<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('jadwal_pengangkutans', function (Blueprint $table) {
      $table->decimal('total_limbah_kg', 12, 2)
        ->nullable()
        ->after('tanggal_realisasi');

      $table->decimal('harga_per_kg_realisasi', 15, 2)
        ->nullable()
        ->after('total_limbah_kg');

      $table->decimal('total_biaya_realisasi', 18, 2)
        ->nullable()
        ->after('harga_per_kg_realisasi');
    });
  }

  public function down(): void
  {
    Schema::table('jadwal_pengangkutans', function (Blueprint $table) {
      $table->dropColumn([
        'total_limbah_kg',
        'harga_per_kg_realisasi',
        'total_biaya_realisasi',
      ]);
    });
  }
};