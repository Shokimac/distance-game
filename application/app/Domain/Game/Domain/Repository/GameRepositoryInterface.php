<?php

namespace App\Domain\Game\Domain\Repository;

use App\Domain\Game\Domain\Entity\GameEntity;
use App\Domain\Game\Domain\ValueObject\GameId;

interface GameRepositoryInterface
{
  public function save(GameEntity $gameEntity);
  public function find(GameId $gameId);
}
