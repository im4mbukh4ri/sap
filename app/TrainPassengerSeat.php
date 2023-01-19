<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainPassengerSeat extends Model
{
  public $incrementing=false;
  public $timestamps=false;
  protected $fillable=['train_passanger_id','train_booking_id','train_seat_id'];

  public function passenger(){
    return $this->belongsTo('App\TrainPassenger');
  }
  public function seat(){
    return $this->belongsTo('App\TrainSeat','train_seat_id');
  }
}
