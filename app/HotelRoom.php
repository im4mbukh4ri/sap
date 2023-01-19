<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    protected $fillable=['hotel_id','name','bed','board'];
    public function hotel(){
      return $this->belongsTo('App\Hotel');
    }
    public function fares(){
      return $this->hasMany('App\HotelRoomFare','hotel_room_id');
    }
}
