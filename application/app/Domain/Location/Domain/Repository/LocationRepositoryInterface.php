<?php

namespace App\Domain\Location\Domain\Repository;

use App\Domain\Location\Domain\ValueObject\LocationId;
use App\Domain\Location\Domain\ValueObject\PostalCode;

interface LocationRepositoryInterface
{
  public function findRandomLocation();
  public function find(LocationId $locationId);
  public function findByPostalCoce(PostalCode $postalCode);
  public function findLocationsByHeadPostalCode(PostalCode $postalCode);
}
