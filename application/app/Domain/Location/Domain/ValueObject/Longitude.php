<?php

namespace App\Domain\Location\Domain\ValueObject;

use Exception;

final class Longitude
{
  private $longitude;

  public function __construct(string $longitude)
  {
    if (empty($longitude)) throw new Exception();
    if ((int)$longitude < 0) throw new Exception(); // 日本の緯度はプラス方向になるため

    $this->longitude = $longitude;
  }

  public function value(): string
  {
    return $this->longitude;
  }
}
