<?php

namespace App\Domain\Location\Domain\Entity;

use App\Domain\Location\Domain\ValueObject\City;
use App\Domain\Location\Domain\ValueObject\CityKana;
use App\Domain\Location\Domain\ValueObject\LocationId;
use App\Domain\Location\Domain\ValueObject\PostalCode;
use App\Domain\Location\Domain\ValueObject\Prefecture;
use App\Domain\Location\Domain\ValueObject\Town;
use App\Domain\Location\Domain\ValueObject\TownKana;

final class LocationEntity
{
  private $locationId;
  private $postalCode;
  private $prefecture;
  private $city;
  private $town;
  private $cityKana;
  private $townKana;

  public function __construct(
    LocationId $locationId,
    PostalCode $postalCode,
    Prefecture $prefecture,
    City $city,
    Town $town,
    CityKana $cityKana,
    TownKana $townKana
  ) {
    $this->locationId = $locationId;
    $this->postalCode = $postalCode;
    $this->prefecture = $prefecture;
    $this->city = $city;
    $this->town = $town;
    $this->cityKana = $cityKana;
    $this->townKana = $townKana;
  }

  public function getLocationId(): LocationId
  {
    return $this->locationId;
  }

  public function getPostalCode(): PostalCode
  {
    return $this->postalCode;
  }

  public function getPrefecture(): Prefecture
  {
    return $this->prefecture;
  }

  public function getCity(): City
  {
    return $this->city;
  }

  public function getTown(): Town
  {
    return $this->town;
  }

  public function getCityKana(): CityKana
  {
    return $this->cityKana;
  }

  public function getTownKana(): TownKana
  {
    return $this->townKana;
  }

  public function toArray(): array
  {
    return [
      'id' => $this->getLocationId()->value(),
      'postal_code' => $this->getPostalCode()->value(),
      'prefecture' => $this->getPrefecture()->value(),
      'city' => $this->getCity()->value(),
      'town' => $this->getTown()->value(),
      'city_kana' => $this->getCityKana()->value(),
      'town_kana' => $this->getTownKana()->value()
    ];
  }
}
