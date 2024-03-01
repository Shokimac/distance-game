<?php

namespace App\Domain\Player\Infrastructure\Repository;

use App\Domain\Game\Domain\ValueObject\GameId;
use App\Domain\Player\Domain\Entity\PlayerEntity;
use App\Domain\Player\Domain\Repository\PlayerRepositoryInterface;
use App\Domain\Player\Domain\ValueObject\PlayerId;
use App\Models\Player as PlayerModel;
use DateTime;
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
    $sql .= ' (id, game_id, name, turn, draw_location_id, distance_to_destination, created_at, updated_at)' . PHP_EOL;
    $sql .= ' VALUES' . PHP_EOL;
    $sql .= ' (:id, :game_id, :name, :turn, :draw_location_id, :distance_to_destination, NOW(), NOW())';

    DB::insert($sql, $params);
  }

  public function findPlayersByGameId(GameId $gameId)
  {
    $params = ['game_id' => $gameId->value()];

    $sql = 'SELECT * FROM ' . $this->playerTableName . ' WHERE game_id = :game_id';

    return DB::select($sql, $params);
  }

  public function find(PlayerId $playerId)
  {
    $params = ['id' => $playerId->value()];

    $sql = 'SELECT * FROM ' . $this->playerTableName . ' WHERE id = :id';

    return DB::selectOne($sql, $params);
  }

  public function update(PlayerEntity $playerEntity)
  {
    $datetime = new DateTime();
    $params = $playerEntity->toArray();

    $sql = 'UPDATE ' . $this->playerTableName . PHP_EOL;
    $sql .= 'SET game_id = :game_id, name = :name, turn = :turn, draw_location_id = :draw_location_id, distance_to_destination = :distance_to_destination, updated_at = "' . $datetime->format('Y-m-d H:i:s') . '"' . PHP_EOL;
    $sql .= 'WHERE id = :id';

    DB::update($sql, $params);
  }
}
