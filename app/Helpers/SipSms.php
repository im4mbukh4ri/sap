<?php

namespace App\Helpers;

use App\Helpers\API\Sms;

class SipSms
{
  public static function Send($attributes){
    return new Sms($attributes);
  }
}
