<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Station;
use App\RailinkStation;
class RestStationsController extends Controller
{
    //
    public function train(){
      $stations=Station::all();
      return $stations;
    }
    public function railink(){
      $stations=RailinkStation::all();
      return $stations;
    }
}
