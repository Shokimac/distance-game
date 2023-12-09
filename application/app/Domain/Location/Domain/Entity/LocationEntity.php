<?php

namespace App\Domain\Location\Domain\Entity;

use App\Domain\Location\Domain\ValueObject\City;
use App\Domain\Location\Domain\ValueObject\CityKana;
use App\Domain\Location\Domain\ValueObject\Latitude;
use App\Domain\Location\Domain\ValueObject\LocationId;
use App\Domain\Location\Domain\ValueObject\Longitude;
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
  private $latitude;
  private $longitude;

  public function __construct(
    LocationId $locationId,
    PostalCode $postalCode,
    Prefecture $prefecture,
    City $city,
    Town $town,
    CityKana $cityKana,
    TownKana $townKana,
    Latitude $latitude,
    Longitude $longitude,
  ) {
    $this->locationId = $locationId;
    $this->postalCode = $postalCode;
    $this->prefecture = $prefecture;
    $this->city = $city;
    $this->town = $town;
    $this->cityKana = $cityKana;
    $this->townKana = $townKana;
    $this->latitude = $latitude;
    $this->longitude = $longitude;
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

  public function getLatitude(): Latitude
  {
    return $this->latitude;
  }

  public function getLongitude(): Longitude
  {
    return $this->longitude;
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
      'town_kana' => $this->getTownKana()->value(),
      'latitude' => $this->getLatitude()->value(),
      'longitude' => $this->getLongitude()->value(),
    ];
  }
}
