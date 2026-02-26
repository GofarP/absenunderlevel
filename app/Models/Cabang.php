<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $fillable=[
        'nama',
        'lattitude',
        'longitude'
    ];

    public function cabang(){
        return $this->hasMany(Cabang::class,'cabang_id');
    }
}
