<?php

namespace App\Domain\Location\Domain\ValueObject;

use App\Domain\Base\ValueObject\PostalCodeBase;

final class PostalCode extends PostalCodeBase
{
  public function __construct(string $postalCode)
  {
    parent::__construct($postalCode);
  }

  public function value(): string
  {
    return $this->val();
  }

  /**
   * 郵便番号の頭3桁を返す
   *
   * @return string
   */
  public function headValue(): string
  {
    return substr($this->val(), 0, 3);
  }
}
