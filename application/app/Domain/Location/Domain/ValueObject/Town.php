<?php

namespace App\Domain\Location\Domain\ValueObject;

use Exception;

final class Town
{
  private $town;

  public function __construct(string $town)
  {
    if (empty($town)) {
      throw new Exception();
    }

    $this->town = $town;
  }

  public function value(): string
  {
    return $this->town;
  }
}
