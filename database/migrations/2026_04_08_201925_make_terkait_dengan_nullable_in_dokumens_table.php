<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('dokumens', function (Blueprint $table) {
      $table->string('terkait_dengan')->nullable()->change();
    });
  }

  public function down(): void
  {
    Schema::table('dokumens', function (Blueprint $table) {
      $table->string('terkait_dengan')->nullable(false)->change();
    });
  }
};