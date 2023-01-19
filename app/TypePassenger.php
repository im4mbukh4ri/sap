<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypePassenger extends Model
{
    //
    protected $fillable=['id','name'];

    public $timestamps=false;

    public function passengers(){
        return $this->hasMany('App\Passenger');
    }
}
