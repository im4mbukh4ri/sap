<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestTransferDeposit extends Model
{
    protected $fillable=['from_user','to_user','otp','nominal','admin','expired','confirmed','status',
      'note','device','ip'];
      
    public function fromUser(){
    	return $this->belongsTo('App\User','from_user');
    }
    public function toUser(){
    	return $this->belongsTo('App\User','to_user');
    }
}
