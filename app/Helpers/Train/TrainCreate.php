<?php
namespace App\Helpers\Train;


class TrainCreate extends TrainTransaction
{
    public function __construct($userId,$request)
    {
        $this->userId=$userId;
        $this->request=$request;
        $this->createData();
    }
}
