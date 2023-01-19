<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReferral extends Model
{
    //
    protected $table='user_referrals';
    protected $fillable=['user_id','referral'];
    public $timestamps=false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getReferralAttribute()
    {
        return $this->user->username;
    }
}
