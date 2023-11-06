<?php

namespace App\Domain\Game\Infrastructure\Repository;

use App\Domain\Game\Domain\Entity\GameEntity;
use App\Domain\Game\Domain\Repository\GameRepositoryInterface;
use App\Domain\Game\Domain\ValueObject\GameId;
use App\Models\Game as GameModel;
use Illuminate\Support\Facades\DB;

final class MysqlGameRepository implements GameRepositoryInterface
{
  private $gameTableName;

  public function __construct(GameModel $gameModel)
  {
    $this->gameTableName = $gameModel->getTable();
  }

  public function save(GameEntity $gameEntity)
  {
    $params = $gameEntity->toArray();

    $sql = 'INSERT INTO ' . $this->gameTableName . PHP_EOL;
    $sql .= ' (id, destination_postal_code, created_at, updated_at)' . PHP_EOL;
    $sql .= ' VALUES' . PHP_EOL;
    $sql .= ' (:id, :destination_postal_code, NOW(), NOW())';

    DB::insert($sql, $params);
  }

  public function find(GameId $gameId)
  {
    $params = ['id' => $gameId->value()];

    $sql = 'SELECT * FROM  ' . $this->gameTableName . PHP_EOL;
    $sql .= ' WHERE id = :id';

    return DB::selectOne($sql, $params);
  }
}
