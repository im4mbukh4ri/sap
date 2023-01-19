<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentPassenger extends Model
{
    //
    protected $fillable=['passenger_id','type','number','expired','nationality_id','issued_country_id','birth_date'];

    public function passenger(){
        return $this->belongsTo('App\Passenger');
    }
}
