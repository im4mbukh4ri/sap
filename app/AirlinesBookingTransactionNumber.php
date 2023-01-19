<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirlinesBookingTransactionNumber extends Model
{
    //
    protected $fillable=['airlines_booking_id','transaction_number'];
    public $timestamps=false;

    public function booking(){
        return $this->belongsTo('App\AirlinesBooking');
    }
}
