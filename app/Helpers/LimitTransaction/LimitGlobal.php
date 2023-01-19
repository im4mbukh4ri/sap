<?php

namespace App\Helpers\LimitTransaction;

/**
 *
 */
class LimitGlobal extends LimitTransaction
{

  function __construct($totalFare,$userId)
  {
    parent::__construct($totalFare,$userId);
    $this->globalScope();
  }
}
