<?php
/**
 * Created by PhpStorm.
 * User: infiniqa
 * Date: 03/11/16
 * Time: 9:14
 */

namespace App\Helpers\Deposit;


class Deposit
{
    public static function check($userId,$totalPrice){
        return new CheckDeposit($userId,$totalPrice);
    }
    public static function balance($userId){
        return new BalanceDeposit($userId);
    }
    public static function debit($userId,$debit,$transactionId){
        return new DebitDeposit($userId,$debit,$transactionId);
    }
    public static function credit($userId,$credit,$transactionId){
        return new CreditDeposit($userId,$credit,$transactionId);
    }
    public static function RequestTransfer($attributes){
        return new RequestTransfer($attributes);
    }
    public static function Transfer($userId,$otp){
        return new TransferDeposit($userId,$otp);
    }
    public static function RequestPayment($attributes){
        return new RequestPayment($attributes);
    }
    public static function Payment($userId,$otp){
        return new TransferPayment($userId,$otp);
    }
}
