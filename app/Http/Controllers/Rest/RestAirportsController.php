<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Airport;
use DB;

class RestAirportsController extends Controller
{
    public function domestic()
    {
        $airports = DB::select("SELECT id,name,city,country, international, domestic, iana_timezone FROM airports WHERE domestic=1 ORDER BY city ASC");
        return $airports;
    }

    public function international()
    {
        $airports = DB::select("SELECT id,name,city,country, international, domestic, iana_timezone FROM airports WHERE international=1 ORDER BY country ASC, city ASC");
        return $airports;
    }
}
