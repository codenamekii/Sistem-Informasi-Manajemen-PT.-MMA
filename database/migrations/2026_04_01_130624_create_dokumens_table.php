<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen');
            $table->string('kategori_dokumen');
            $table->string('nomor_referensi')->nullable();
            $table->string('terkait_dengan');
            $table->date('tanggal_berlaku_sampai')->nullable();
            $table->enum('status', ['valid', 'expiring_soon', 'expired', 'missing'])
                ->default('valid');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
