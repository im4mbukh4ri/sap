<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    //
    protected $fillable = ['user_id', 'log'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
