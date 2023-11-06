<?php

namespace App\Domain\Game\UseCase;

use App\Domain\Game\Domain\Entity\GameEntity;
use App\Domain\Game\Domain\Repository\GameRepositoryInterface;
use App\Domain\Game\Domain\ValueObject\DestinationPostalCode;
use App\Domain\Game\Domain\ValueObject\GameId;

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
      destinationPostalCode: new DestinationPostalCode($gameData->destination_postal_code),
    );

    return $gameEntity;
  }
}
