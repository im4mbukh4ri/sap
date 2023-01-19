<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelAgent extends Model
{
    //
    protected $fillable=['user_id','name','address_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function address(){
        return $this->belongsTo('App\Address');
    }
}
