<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
     protected $fillable=[
        'users_id',
        'status_absensi_id',
        'shift_id',
        'foto',
        'jenis_absensi_id',
     ];

     public function users(){
        return $this->belongsTo(User::class, 'users_id');
     }

     public function statusabsensi(){
        return $this->belongsTo(StatusAbsensi::class, 'status_absensi_id');
     }

     public function shift(){
        return $this->belongsTo(Shift::class,'shift_id');
     }

     public function gaji(){
        return $this->hasMany(Gaji::class,'absensi_id');
     }

     public function jenisabsensi(){
        return $this->belongsTo(JenisAbsensi::class,'jenis_absensi_id');
     }
}
