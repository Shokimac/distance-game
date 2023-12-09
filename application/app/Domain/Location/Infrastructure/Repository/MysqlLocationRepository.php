<?php

namespace App\Domain\Location\Infrastructure\Repository;

use App\Domain\Location\Domain\Entity\LocationEntity;
use App\Domain\Location\Domain\Repository\LocationRepositoryInterface;
use App\Domain\Location\Domain\ValueObject\LocationId;
use App\Models\Location as LocationModel;
use Illuminate\Support\Facades\DB;

final class MysqlLocationRepository implements LocationRepositoryInterface
{
  private $locationTableName;

  public function __construct(LocationModel $locationModel)
  {
    $this->locationTableName = $locationModel->getTable();
  }

  public function findRandomLocation()
  {
    $sql = 'SELECT * FROM ' . $this->locationTableName . ' WHERE latitude IS NOT NULL AND longitude IS NOT NULL ORDER BY RAND() LIMIT 1';
    return DB::selectOne($sql);
  }

  public function find(LocationId $locationId)
  {
    $params = ['id' => $locationId->value()];
    $sql = 'SELECT * FROM ' . $this->locationTableName . ' WHERE id = :id';

    return DB::selectOne($sql, $params);
  }
}
