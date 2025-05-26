<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable=['nama','mulai_dari','sampai_dengan'];

    public function karyawan(){
        return $this->hasMany(Karyawan::class,'shift_id');
    }

    public function absensi(){
        return $this->hasMany(Shift::class,'shift_id');
     }
}
