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
        Schema::table('absensis', function (Blueprint $table) {
            // This changes the 'lembur' column to allow NULL values
            $table->string('lembur')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            // This reverts the column to NOT NULL
            // Note: Ensure your existing data doesn't have NULLs before rolling back!
            $table->string('lembur')->nullable(false)->change();
        });
    }
};
