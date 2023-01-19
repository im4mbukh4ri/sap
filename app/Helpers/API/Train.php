<?php
namespace App\Helpers\API;

/**
 *
 */
class Train extends Api
{
  protected $endPointAPI="kereta/kai/";
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
