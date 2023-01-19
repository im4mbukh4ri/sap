<?php
/**
 * Created by Mochamad Ramdhanie Mubarak.
 * User: dhaniemubarak
 * Date: 23/03/2017
 * Time: 23:55
 */

namespace App\Helpers\Point;


class BalancePoint extends PointService
{
    public function __construct($userId)
    {
        parent::__construct($userId);
        $this->balance();
    }
}