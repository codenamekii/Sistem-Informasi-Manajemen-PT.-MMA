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
        Schema::table('fasilitas_kesehatans', function (Blueprint $table) {
            $table->string('provinsi')->nullable()->after('kota_kabupaten');
            $table->enum('status_penawaran', [
                'masuk_penawaran',
                'belum_masuk_penawaran',
            ])->default('belum_masuk_penawaran')->after('provinsi');
            $table->string('pic_nama')->nullable()->after('status_penawaran');
            $table->string('pic_nomor_telepon')->nullable()->after('pic_nama');
            $table->text('kendala')->nullable()->after('pic_nomor_telepon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fasilitas_kesehatans', function (Blueprint $table) {
            $table->dropColumn([
                'provinsi',
                'status_penawaran',
                'pic_nama',
                'pic_nomor_telepon',
                'kendala',
            ]);
        });
    }
};
