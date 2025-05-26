<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusAbsensi extends Model
{
    protected $fillable = [
        'nama'
    ];

    public function absensi(){
        return $this->hasMany(StatusAbsensi::class, 'status_absensi_id');
     }

     public function karyawan(){
        return $this->hasMany(Karyawan::class,'status_absensi_id');
    }
}
