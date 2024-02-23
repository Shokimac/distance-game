<?php

namespace App\Domain\Player\Domain\ValueObject;

use Exception;

final class DistanceToDestination
{
  private $distanceToDestination;

  public function __construct(float $distanceToDestination)
  {
    if (is_null($distanceToDestination) || floatval($distanceToDestination) < 0) {
      throw new Exception();
    }

    $this->distanceToDestination = $distanceToDestination;
  }

  public function value(): float
  {
    return $this->distanceToDestination;
  }
}
