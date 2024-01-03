<?php

namespace App\Console\Commands;

use App\Models\Location;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class InsertLatLngCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insert-lat-lng-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $api_url = 'https://geoapi.heartrails.com/api/json?method=searchByPostal&postal=';
        $offset = 0;
        $limit = 5000;
        //緯度経度インサート処理
        while (true) {
            $locations = Location::get_locations($offset, $limit);

            if (empty($locations)) {
                break;
            }

            foreach ($locations as $location) {
                $curl = curl_init();
                $location_id = $location->id;
                curl_setopt($curl, CURLOPT_URL, $api_url . $location->postal_code);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $res = curl_exec($curl);
                $data = json_decode($res);
                if (isset($data->response->error)) {
                    Log::error($data->response->error);
                    continue;
                }
                if (isset($data->response)) {
                    $info = $data->response->location[0];
                    $lat = $info->y; // 緯度
                    $lng = $info->x; // 経度

                    Location::update_lat_lng($location_id, $lat, $lng);
                } else {
                    $info = $data;
                    $aa = 'tees';
                }
                sleep(1);
            }

            $offset += $limit;
            echo "{$offset}: 完了\n";
        }
    }
}
