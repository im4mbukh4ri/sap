<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainSchedule extends Model
{
    protected $fillable=['train_name','train_number','origin','destination',
      'etd','eta'];

      public function fares(){
        return $this->hasMany('App\TrainScheduleFare','train_schedule_id');
      }
}
