<?php

namespace App\Domain\Base\ValueObject;

use Exception;

class PostalCodeBase
{
  protected $postalCode;

  protected function __construct(string $postalCode)
  {
    if (empty($postalCode) || (is_numeric($postalCode) && strlen($postalCode) == 7) === false) {
      throw new Exception();
    }

    $this->postalCode = $postalCode;
  }

  protected function val(): string
  {
    return $this->postalCode;
  }
}
