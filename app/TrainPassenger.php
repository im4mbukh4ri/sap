<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainPassenger extends Model
{
    protected $fillable=['train_transaction_id','name','type','identity_number','phone'];
    protected $appends=['seat'];
    protected $hidden=['transaction','passanger_seats'];
    public function transaction()
    {
        return $this->belongsTo('App\TrainTransaction', 'train_transaction_id');
    }
    public function type_passenger()
    {
        return $this->belongsTo('App\TypePassenger', 'type');
    }
    public function passanger_seats()
    {
        if ($this->transaction->sip_service_id===3) {
            return $this->hasMany('App\TrainPassengerSeat', 'train_passanger_id');
        }
        return $this->hasMany('App\RailinkPassengerSeat', 'train_passanger_id');
    }
    public function getSeatAttribute()
    {
          $seat = null;
          if($this->passanger_seats()->count() > 0){
            if ($this->passanger_seats()->count() > 1) {
                $seat = [
                  'departure'=>$this->passanger_seats->first()->seat,
                  'return'=>$this->passanger_seats->last()->seat
                ];
            } else {
                $seat = [
                  'departure'=>$this->passanger_seats->first()->seat,
                  // 'return'=>$this->passanger_seats()->last()->seat
                ];
            }
          }
        return $seat;
    }
}
