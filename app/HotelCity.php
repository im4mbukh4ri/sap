<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelCity extends Model
{
    public $incrementing = false;
    protected $hidden=['created_at','updated_at'];
    protected $fillable=['id','city','international','country','created_at','updated_at'];
}
