<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeUser extends Model
{
    //

    protected $fillable=['id','name'];
    public function user(){
        return $this->hasMany('App\User');
    }
    public function comissions(){
        return $this->hasMany('App\UserCommision');
    }
    public function pusat_airlines(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','1')->where('sip_service_id','1');
    }
    public function bv_airlines(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','2')->where('sip_service_id','1');
    }
    public function member_airlines(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','3')->where('sip_service_id','1');
    }
    public function pusat_train(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','1')->where('sip_service_id','3');
    }
    public function bv_train(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','2')->where('sip_service_id','3');
    }
    public function member_train(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','3')->where('sip_service_id','3');
    }
    public function pusat_railink(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','1')->where('sip_service_id','4');
    }
    public function bv_railink(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','2')->where('sip_service_id','4');
    }
    public function member_railink(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','3')->where('sip_service_id','4');
    }
    public function pusat_hotel(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','1')->where('sip_service_id','5');
    }
    public function bv_hotel(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','2')->where('sip_service_id','5');
    }
    public function member_hotel(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','3')->where('sip_service_id','5');
    }
    public function pusat_ppob(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','1')->where('sip_service_id','2');
    }
    public function bv_ppob(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','2')->where('sip_service_id','2');
    }
    public function member_ppob(){
        return $this->hasOne('App\UserCommission')->where('type_commission_id','3')->where('sip_service_id','2');
    }
    public function limit_paxpaid(){
      return $this->hasOne('App\LimitPaxpaid');
    }
}
