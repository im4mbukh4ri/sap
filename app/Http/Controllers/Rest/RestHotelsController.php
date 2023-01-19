<?php

namespace App\Http\Controllers\Rest;

use App\HotelCity;
use App\Http\Controllers\Controller;

class RestHotelsController extends Controller {
	public function city() {
		$cities = HotelCity::all(['id', 'city']);
		return $cities;
	}
}
