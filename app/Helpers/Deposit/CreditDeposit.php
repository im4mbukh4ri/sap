<?php
/**
 * Created by PhpStorm.
 * User: infiniqa
 * Date: 03/11/16
 * Time: 15:25
 */

namespace App\Helpers\Deposit;


class CreditDeposit extends DepositService
{
    public function __construct($userId,$credit,$transactionId)
    {
        parent::__construct($userId);
        $this->totalPrice=$credit;
        $this->creditDeposit($transactionId);
    }
}