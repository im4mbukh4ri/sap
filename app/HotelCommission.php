<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelCommission extends Model
{
    protected $fillable=['hotel_transaction_id','nra','komisi','free','pusat','bv','member','upline'];
}
