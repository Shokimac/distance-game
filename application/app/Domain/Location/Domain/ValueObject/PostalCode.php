<?php

namespace App\Domain\Location\Domain\ValueObject;

use App\Domain\Base\ValueObject\PostalCodeBase;

final class PostalCode extends PostalCodeBase
{
  public function __construct(string $postalCode)
  {
    parent::__construct($postalCode);
  }

  public function value(): string
  {
    return $this->val();
  }
}
