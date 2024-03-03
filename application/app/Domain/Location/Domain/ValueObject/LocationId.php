<?php

namespace App\Domain\Location\Domain\ValueObject;

use Exception;

final class LocationId
{
  private $locationId;

  public function __construct(int $locationId)
  {
    if (is_null($locationId) || $locationId < 0) {
      throw new Exception();
    }

    $this->locationId = $locationId;
  }

  public function value(): int
  {
    return $this->locationId;
  }
}
