<?php

namespace App\Domain\Location\Infrastructure\Repository;

use App\Domain\Location\Domain\Entity\LocationEntity;
use App\Domain\Location\Domain\Repository\LocationRepositoryInterface;
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
    $sql = 'SELECT * FROM ' . $this->locationTableName . ' ORDER BY RAND() LIMIT 1';
    return DB::selectOne($sql);
  }
}
