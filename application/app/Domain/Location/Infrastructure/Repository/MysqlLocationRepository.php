<?php

namespace App\Domain\Location\Infrastructure\Repository;

use App\Domain\Location\Domain\Entity\LocationEntity;
use App\Domain\Location\Domain\Repository\LocationRepositoryInterface;
use App\Domain\Location\Domain\ValueObject\LocationId;
use App\Domain\Location\Domain\ValueObject\PostalCode;
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

  public function findByPostalCoce(PostalCode $postalCode)
  {
    $params = ['postalCode' => $postalCode->value()];
    $sql = 'SELECT * FROM ' . $this->locationTableName . ' WHERE postal_code = :postalCode';

    return DB::selectOne($sql, $params);
  }

  public function findLocationsByHeadPostalCode(PostalCode $postalCode)
  {
    $sql = "SELECT * FROM " . $this->locationTableName . " WHERE postal_code LIKE '{$postalCode->headValue()}%'";

    return DB::select($sql);
  }

  public function findByLocationIds(array $locationIds)
  {
    return DB::table($this->locationTableName)->select()->whereIn('id', $locationIds)->get()->all();
  }

  public function findLocationsByHeadPostalCodeRange(int $from, int $to)
  {
    $sql = 'SELECT * FROM ' . $this->locationTableName . PHP_EOL;
    $sql .= 'WHERE ' . PHP_EOL;
    $sql .= "postal_code LIKE '{$from}%' OR postal_code LIKE '{$to}%'";

    return DB::select($sql);
  }
}
