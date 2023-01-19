<?php

namespace App\Helpers;

use App\Helpers\API\Train;
use App\Helpers\Train\TrainCreate;

class SipTrain
{
  public static function GetSchedule($attributes){
    return new Train($attributes);
  }
  public static function GetSeat($attributes){
    return new Train($attributes);
  }
  public static function Issued($attributes){
      return new Train($attributes);
  }
  public static function CreateTransaction($userId,$request){
      return new TrainCreate($userId,$request);
  }
}
