<?php
/**
 * Created by PhpStorm.
 * User: infiniqa
 * Date: 03/11/16
 * Time: 9:35
 */

namespace App\Helpers\Deposit;


class BalanceDeposit extends DepositService
{
    public function __construct($userId)
    {
        parent::__construct($userId);
        $this->balance();

    }
}