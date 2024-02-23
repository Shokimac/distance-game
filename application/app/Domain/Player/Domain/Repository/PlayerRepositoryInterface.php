<?php

namespace App\Domain\Player\Domain\Repository;

use App\Domain\Game\Domain\ValueObject\GameId;
use App\Domain\Player\Domain\Entity\PlayerEntity;
use App\Domain\Player\Domain\ValueObject\PlayerId;

interface PlayerRepositoryInterface
{
  public function save(PlayerEntity $playerEntity);
  public function findPlayersByGameId(GameId $gameId);
  public function find(PlayerId $playerId);
  public function update(PlayerEntity $playerEntity);
}
