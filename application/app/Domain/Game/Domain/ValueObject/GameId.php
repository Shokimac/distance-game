<?php

namespace App\Domain\Game\Domain\ValueObject;

use App\Domain\Base\ValueObject\UniqueEntityId;

final class GameId extends UniqueEntityId
{
  public function __construct(string $id)
  {
    parent::__construct($id);
  }

  public function value(): string
  {
    return $this->val();
  }
}
