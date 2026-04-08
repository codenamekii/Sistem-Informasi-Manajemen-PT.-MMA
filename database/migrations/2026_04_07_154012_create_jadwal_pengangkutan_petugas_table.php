<?php
// database/migrations/2026_04_07_000002_create_jadwal_pengangkutan_petugas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_pengangkutan_petugas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jadwal_pengangkutan_id')
                ->constrained('jadwal_pengangkutans')
                ->cascadeOnDelete();

            $table->foreignId('petugas_id')
                ->constrained('petugas')
                ->cascadeOnDelete();

            // Mencegah duplikasi kombinasi yang sama
            $table->unique(
                ['jadwal_pengangkutan_id', 'petugas_id'],
                'jadwal_petugas_unique'
            );

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_pengangkutan_petugas');
    }
};
