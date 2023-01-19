<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelRoomFare extends Model
{
    //

    public $primaryKey='selected_id_room';
    public $incrementing=false;
    protected $fillable=['hotel_room_id','selected_id','selected_id_room',
      'checkin','checkout','price','nta'];

    public function hotel_room(){
      return $this->belongsTo('App\HotelRoom','hotel_room_id');
    }
}
