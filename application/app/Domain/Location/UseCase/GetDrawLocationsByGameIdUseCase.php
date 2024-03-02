<?php

namespace App\Domain\Location\UseCase;

use App\Domain\Game\Domain\Repository\GameRepositoryInterface;
use App\Domain\Game\Domain\ValueObject\GameId;
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
use App\Domain\Player\Domain\Repository\PlayerRepositoryInterface;
use Exception;

final class GetDrawLocationsByGameIdUseCase
{
  private $playerRepository;
  private $locationRepository;

  public function __construct(
    PlayerRepositoryInterface $playerRepository,
    LocationRepositoryInterface $locationRepository
  ) {
    $this->playerRepository = $playerRepository;
    $this->locationRepository = $locationRepository;
  }

  public function execute(GameId $gameId): array
  {
    $players = $this->playerRepository->findPlayersByGameId(gameId: $gameId);
    if (empty($players)) {
      throw new Exception();
    }

    $drawLocaitonIds = array_column($players, 'draw_location_id');
    $drawLocations = $this->locationRepository->findByLocationIds(locationIds: $drawLocaitonIds);

    $res = [];
    foreach ($drawLocations as $location) {
      $drawLocationEntity = new LocationEntity(
        locationId: new LocationId($location->id),
        postalCode: new PostalCode($location->postal_code),
        prefecture: new Prefecture($location->prefecture),
        city: new City($location->city),
        town: new Town($location->town),
        cityKana: new CityKana($location->city_kana),
        townKana: new TownKana($location->town_kana),
        latitude: new Latitude($location->latitude),
        longitude: new Longitude($location->longitude)
      );

      $res[$drawLocationEntity->getLocationId()->value()] = $drawLocationEntity->toArray();
    }

    return $res;
  }
}
