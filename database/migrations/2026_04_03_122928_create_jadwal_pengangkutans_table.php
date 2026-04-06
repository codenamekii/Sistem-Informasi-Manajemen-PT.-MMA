<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal_pengangkutans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jadwal', 50)->unique();
            $table->date('tanggal_pengangkutan')->index();
            $table->string('nama_fasilitas');
            $table->string('armada', 100);
            $table->string('petugas_pic', 100);
            $table->enum('status', [
                'draft',
                'scheduled',
                'in_progress',
                'completed',
                'cancelled',
            ])->default('draft')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pengangkutans');
    }
};
