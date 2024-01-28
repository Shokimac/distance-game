<?php

namespace App\Domain\Game\Domain\ValueObject;

use App\Domain\Base\ValueObject\PostalCodeBase;

final class DestinationPostalCode extends PostalCodeBase
{
  public function __construct(string $destinationPostalCode)
  {
    parent::__construct($destinationPostalCode);
  }

  public function value()
  {
    return $this->val();
  }
}
