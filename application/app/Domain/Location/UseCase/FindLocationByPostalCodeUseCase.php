<?php

namespace App\Domain\Location\UseCase;

use App\Domain\Location\Domain\Entity\LocationEntity;
use App\Domain\Location\Domain\Repository\LocationRepositoryInterface;
use App\Domain\Location\Domain\ValueObject\City;
use App\Domain\Location\Domain\ValueObject\CityKana;
use App\Domain\Location\Domain\ValueObject\Latitude;
use App\Domain\Location\Domain\ValueObject\LocationId;
use App\Domain\Location\Domain\ValueObject\Longitude;
use App\Domain\Location\Domain\ValueObject\PostalCode;
use App\Domain\Location\Domain\ValueObject\Prefecture;
use App\Domain\Location\Domain\ValueObject\Town;
use App\Domain\Location\Domain\ValueObject\TownKana;

final class FindLocationByPostalCodeUseCase
{
  private $locationRepository;

  public function __construct(LocationRepositoryInterface $locationRepository)
  {
    $this->locationRepository = $locationRepository;
  }

  public function execute(PostalCode $postalCode): LocationEntity
  {
    $locationData = $this->locationRepository->findByPostalCoce(postalCode: $postalCode);

    if (empty($locationData)) {
      while (true) {
        $locations = $this->locationRepository->findLocationsByHeadPostalCode(postalCode: $postalCode);
        if (empty($locations) === false) {
          break;
        }
      }
      $random_key = array_rand($locations, 1);
      $locationData = $locations[$random_key];
    }

    $locationEntity = new LocationEntity(
      locationId: new LocationId(locationId: $locationData->id),
      postalCode: new PostalCode($locationData->postal_code),
      prefecture: new Prefecture($locationData->prefecture),
      city: new City($locationData->city),
      town: new Town($locationData->town),
      cityKana: new CityKana($locationData->city_kana),
      townKana: new TownKana($locationData->town_kana),
      latitude: new Latitude($locationData->latitude),
      longitude: new Longitude($locationData->longitude)
    );

    return $locationEntity;
  }
}
