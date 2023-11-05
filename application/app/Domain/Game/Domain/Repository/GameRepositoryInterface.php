<?php

namespace App\Domain\Game\Domain\Repository;

use App\Domain\Game\Domain\Entity\GameEntity;

interface GameRepositoryInterface
{
  public function save(GameEntity $gameEntity);
}
