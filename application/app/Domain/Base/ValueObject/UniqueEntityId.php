<?php

namespace App\Domain\Base\ValueObject;

use Exception;

class UniqueEntityId
{
  protected $id;

  protected function __construct(string $id)
  {
    if (empty($id)) {
      throw new Exception();
    }

    $this->id = $id;
  }

  protected function val(): string
  {
    return $this->id;
  }
}
