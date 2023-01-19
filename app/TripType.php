<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TripType extends Model
{
    //
    protected $fillable=['id','name'];
    public $timestamps=false;
    public $incrementing=false;

    public function airlines_transaction(){
        return $this->hasMany('App\AirlinesTransaction');
    }
}
