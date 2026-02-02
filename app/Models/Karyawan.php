<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;
    protected $fillable=[
        'users_id',
        'jabatan_id',
        'cabang_id',
        'shift_id',
        'gaji_pokok',
    ];

    public function users(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function jabatan(){
        return $this->belongsTo(Jabatan::class,'jabatan_id');
    }

    public function cabang(){
        return $this->belongsTo(Cabang::class,'cabang_id');
    }

    public function shift(){
        return $this->belongsTo(Shift::class,'shift_id');
    }

    public function gaji(){
        return $this->hasMany(Gaji::class, 'karyawan_id');
    }

    public function statusabsensi(){
        return $this->belongsTo(StatusAbsensi::class,'status_absensi_id');
    }




}
