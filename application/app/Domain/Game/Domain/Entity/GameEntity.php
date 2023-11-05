<?php

namespace App\Domain\Game\Domain\Entity;

use App\Domain\Game\Domain\Repository\GameRepositoryInterface;
use App\Domain\Game\Domain\ValueObject\DestinationPostalCode;
use App\Domain\Game\Domain\ValueObject\GameId;
use App\Domain\Player\Domain\Entity\PlayerEntity;
use App\Domain\Player\Domain\Repository\PlayerRepositoryInterface;
use App\Domain\Player\Domain\ValueObject\DistanceToDestination;
use App\Domain\Player\Domain\ValueObject\PlayerId;
use App\Domain\Player\Domain\ValueObject\PlayerName;
use App\Domain\Player\Domain\ValueObject\PlayerTurn;
use Illuminate\Foundation\Application;

final class GameEntity
{
  private $gameId;
  private $destinationPostalCode;

  // Repository
  private $gameRepository;
  private $playerRepository;

  public function __construct(
    GameId $gameId,
    DestinationPostalCode $destinationPostalCode,
  ) {
    $this->gameId = $gameId;
    $this->destinationPostalCode = $destinationPostalCode;

    $app = Application::getInstance();
    $this->gameRepository = $app->make(GameRepositoryInterface::class);
    $this->playerRepository = $app->make(PlayerRepositoryInterface::class);
  }

  public function getId(): GameId
  {
    return $this->gameId;
  }

  public function getDestinationPostalCode(): DestinationPostalCode
  {
    return $this->destinationPostalCode;
  }

  public function toArray(): array
  {
    return [
      'id' => $this->gameId->value(),
      'destination_postal_code' => $this->destinationPostalCode->value()
    ];
  }

  public function insertGame()
  {
    $this->gameRepository->save(gameEntity: $this);
  }

  public function insertPlayer(
    PlayerName $playerName,
    PlayerTurn $playerTurn
  ): PlayerEntity {
    $playerEntity = new PlayerEntity(
      playerId: new PlayerId(uniqid()),
      gameId: $this->getId(),
      name: $playerName,
      turn: $playerTurn,
      distanceToDestination: new DistanceToDestination(0),
    );

    $this->playerRepository->save(playerEntity: $playerEntity);

    return $playerEntity;
  }
}
