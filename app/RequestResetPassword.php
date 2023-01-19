<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestResetPassword extends Model
{
    protected $fillable = ['user_id','otp','new_password','admin','activation','confirmed','status','expired'];
    public function user(){
    	return $this->belongsTo('App\User');
    }
}
