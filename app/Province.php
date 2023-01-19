<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //

    public function cities(){
        return $this->hasMany('App\City');
    }

    public function subdistricts(){
        return $this->hasManyThrough('App\Subdistrict','App\City');
    }
}
