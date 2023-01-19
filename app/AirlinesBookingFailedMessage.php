<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirlinesBookingFailedMessage extends Model
{
    //
    protected $fillable=['airlines_booking_id','message'];
    public $timestamps = false;

    public function booking(){
        return $this->belongsTo('App\AirlinesBooking');
    }
}
