<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('armadas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_armada')->unique();
            $table->string('nomor_polisi')->unique();
            $table->string('jenis_kendaraan');
            $table->string('kapasitas');
            $table->enum('status', ['available', 'in_use', 'maintenance', 'inactive'])
                ->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('armadas');
    }
};
