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
        Schema::table('karyawans', function (Blueprint $table) {
            // Tambahkan pengecekan agar tidak error jika kolom sudah tidak ada
            if (Schema::hasColumn('karyawans', 'cabang_id')) {
                $table->dropColumn('cabang_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            // Tambahkan pengecekan agar tidak error jika kolom sudah ada saat rollback
            if (!Schema::hasColumn('karyawans', 'cabang_id')) {
                $table->unsignedBigInteger('cabang_id')->nullable();
            }
        });
    }
};
