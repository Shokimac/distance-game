<?php

namespace App\Domain\Location\Domain\ValueObject;

use Exception;

final class CityKana
{
  private $cityKana;

  public function __construct(string $cityKana)
  {
    if (empty($cityKana)) {
      throw new Exception();
    }

    $this->cityKana = $cityKana;
  }

  public function value(): string
  {
    return $this->cityKana;
  }
}
