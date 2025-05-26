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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('users_id');
            $table->bigInteger('jabatan_id')->nullable();
            $table->bigInteger('cabang_id')->nullable();
            $table->bigInteger('shift_id')->nullable();
            $table->bigInteger('gaji_pokok')->nullable();
            $table->bigInteger('lembur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
