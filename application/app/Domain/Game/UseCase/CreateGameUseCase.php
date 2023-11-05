<?php

namespace App\Domain\Game\UseCase;

use App\Domain\Game\Domain\Entity\GameEntity;
use App\Domain\Game\Domain\ValueObject\DestinationPostalCode;
use App\Domain\Game\Domain\ValueObject\GameId;

final class CreateGameUseCase
{
  public function __construct()
  {
  }

  public function execute(
    GameId $gameId,
    DestinationPostalCode $destinationPostalCode,
  ): GameEntity {

    $gameEntity = new GameEntity(
      gameId: $gameId,
      destinationPostalCode: $destinationPostalCode,
    );

    $gameEntity->insertGame();

    return $gameEntity;
  }
}
