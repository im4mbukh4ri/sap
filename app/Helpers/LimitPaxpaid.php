<?php

namespace App\Helpers;


use App\Helpers\LimitTransaction\LimitGlobal;

class LimitPaxpaid {
  public static function GlobalPaxpaid($totalFare,$userId){
    return new LimitGlobal($totalFare,$userId);
  }
}
