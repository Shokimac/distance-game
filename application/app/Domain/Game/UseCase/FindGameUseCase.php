<?php

namespace App\Domain\Game\UseCase;

use App\Domain\Game\Domain\Entity\GameEntity;
use App\Domain\Game\Domain\Repository\GameRepositoryInterface;
use App\Domain\Game\Domain\ValueObject\GameId;
use App\Domain\Location\Domain\ValueObject\LocationId;

final class FindGameUseCase
{
  private $gameRepository;
  public function __construct(GameRepositoryInterface $gameRepository)
  {
    $this->gameRepository = $gameRepository;
  }

  public function execute(GameId $gameId): GameEntity
  {
    $gameData = $this->gameRepository->find(gameId: $gameId);

    $gameEntity = new GameEntity(
      gameId: $gameId,
      destinationLocationId: new LocationId($gameData->destination_location_id)
    );

    return $gameEntity;
  }
}
