<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Location extends Model
{
    use HasFactory;

    /**
     * ロケーションを返す
     *
     * @param [int] $offset
     * @return array
     */
    public static function get_locations($offset, $limit)
    {
        $params = [
            'limit' => $limit,
            'offset' => $offset
        ];

        $limit = 5000;
        $sql = 'SELECT * FROM locations' . PHP_EOL;
        $sql .= ' WHERE latitude IS NULL OR longitude IS NULL' . PHP_EOL;
        $sql .= ' LIMIT :offset, :limit';

        return DB::select($sql, $params);
    }

    public static function update_lat_lng($id, $lat, $lng)
    {
        $params = [
            'id' => $id,
            'lat' => $lat,
            'lng' => $lng
        ];

        $sql = 'UPDATE locations SET latitude = :lat, longitude = :lng WHERE id = :id';

        DB::update($sql, $params);
    }
}
