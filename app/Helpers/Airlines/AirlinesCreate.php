<?php
namespace App\Helpers\Airlines;


class AirlinesCreate extends AirlinesTransaction
{
    public function __construct($userId,$request)
    {
        $this->user_id=$userId;
        $this->request=$request;
        $this->createData();
    }
}