<?php

use Illuminate\Database\Seeder;

class AirportRevissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $airports = \App\Airport::all();
        foreach ($airports as $airport) {
            $name = ucwords(strtolower($airport->name));
            $airport->name = $name;
            $timezone = \Illuminate\Support\Facades\DB::table("timezone_by_iata")->where("iata", "=", $airport->id)->first();
            if ($timezone) {
                $airport->iana_timezone = $timezone->iana_timezone;
                $airport->windows_timezone = $timezone->windows_timezone;
            }
            $airport->save();
        }
    }
}
