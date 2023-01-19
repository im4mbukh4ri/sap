<?php
/**
 * Created by PhpStorm.
 * User: infiniqa
 * Date: 26/10/16
 * Time: 16:45
 */

namespace App\Helpers\API;


class Ppob extends Api
{
    protected $endPointAPI="loketppob/";
    public function __construct($attributes)
    {
        parent::__construct();
        $this->parameters=$attributes;
        $this->overWriteOptions=[
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$this->parameters,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ]

        ];
        $this->getData();
    }
}