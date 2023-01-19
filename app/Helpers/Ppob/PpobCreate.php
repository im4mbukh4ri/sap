<?php
namespace App\Helpers\Ppob;


use App\User;

class PpobCreate extends PpobTransaction
{
    public function __construct($userId,$request)
    {
        $this->userId=$userId;
        $this->request=$request;
        $this->rqid=config('sip-config')['rqid'];
        $user=User::find($userId)->username;
        if($user=='trialdev'||$user=='member_free'){
            $this->mmid='retross_01';
        }else{
            $this->mmid=config('sip-config')['mmid'];
        }
        $this->nra=abs(config('sip-config')['pulsa_commission']);
        $this->markup=abs(config('sip-config')['pulsa_markup']);
        $this->createData();
    }
}