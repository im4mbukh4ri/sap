<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    //
    protected $fillable=['id','name','city','international'];
    public $incrementing=false;
    protected $hidden=['created_at','updated_at','deleted_at', 'windows_timezone'];
    public function origin_booking(){
        return $this->belongsTo('App\AirlinesBooking');
    }
    public function destination_booking(){
        return $this->belongsTo('App\AirlinesBooking');
    }
}
