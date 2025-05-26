<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('absensi/laporanabsensi', [\App\Http\Controllers\AbsensiController::class,'laporanAbsensi'])->name('absensi.laporanabsensi');
Route::get('gaji/laporangaji', [\App\Http\Controllers\GajiController::class,'laporanGaji'])->name('gaji.laporangaji');

Route::resource('karyawan', \App\Http\Controllers\KaryawanController::class);
Route::resource('jabatan', \App\Http\Controllers\JabatanController::class);
Route::resource('statusabsensi', \App\Http\Controllers\StatusAbsensiController::class);
Route::resource('absensi', \App\Http\Controllers\AbsensiController::class);
Route::resource('cabang', \App\Http\Controllers\CabangController::class);
Route::resource('shift', \App\Http\Controllers\ShiftController::class);


Route::post('absensi/print', [\App\Http\Controllers\AbsensiController::class,'print'])->name('absensi.print');
Route::post('gaji/print', [\App\Http\Controllers\GajiController::class,'print'])->name('gaji.print');
