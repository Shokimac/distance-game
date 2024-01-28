<?php

namespace App\Domain\Location\Domain\ValueObject;

use Exception;

final class Latitude
{
  private $latitude;

  public function __construct(string $latitude)
  {
    if (empty($latitude)) throw new Exception();
    if ((int)$latitude < 0) throw new Exception(); // 日本の緯度はプラス方向になるため

    $this->latitude = $latitude;
  }

  public function value(): string
  {
    return $this->latitude;
  }
}
