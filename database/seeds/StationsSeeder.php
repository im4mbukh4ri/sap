<?php

use Illuminate\Database\Seeder;
class StationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $path_station = storage_path() . "/json/stations.json";
        if (!File::exists($path_station)) {
            throw new Exception("Invalid File");
        }
        $file_station = File::get($path_station);
        $stations= json_decode($file_station,true);

        foreach ($stations as $key => $station) {
          App\Station::create([
            "code"=>$station["code"],
            "name"=>$station["name"],
            "city"=>$station["city"]
          ]);
        }
    }
}
