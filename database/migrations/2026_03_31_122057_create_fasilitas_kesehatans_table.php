<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_kesehatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis_fasilitas');
            $table->string('kota_kabupaten');
            $table->enum('status', ['prospect', 'active', 'inactive'])->default('prospect');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_kesehatans');
    }
};
