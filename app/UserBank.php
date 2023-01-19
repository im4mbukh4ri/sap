<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    //
    protected $table='user_bank';
    protected $fillable=['user_id','bank_name','number','owner_name',];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
