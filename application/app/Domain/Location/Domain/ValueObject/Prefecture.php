<?php

namespace App\Domain\Location\Domain\ValueObject;

use Exception;

final class Prefecture
{
  private $prefecture;

  public function __construct(string $prefecture)
  {
    if (empty($prefecture)) {
      throw new Exception();
    }

    $this->prefecture = $prefecture;
  }

  public function value(): string
  {
    return $this->prefecture;
  }
}
