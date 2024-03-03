<?php

namespace App\Domain\Game\Domain\Entity;

use App\Domain\Game\Domain\Repository\GameRepositoryInterface;
use App\Domain\Game\Domain\ValueObject\GameId;
use App\Domain\Location\Domain\ValueObject\LocationId;
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
  private $destinationLocationId;

  // Repository
  private $gameRepository;
  private $playerRepository;

  public function __construct(
    GameId $gameId,
    LocationId $destinationLocationId
  ) {
    $this->gameId = $gameId;
    $this->destinationLocationId = $destinationLocationId;

    $app = Application::getInstance();
    $this->gameRepository = $app->make(GameRepositoryInterface::class);
    $this->playerRepository = $app->make(PlayerRepositoryInterface::class);
  }

  public function getId(): GameId
  {
    return $this->gameId;
  }

  public function getDestinationLocationId(): LocationId
  {
    return $this->destinationLocationId;
  }

  public function toArray(): array
  {
    return [
      'id' => $this->gameId->value(),
      'destination_location_id' => $this->destinationLocationId->value()
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
      drawLocationId: new LocationId(0), // スロットを引く前なので0
      distanceToDestination: new DistanceToDestination(0),
    );

    $this->playerRepository->save(playerEntity: $playerEntity);

    return $playerEntity;
  }
}
