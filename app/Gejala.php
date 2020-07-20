<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasApiTokens, Notifiable;

    protected $guarded = [];

    public function rules(){
        return $this->hasMany(Rule::class, 'gejala_code');
    }

    public function penyakits(){
        return $this->hasMany(Penyakit::class, 'penyakit_code');
    }
}
