<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelTransactionRoom extends Model
{
    public $incrementing=false;
    public $timestamps = false;
    protected $fillable=['hotel_transaction_id','hotel_room_id'];

    public function room(){
      return $this->belongsTo('App\HotelRoom','hotel_room_id');
    }
}
