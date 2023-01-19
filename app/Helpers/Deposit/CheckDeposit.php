<?php
/**
 * Created by PhpStorm.
 * User: infiniqa
 * Date: 03/11/16
 * Time: 9:11
 */

namespace App\Helpers\Deposit;


class CheckDeposit extends DepositService
{
    public function __construct($userId,$totalPrice)
    {
        parent::__construct($userId);
        $this->totalPrice=$totalPrice;
        $this->check();
    }
}