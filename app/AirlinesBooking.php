<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirlinesBooking extends Model
{
    //
    protected $table = 'airlines_booking';
    protected $fillable = [
        'airlines_transaction_id', 'transaction_number', 'airlines_code', 'origin', 'destination', 'paxpaid', 'status',
        'nta', 'nra', 'pr'
    ];
    protected $appends = ['departure_date', 'return_date', 'departure_etd', 'departure_eta', 'return_etd', 'return_eta', 'market_price', 'smart_price'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'airlines_transaction'];

    public function transaction()
    {
        return $this->belongsTo('App\AirlinesTransaction', 'airlines_transaction_id');
    }
    public function origin()
    {
        return $this->belongsTo('App\Airport');
    }
    public function destination()
    {
        return $this->belongsTo('App\Airport');
    }
    public function origin_source()
    {
        return $this->belongsTo('App\Airport', 'origin');
    }
    public function destination_source()
    {
        return $this->belongsTo('App\Airport', 'destination');
    }
    public function itineraries()
    {
        return $this->hasMany('App\AirlinesItinerary');
    }
    public function airlines_transaction()
    {
        return $this->belongsTo('App\AirlinesTransaction');
    }

    public function transaction_commission()
    {
        return $this->hasOne('App\AirlinesCommission');
    }

    public function transaction_number()
    {
        return $this->hasOne('App\AirlinesBookingTransactionNumber');
    }

    public function airline()
    {
        return $this->belongsTo('App\AirlinesCode', 'airlines_code');
    }

    public function failed_message()
    {
        return $this->hasOne('App\AirlinesBookingFailedMessage');
    }

    public function getEtdDep()
    {
        if (isset($this->itineraries->where('depart_return_id', 'd')->first()->etd)) {
            return $this->itineraries->where('depart_return_id', 'd')->first()->etd;
        }
        //return $this->itineraries->where('depart_return_id','d')->first()->etd;
        return "0000-00-00 00:00:00";
    }
    public function getEtdRet()
    {
        if (isset($this->itineraries->where('depart_return_id', 'r')->first()->etd)) {
            return $this->itineraries->where('depart_return_id', 'r')->first()->etd;
        }
        return "0000-00-00 00:00:00";
    }
    public function getEtaDep()
    {
        if (isset($this->itineraries->where('depart_return_id', 'd')->first()->eta)) {
            return $this->itineraries->where('depart_return_id', 'd')->last()->eta;
        }
        return "0000-00-00 00:00:00";
    }
    public function getEtaRet()
    {
        if (isset($this->itineraries->where('depart_return_id', 'r')->first()->eta)) {
            return $this->itineraries->where('depart_return_id', 'r')->last()->eta;
        }
        return "0000-00-00 00:00:00";
    }
    public function getDepartureDateAttribute()
    {
        $date = date('Y-m-d', strtotime($this->getEtdDep()));
        return $date;
    }
    public function getReturnDateAttribute()
    {
        if ($this->airlines_transaction->trip_type_id == 'R') {
            $date = date('Y-m-d', strtotime($this->getEtdRet()));
            return $date;
        }
        return "0000-00-00";
    }
    public function getDepartureEtdAttribute()
    {
        $time = date("Y-m-d H:i", strtotime($this->getEtdDep()));
        return $time;
    }
    public function getDepartureEtaAttribute()
    {
        $time = date("Y-m-d H:i", strtotime($this->getEtaDep()));
        return $time;
    }
    public function getReturnEtdAttribute()
    {
        if ($this->airlines_transaction->trip_type_id == 'R') {
            $time = date("Y-m-d H:i", strtotime($this->getEtdRet()));
            return $time;
        }
        return "00-00-00 00:00:00";
    }
    public function getReturnEtaAttribute()
    {
        if ($this->airlines_transaction->trip_type_id == 'R') {
            $time = date("Y-m-d H:i", strtotime($this->getEtaRet()));
            return $time;
        }
        return "00-00-00 00:00:00";
    }
    public function getMarketPriceAttribute()
    {
        return $this->paxpaid;
    }
    public function getSmartPriceAttribute()
    {
        if ($this->transaction_commission()->first()) {
            $commisionMember = $this->transaction_commission()->first()->member;
            return (int)$this->paxpaid - $commisionMember;
        }
        return null;
    }
}
