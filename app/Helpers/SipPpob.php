<?php

namespace App\Helpers;


use App\Helpers\API\Ppob;
use App\Helpers\Ppob\PpobCreate;

class SipPpob
{
    // public static function ppob($attributes){
    //     return new Ppob($attributes);
    // }
    public static function inquery($attributes){
      return new Ppob($attributes);
    }
    public static function checkStatus($attributes){
        return new Ppob($attributes);
    }
    public static function transaction($attributes){
        return new Ppob($attributes);
    }
    public static function createTransaction($userId,$attributes){
        return new PpobCreate($userId,$attributes);
    }
}
