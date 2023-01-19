<?php
/**
 * Created by Mochamad Ramdhanie Mubarak.
 * User: dhaniemubarak
 * Date: 24/03/2017
 * Time: 0:01
 */

namespace App\Helpers\Point;


class Point
{
    public static function check($userId,$totalPoint){
        return new CheckPoint($userId,$totalPoint);
    }
    public static function balance($userId){
        return new BalancePoint($userId);
    }
    public static function debit($userId,$debit,$transactionId){
        return new DebitPoint($userId,$debit,$transactionId);
    }
    public static function credit($userId,$credit,$transactionId){
        return new CreditPoint($userId,$credit,$transactionId);
    }
}