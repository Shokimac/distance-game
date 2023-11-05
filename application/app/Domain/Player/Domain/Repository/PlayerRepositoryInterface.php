<?php

namespace App\Domain\Player\Domain\Repository;

use App\Domain\Player\Domain\Entity\PlayerEntity;

interface PlayerRepositoryInterface
{
  public function save(PlayerEntity $playerEntity);
}
