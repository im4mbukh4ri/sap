<?php
/**
 * Created by PhpStorm.
 * User: infiniqa
 * Date: 03/11/16
 * Time: 13:46
 */

namespace App\Helpers\Deposit;


class DebitDeposit extends DepositService
{
    public function __construct($userId,$debit,$transactionId)
    {
        parent::__construct($userId);
        $this->totalPrice=$debit;
        $this->debitDeposit($transactionId);
    }
}