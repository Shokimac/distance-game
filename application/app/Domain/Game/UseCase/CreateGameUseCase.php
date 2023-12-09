<?php

namespace App\Domain\Game\UseCase;

use App\Domain\Game\Domain\Entity\GameEntity;
use App\Domain\Game\Domain\ValueObject\GameId;
use App\Domain\Location\Domain\ValueObject\LocationId;
use App\Domain\Location\Domain\Entity\LocationEntity;
use App\Domain\Location\Domain\Repository\LocationRepositoryInterface;
use App\Domain\Location\Domain\ValueObject\City;
use App\Domain\Location\Domain\ValueObject\CityKana;
use App\Domain\Location\Domain\ValueObject\Latitude;
use App\Domain\Location\Domain\ValueObject\Longitude;
use App\Domain\Location\Domain\ValueObject\PostalCode;
use App\Domain\Location\Domain\ValueObject\Prefecture;
use App\Domain\Location\Domain\ValueObject\Town;
use App\Domain\Location\Domain\ValueObject\TownKana;

final class CreateGameUseCase
{
  // リポジトリ
  private $locationRepository;

  public function __construct(
    LocationRepositoryInterface $locationRepository,
  ) {
    $this->locationRepository = $locationRepository;
  }

  public function execute(
    GameId $gameId
  ): GameEntity {

    $pickRandomLocation = $this->locationRepository->findRandomLocation();
    $locationEntity = new LocationEntity(
      locationId: new LocationId($pickRandomLocation->id),
      postalCode: new PostalCode($pickRandomLocation->postal_code),
      prefecture: new Prefecture($pickRandomLocation->prefecture),
      city: new City($pickRandomLocation->city),
      town: new Town($pickRandomLocation->town),
      cityKana: new CityKana($pickRandomLocation->city_kana),
      townKana: new TownKana($pickRandomLocation->town_kana),
      latitude: new Latitude($pickRandomLocation->latitude),
      longitude: new Longitude($pickRandomLocation->longitude),
    );

    $gameEntity = new GameEntity(
      gameId: $gameId,
      destinationLocationId: $locationEntity->getLocationId()
    );

    $gameEntity->insertGame();

    return $gameEntity;
  }
}
