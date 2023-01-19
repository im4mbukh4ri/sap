<?php

namespace App\Helpers\Hotel;


class HotelCreate extends HotelTransaction
{
    public function __construct($userId,$request)
    {
        $this->userId=$userId;
        $this->request=$request;
        $this->createData();
    }
}
