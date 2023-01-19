<?php

namespace App\Helpers\API;

/**
 *
 */
class Hotel extends Api
{

  protected $endPointAPI="hotel/";
  function __construct($attributes)
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
