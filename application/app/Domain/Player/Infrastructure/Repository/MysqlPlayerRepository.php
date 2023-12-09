<?php

namespace App\Domain\Player\Infrastructure\Repository;

use App\Domain\Game\Domain\ValueObject\GameId;
use App\Domain\Player\Domain\Entity\PlayerEntity;
use App\Domain\Player\Domain\Repository\PlayerRepositoryInterface;
use App\Models\Player as PlayerModel;
use Illuminate\Support\Facades\DB;

final class MysqlPlayerRepository implements PlayerRepositoryInterface
{
  private $playerTableName;

  public function __construct(PlayerModel $playerModel)
  {
    $this->playerTableName = $playerModel->getTable();
  }

  public function save(PlayerEntity $playerEntity)
  {
    $params = $playerEntity->toArray();

    $sql = 'INSERT INTO ' . $this->playerTableName . PHP_EOL;
    $sql .= ' (id, game_id, name, turn, distance_to_destination, created_at, updated_at)' . PHP_EOL;
    $sql .= ' VALUES' . PHP_EOL;
    $sql .= ' (:id, :game_id, :name, :turn, :distance_to_destination, NOW(), NOW())';

    DB::insert($sql, $params);
  }

  public function findPlayersByGameId(GameId $gameId)
  {
    $params = ['game_id' => $gameId->value()];

    $sql = 'SELECT * FROM ' . $this->playerTableName . ' WHERE game_id = :game_id';

    return DB::select($sql, $params);
  }
}
