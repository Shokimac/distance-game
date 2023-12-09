<?php

namespace App\Domain\Location\Domain\Repository;

use App\Domain\Location\Domain\ValueObject\LocationId;

interface LocationRepositoryInterface
{
  public function findRandomLocation();
  public function find(LocationId $locationId);
}
