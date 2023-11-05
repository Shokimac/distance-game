<?php

namespace App\Domain\Player\Domain\ValueObject;

use App\Domain\Base\ValueObject\UniqueEntityId;

final class PlayerId extends UniqueEntityId
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
