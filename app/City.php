<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $hidden=['created_at','updated_at'];

    protected $table = 'old_cities';
    public function subdistricts(){
        return $this->hasMany('App\Subdistrict');
    }
    public function province(){
        return $this->belongsTo('App\Province');
    }
}
