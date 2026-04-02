<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kerja_samas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_perjanjian')->unique();
            $table->string('nama_fasilitas_kesehatan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->enum('status', ['draft', 'active', 'expired', 'terminated'])
                ->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kerja_samas');
    }
};
