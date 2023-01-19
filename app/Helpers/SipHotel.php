<?php

namespace App\Helpers;

use App\Helpers\API\Hotel;
use App\Helpers\Hotel\HotelCreate;

class SipHotel
{
  public static function Search($attributes){
    return new Hotel($attributes);
  }
  public static function next($attributes){
    return new Hotel($attributes);
  }
  public static function detail($attributes){
    return new Hotel($attributes);
  }
  public static function Issued($attributes){
    return new Hotel($attributes);
  }
  public static function createTransaction($userId,$attributes){
    return new HotelCreate($userId,$attributes);
  }
}
