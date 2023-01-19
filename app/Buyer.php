<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    //
    protected $fillable=['name','email','phone'];
    protected $hidden=['id','created_at','updated_at','deleted_at'];
    public function airlinesTransaction(){
        return $this->hasOne('App\AirlinesTransaction');
    }
    public function trainTransaction(){
      return $this->hasOne('App\TrainTransaction');
    }
}
