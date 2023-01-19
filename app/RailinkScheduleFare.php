<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RailinkScheduleFare extends Model
{
  protected $fillable=['id','railink_schedule_id','class','subclass','seat_avb',
    'total_fare','price_adt','price_chd','price_inf'];
    public $incrementing=false;

    public function schedule(){
      return $this->belongsTo('App\RailinkSchedule','railink_schedule_id');
    }
}
