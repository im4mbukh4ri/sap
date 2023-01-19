<?php
/**
 * Created by PhpStorm.
 * User: infiniqa
 * Date: 02/11/16
 * Time: 15:34
 */

namespace App\Helpers\API;


class Airlines extends Api
{
    protected $endPointAPI="airline/domestik/";
    public function __construct($attributes,$international=false)
    {
        if($international==true){
            $this->mmid=config('sip-config')['mmid'];
            $this->endPointAPI="airline/international/";
        }
        parent::__construct();
//        if($international=true){
//            $this->endPointAPI='airline/international/';
//        }
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
