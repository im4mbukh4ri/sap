<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RailinkSchedule extends Model
{
  protected $fillable=['train_name','train_number','origin','destination',
    'etd','eta'];

    public function fares(){
      return $this->hasMany('App\RailinkScheduleFare','railink_schedule_id');
    }
}
