<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainSeat extends Model
{
    public $timestamps=false;
    protected $fillable=['wagon_code','wagon_number','seat'];
    protected $hidden=['id'];
}
