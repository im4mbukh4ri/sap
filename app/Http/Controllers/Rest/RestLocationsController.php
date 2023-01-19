<?php

namespace App\Http\Controllers\Rest;
use App\City;
use App\Http\Controllers\Controller;
use App\Province;
use App\Subdistrict;
use Illuminate\Http\Request;

class RestLocationsController extends Controller {
	//
	public function getProvinces() {
		$provinces = Province::all();
		return $provinces;
	}
	public function getCities(Request $request) {
		$this->validate($request, [
			'province_id' => 'required|numeric',
		]);
		$cities = City::where('province_id', $request->province_id)->get();
		return $cities;
	}
	public function getSubdistrict(Request $request) {
		$this->validate($request, [
			'subdistrict_id' => 'required|numeric',
		]);
		$subdistricts = Subdistrict::where('city_id', $request->subdistrict_id)->get();
		return $subdistricts;
	}
}
