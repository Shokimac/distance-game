<?php

namespace App\Domain\Location\Infrastructure\Repository;

use App\Domain\Location\Domain\Repository\GeoLocationAPIInterface;
use App\Domain\Location\Domain\ValueObject\PostalCode;
use Illuminate\Support\Facades\Log;

final class GeoLocationAPIRepository implements GeoLocationAPIInterface
{
  private $apiUrl;

  public function __construct()
  {
    $this->apiUrl =  'https://geoapi.heartrails.com/api/json?method=searchByPostal&postal=';
  }

  public function getLocationByGeoAPI(PostalCode $postalCode): array
  {
    try {
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $this->apiUrl . $postalCode->value());
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $data = json_decode(curl_exec($curl));
      if (isset($data->response->error)) {
        Log::error('指定の郵便番号にヒットする地域はありません');
        Log::error($data->response->error);
        return ['error' => $data->response->error];
      }
      return ['value' => $data->response->location[0]];
    } catch (\Throwable $th) {
      Log::error('通信に失敗しました');
      Log::error($th->getMessage());
      return ['error' => 'failed'];
    }
  }
}
