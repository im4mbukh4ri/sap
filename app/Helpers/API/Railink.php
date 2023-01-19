<?php

namespace App\Helpers\API;

/**
 *
 */
class Railink extends Api
{
  protected $endPointAPI="kereta/railink/";
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
