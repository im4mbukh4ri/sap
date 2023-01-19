<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainTransaction extends Model
{
    protected $fillable=['id','user_id','buyer_id','sip_service_id','trip_type_id','adt',
      'chd','inf','total_fare','device'];
    protected $hidden=['user_id','buyer_id','deleted_at','bookings','user'];
    protected $appends=['booking', 'market_price', 'smart_price'];
    public $incrementing=false;

    public function bookings(){
      if($this->sip_service_id===3){
        return $this->hasMany('App\TrainBooking','train_transaction_id');
      }
      return $this->hasMany('App\RailinkBooking','train_transaction_id');
    }
    public function getBookingAttribute(){
      return $this->bookings;
    }
    public function passengers(){
      return $this->hasMany('App\TrainPassenger','train_transaction_id');
    }
    public function user(){
      return $this->belongsTo('App\User');
    }
    public function buyer(){
      return $this->belongsTo('App\Buyer');
    }
    public function sip_service(){
      return $this->belongsTo('App\SipService');
    }
    public function getMarketPriceAttribute()
    {
      $bookings = $this->bookings;
      $marketPrice = 0;
      foreach($bookings as $booking) {
        $marketPrice += $booking->paxpaid + $booking->admin;
      }
      return $marketPrice;
    }

    public function getSmartPriceAttribute()
    {
      $bookings = $this->bookings;
      $smartPrice = 0;
      foreach($bookings as $booking) {
        $commission = 0;
        if( $booking->commission ) {
          $commission = $booking->commission->member;
        }
        $smartPrice += $booking->paxpaid + $booking->admin - $commission ;
      }
      return $smartPrice;
    }

}
