<?php

namespace App\Domain\Player\Domain\ValueObject;

use Exception;

final class PlayerTurn
{
  private $turn;

  public function __construct(int $turn)
  {

    if (empty($turn) || $turn <= 0) {
      throw new Exception();
    }

    $this->turn = $turn;
  }

  public function value(): int
  {
    return $this->turn;
  }
}
