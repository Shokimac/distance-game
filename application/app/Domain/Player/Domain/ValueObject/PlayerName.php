<?php

namespace App\Domain\Player\Domain\ValueObject;

use Exception;

final class PlayerName
{
  private $name;

  public function __construct(string $name)
  {

    if (empty($name)) {
      throw new Exception();
    }

    $this->name = $name;
  }

  public function value(): string
  {
    return $this->name;
  }
}
