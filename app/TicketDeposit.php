<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketDeposit extends Model
{
    //
    protected $fillable=['nominal_request','unique_code','nominal','sip_bank_id','note'];
    protected $hidden=['user_id'];
    public function user(){
        return $this->belongsTo('App\User');
    }

    public static function statusList(){
        return [
            'waiting-transfer'=>'Menunggu',
            'cancel'=>'Cancel',
            'accepted'=>'Diterima',
            'rejected'=>'Ditolak'
        ];
    }
    public function sip_bank(){
        return $this->belongsTo('App\SipBank','sip_bank_id');
    }
    public function getBankAttribute(){
        $bank = $this->sip_bank();
        return $bank->bank_name.' - '.$bank->number.' - '.$bank->owner_name;
    }
    public function getLastStatusAttribute(){
        return static::statusList()[$this->status];
    }
}
