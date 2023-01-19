<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelVoucher extends Model
{
    public $timestamps = false;
    protected $fillable=['hotel_transaction_id','transaction_number','res','voucher'];
    public function transaction(){
    	return $this->belongsTo('App\HotelTransaction','hotel_transaction_id');
    }
}
