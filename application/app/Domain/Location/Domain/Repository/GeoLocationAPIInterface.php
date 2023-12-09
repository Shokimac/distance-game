<?php

namespace App\Domain\Location\Domain\Repository;

use App\Domain\Location\Domain\ValueObject\PostalCode;

interface GeoLocationAPIInterface
{
  public function getLocationByGeoAPI(PostalCode $postalCode);
}
