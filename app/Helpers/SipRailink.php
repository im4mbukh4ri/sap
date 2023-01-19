<?php

namespace App\Helpers;

use App\Helpers\API\Railink;
use App\Helpers\Train\TrainCreate;

class SipRailink
{
  public static function GetSchedule($attributes){
    return new Railink($attributes);
  }
  public static function GetSeat($attributes){
    return new Railink($attributes);
  }
  public static function Issued($attributes){
      return new Railink($attributes);
  }
  public static function CreateTransaction($userId,$request){
      return new TrainCreate($userId,$request);
  }
}
