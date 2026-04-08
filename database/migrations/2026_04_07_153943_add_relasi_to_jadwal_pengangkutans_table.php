<?php
// database/migrations/2026_04_07_000001_add_relasi_to_jadwal_pengangkutans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_pengangkutans', function (Blueprint $table) {
            // FK ke KerjaSama — nullable, data lama aman
            $table->foreignId('kerja_sama_id')
                ->nullable()
                ->after('kode_jadwal')
                ->constrained('kerja_samas')
                ->nullOnDelete();

            // FK ke Armada — nullable, kolom armada (string) tetap ada
            $table->foreignId('armada_id')
                ->nullable()
                ->after('kerja_sama_id')
                ->constrained('armadas')
                ->nullOnDelete();

            // Field realisasi dasar — semua nullable
            $table->date('tanggal_realisasi')
                ->nullable()
                ->after('status');

            $table->string('manifest_elektronik_path')
                ->nullable()
                ->after('tanggal_realisasi');

            $table->string('bukti_foto_pengangkutan_path')
                ->nullable()
                ->after('manifest_elektronik_path');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_pengangkutans', function (Blueprint $table) {
            $table->dropForeign(['kerja_sama_id']);
            $table->dropForeign(['armada_id']);
            $table->dropColumn([
                'kerja_sama_id',
                'armada_id',
                'tanggal_realisasi',
                'manifest_elektronik_path',
                'bukti_foto_pengangkutan_path',
            ]);
        });
    }
};
