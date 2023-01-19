<?php
/**
 * Created by Mochamad Ramdhanie Mubarak.
 * User: dhaniemubarak
 * Date: 23/03/2017
 * Time: 23:58
 */

namespace App\Helpers\Point;
class CreditPoint extends PointService
{
    public function __construct($userId,$debit,$transactionId)
    {
        parent::__construct($userId);
        $this->totalPoint=$debit;
        $this->creditPoint($transactionId);
    }
}