<?php
/**
 * Created by PhpStorm.
 * User: infiniqa
 * Date: 07/10/16
 * Time: 8:52
 */

namespace App\Helpers;

use App\Helpers\Airlines\AirlinesCreate;
use App\Helpers\API\Airlines;

class SipAirlines
{
    public static function GetSchedule($attributes,$international){
        if($international==false){
            return new Airlines($attributes,false);
        }else{
            return new Airlines($attributes,true);
        }
    }

    public static function createTransaction($userId,$request){
        return new AirlinesCreate($userId,$request);
    }

}