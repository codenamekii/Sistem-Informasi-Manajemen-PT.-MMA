<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->string('role', 50)
        ->default('admin_operasional')
        ->after('email')
        ->comment('super_admin|admin_operasional|koordinator_operasional|petugas_lapangan|manajer_operasional|direktur');
    });
  }

  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('role');
    });
  }
};