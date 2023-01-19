<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RailinkBookingTransactionNumber extends Model
{
  protected $fillable=['train_booking_id','transaction_number'];
  public $timestamps=false;
  public function booking(){
    return $this->belongsTo('App\TrainBooking');
  }
}
