<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelGuestNote extends Model
{
    protected $fillable=['hotel_transaction_id','note'];
    public $timestamps = false;
    public function hotel_transaction(){
      return $this->belongsTo('App\HotelTransaction','hotel_transaction_id');
    }
}
