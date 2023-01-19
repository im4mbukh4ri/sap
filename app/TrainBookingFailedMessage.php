<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainBookingFailedMessage extends Model
{
    protected $fillable=['train_booking_id','message'];
    public $timestamps = false;
    public function booking(){
      return $this->belongsTo('App\TrainBooking');
    }
}
