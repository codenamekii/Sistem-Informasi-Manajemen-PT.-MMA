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
        Schema::table('kerja_samas', function (Blueprint $table) {
            $table->foreignId('fasilitas_kesehatan_id')
                ->nullable()
                ->after('nomor_perjanjian')
                ->constrained('fasilitas_kesehatans')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->decimal('harga_per_kilogram', 15, 2)
                ->nullable()
                ->after('fasilitas_kesehatan_id');

            $table->unique('fasilitas_kesehatan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kerja_samas', function (Blueprint $table) {
            $table->dropUnique('kerja_samas_fasilitas_kesehatan_id_unique');
            $table->dropForeign(['fasilitas_kesehatan_id']);
            $table->dropColumn([
                'fasilitas_kesehatan_id',
                'harga_per_kilogram',
            ]);
        });
    }
};
