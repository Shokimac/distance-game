<?php

namespace App\Domain\Player\Domain\ValueObject;

use Exception;

final class DistanceToDestination
{
  private $distanceToDestination;

  public function __construct(int $distanceToDestination)
  {
    if (is_null($distanceToDestination) || intval($distanceToDestination) < 0) {
      throw new Exception();
    }

    $this->distanceToDestination = $distanceToDestination;
  }

  public function value(): int
  {
    return $this->distanceToDestination;
  }
}
