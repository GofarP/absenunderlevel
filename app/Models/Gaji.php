<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $fillable=[
        'karyawan_id',
        'absensi_id',
        'gaji_harian',
        'lembur',
    ];

    public function karyawan(){
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function absensi(){
        return $this->belongsTo(Absensi::class,'absensi_id');
     }
}
