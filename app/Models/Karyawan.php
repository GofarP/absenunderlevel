<?php

namespace App\Models;

use App\Models\Jabatan;
use App\Models\Shift;
use App\Models\StatusAbsensi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $fillable=[
        'nip',
        'users_id',
        'jabatan_id',
        'shift_id',
        'gaji_pokok',
    ];

    public function users(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function jabatan(){
        return $this->belongsTo(Jabatan::class,'jabatan_id');
    }


    public function shift(){
        return $this->belongsTo(Shift::class,'shift_id');
    }

    public function statusabsensi(){
        return $this->belongsTo(StatusAbsensi::class,'status_absensi_id');
    }

}
