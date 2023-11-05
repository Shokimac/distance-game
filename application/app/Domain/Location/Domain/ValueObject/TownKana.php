<?php

namespace App\Domain\Location\Domain\ValueObject;

use Exception;

final class TownKana
{
  private $townKana;

  public function __construct(string $townKana)
  {
    if (empty($townKana)) {
      throw new Exception();
    }

    $this->townKana = $townKana;
  }

  public function value(): string
  {
    return $this->townKana;
  }
}
