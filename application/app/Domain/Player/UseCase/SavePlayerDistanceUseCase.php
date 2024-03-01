<?php

namespace App\Domain\Player\UseCase;

use App\Domain\Game\Domain\ValueObject\GameId;
use App\Domain\Location\Domain\ValueObject\LocationId;
use App\Domain\Player\Domain\Entity\PlayerEntity;
use App\Domain\Player\Domain\Repository\PlayerRepositoryInterface;
use App\Domain\Player\Domain\ValueObject\DistanceToDestination;
use App\Domain\Player\Domain\ValueObject\PlayerId;
use App\Domain\Player\Domain\ValueObject\PlayerName;
use App\Domain\Player\Domain\ValueObject\PlayerTurn;
use Illuminate\Support\Facades\Log;

final class SavePlayerDistanceUseCase
{
  private $playerRepository;

  public function __construct(PlayerRepositoryInterface $playerRepository)
  {
    $this->playerRepository = $playerRepository;
  }

  public function execute(
    PlayerId $playerId,
    DistanceToDestination $distanceToDestination,
    LocationId $drawLocationId
  ): bool {

    try {
      $playerData = $this->playerRepository->find(playerId: $playerId);

      $player = new PlayerEntity(
        playerId: $playerId,
        gameId: new GameId($playerData->game_id),
        name: new PlayerName($playerData->name),
        turn: new PlayerTurn($playerData->turn),
        drawLocationId: $drawLocationId,
        distanceToDestination: $distanceToDestination
      );

      $this->playerRepository->update(playerEntity: $player);

      return true;
    } catch (\Throwable $th) {
      Log::error($th->getMessage());
      return false;
    }
  }
}
