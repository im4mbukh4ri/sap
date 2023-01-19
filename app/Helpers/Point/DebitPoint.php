<?php
/**
 * Created by Mochamad Ramdhanie Mubarak.
 * User: dhaniemuabarak
 * Date: 24/03/2017
 * Time: 0:00
 */
namespace App\Helpers\Point;


class DebitPoint extends PointService
{
    public function __construct($userId,$debit,$transactionId)
    {
        parent::__construct($userId);
        $this->totalPoint=$debit;
        $this->debitPoint($transactionId);
    }
}