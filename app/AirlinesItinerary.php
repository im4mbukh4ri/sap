<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirlinesItinerary extends Model
{
    //
    protected $fillable=['airlines_booking_id','depart_return_id','pnr','leg','flight_number','class','std','sta','etd','eta','stop'];
    protected $hidden=['created_at','updated_at'];
    public function booking()
    {
        return $this->belongsTo('App\AirlinesBooking', 'airlines_booking_id');
    }
    public function origin()
    {
        return $this->belongsTo('App\Airport', 'std');
    }
    public function destination()
    {
        return $this->belongsTo('App\Airport', 'sta');
    }
}
