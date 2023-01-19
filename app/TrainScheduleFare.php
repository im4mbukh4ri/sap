<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainScheduleFare extends Model
{
    protected $fillable=['id','train_schedule_id','class','subclass','seat_avb',
      'total_fare','price_adt','price_chd','price_inf'];
      public $incrementing=false;

      public function schedule(){
        return $this->belongsTo('App\TrainSchedule','train_schedule_id');
      }
}
