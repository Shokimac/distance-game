<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder

{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = __DIR__ . '/sql/insert_locations.sql';
        DB::unprepared(file_get_contents($path));
    }
}
