<?php

namespace App\Domain\Location\Domain\ValueObject;

use Exception;

final class City
{
  private $city;

  public function __construct(string $city)
  {
    if (empty($city)) {
      throw new Exception();
    }

    $this->city = $city;
  }

  public function value(): string
  {
    return $this->city;
  }
}
