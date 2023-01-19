<?php
/**
 * Created by Mochamad Ramdhanie Mubarak.
 * User: dhaniemubarak
 * Date: 23/03/2017
 * Time: 23:56
 */

namespace App\Helpers\Point;

class CheckPoint extends PointService
{
    public function __construct($userId,$totalPoint)
    {
        parent::__construct($userId);
        $this->totalPoint=$totalPoint;
        $this->check();
    }
}