<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainCommission extends Model
{
    //
    protected $fillable=['train_booking_id','nra','komisi','free','pusat','bv','member','upline'];
    public function booking(){
      return $this->belongsTo('App\TrainBooking');
    }
}
