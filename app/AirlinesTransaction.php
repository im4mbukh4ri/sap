<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirlinesTransaction extends Model
{
    //
    protected $fillable=['id','user_id','buyyer_id','trip_type_id','adt','chd','inf','total_fare','status','expired','device', 'bookable', 'international'];
    protected $appends=['status','origin','destination','airlines_code','pnr','passengers','commission', 'first_flight_number'];
    /*
     * false for incrementing
     * @var $incrementing
     */
    public $incrementing=false;
    protected $hidden=['deleted_at','passengers','user','bookings','buyer','itineraries'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function buyer()
    {
        return $this->belongsTo('App\Buyer');
    }
    public function trip_type()
    {
        return $this->belongsTo('App\TripType');
    }
    public function bookings()
    {
        return $this->hasMany('App\AirlinesBooking');
    }
    public function passengers()
    {
        return $this->hasMany('App\Passenger');
    }
    /*
     * Function di bawah ini yang menyebabkan execution time lebih banyak
     */
    public function getStatusAttribute()
    {
        return $this->bookings()->first()->status;
    }
    public function getOriginAttribute()
    {
        return $this->bookings()->first()->origin;
    }
    public function getDestinationAttribute()
    {
        return $this->bookings()->first()->destination;
    }
    public function getAirlinesCodeAttribute()
    {
        return $this->bookings()->first()->airlines_code;
    }
    public function getPassengersAttribute()
    {
        return $this->passengers()->get();
    }
    public function getPnrAttribute()
    {
        $pnr=$this->bookings()->first()->itineraries()->first();
        if ($pnr) {
            return $pnr->pnr;
        }
        return "######";
    }
    public function getCommissionAttribute()
    {
        $commissionBv=array();
        $commissionMember=array();
        foreach ($this->bookings as $booking) {
            if (isset($booking->transaction_commission)) {
                $commissionBv[]=$booking->transaction_commission->bv;
                $commissionMember[]=$booking->transaction_commission->member;
            } else {
                $commissionBv[]=0;
                $commissionMember[]=0;
            }
        }
        $bv=collect($commissionBv)->sum();
        $member=collect($commissionMember)->sum();
        $response=[
            'bv'=>$bv,
            'member'=>$member
        ];
        return $response;
    }
    public function itineraries()
    {
        return $this->hasManyThrough('App\AirlinesItinerary', 'App\AirlinesBooking', 'airlines_transaction_id', 'airlines_booking_id', 'id', 'id');
    }
    public function getFirstFlightNumberAttribute()
    {
        if($this->itineraries->count() > 0){
          return $this->itineraries->first()->flight_number;
        }
        return '';

    }
//    public function getBookingAttribute(){
//        return $this->bookings;
//    }
}
