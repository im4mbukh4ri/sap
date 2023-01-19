<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $fillable=['detail','subdistrict_id','phone'];

    public function subdistrict(){
        return $this->belongsTo('App\Subdistrict');
    }

    public function user(){
        return $this->hasOne('App\User');
    }
}
