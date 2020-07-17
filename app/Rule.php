<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasApiTokens, Notifiable;

    protected $guarded = [];

    public function penyakit(){
        return $this->belongsTo(Penyakit::class,'penyakit_code', 'kode');
    }

    public function gejala(){
        return $this->belongsTo(Gejala::class,'gejala_code', 'kode');
    }
}
