<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PassengerPhone extends Model
{
    //
    protected $fillable=['passenger_id','number'];

    public $timestamps=false;

    public function passenger(){
        return $this->belongsTo('App\Passenger');
    }
}
