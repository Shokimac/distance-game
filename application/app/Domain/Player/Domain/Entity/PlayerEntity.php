<?php

namespace App\Domain\Player\Domain\Entity;

use App\Domain\Game\Domain\ValueObject\GameId;
use App\Domain\Location\Domain\ValueObject\LocationId;
use App\Domain\Player\Domain\ValueObject\DistanceToDestination;
use App\Domain\Player\Domain\ValueObject\PlayerId;
use App\Domain\Player\Domain\ValueObject\PlayerName;
use App\Domain\Player\Domain\ValueObject\PlayerTurn;

final class PlayerEntity
{
  private $playerId;
  private $gameId;
  private $name;
  private $turn;
  private $drawLocationId;
  private $distanceToDestination;

  public function __construct(
    PlayerId $playerId,
    GameId $gameId,
    PlayerName $name,
    PlayerTurn $turn,
    LocationId $drawLocationId,
    DistanceToDestination $distanceToDestination
  ) {
    $this->playerId = $playerId;
    $this->gameId = $gameId;
    $this->name = $name;
    $this->turn = $turn;
    $this->drawLocationId = $drawLocationId;
    $this->distanceToDestination = $distanceToDestination;
  }

  public function getId(): PlayerId
  {
    return $this->playerId;
  }

  public function getGameId(): GameId
  {
    return $this->gameId;
  }

  public function getName(): PlayerName
  {
    return $this->name;
  }

  public function getTurn(): PlayerTurn
  {
    return $this->turn;
  }

  public function getDrawLocationId(): LocationId
  {
    return $this->drawLocationId;
  }

  public function getDistanceToDestination(): DistanceToDestination
  {
    return $this->distanceToDestination;
  }

  public function toArray(): array
  {
    return [
      'id' => $this->getId()->value(),
      'game_id' => $this->getGameId()->value(),
      'name' => $this->getName()->value(),
      'turn' => $this->getTurn()->value(),
      'draw_location_id' => $this->getDrawLocationId()->value(),
      'distance_to_destination' => $this->getDistanceToDestination()->value()
    ];
  }
}
