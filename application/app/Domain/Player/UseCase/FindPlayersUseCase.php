<?php

namespace App\Domain\Player\UseCase;

use App\Domain\Game\Domain\ValueObject\GameId;
use App\Domain\Player\Domain\Entity\PlayerEntity;
use App\Domain\Player\Domain\Repository\PlayerRepositoryInterface;
use App\Domain\Player\Domain\ValueObject\DistanceToDestination;
use App\Domain\Player\Domain\ValueObject\PlayerId;
use App\Domain\Player\Domain\ValueObject\PlayerName;
use App\Domain\Player\Domain\ValueObject\PlayerTurn;

final class FindPlayersUseCase
{
  private $playerRepository;

  public function __construct(
    PlayerRepositoryInterface $playerRepository
  ) {
    $this->playerRepository = $playerRepository;
  }

  public function execute(GameId $gameId): array
  {
    $players = $this->playerRepository->findPlayersByGameId($gameId);

    $res = [];
    if (empty($players) === false) {
      foreach ($players as $player) {
        $playerEntity = new PlayerEntity(
          playerId: new PlayerId($player->id),
          gameId: $gameId,
          name: new PlayerName($player->name),
          turn: new PlayerTurn($player->turn),
          distanceToDestination: new DistanceToDestination($player->distance_to_destination)
        );

        $res[] = $playerEntity->toArray();
      }
    }

    return $res;
  }
}
