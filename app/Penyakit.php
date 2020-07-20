<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasApiTokens, Notifiable;

    protected $guarded = [];

    public function rules(){
        return $this->hasMany(Rule::class, 'penyakit_code', 'kode');
    }
}
