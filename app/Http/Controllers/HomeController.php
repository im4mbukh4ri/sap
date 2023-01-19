<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\SipContent;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	private $user;
	public function __construct(Request $request) {
		$this->middleware(['auth', 'csrf', 'upline:1', 'active:1', 'suspend:0']);
		$this->user = $request->user();

	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$user = $this->user;
		$services = null;
		if ($request->has('services')) {
			$services = $request->services;
		}
		$path_airport = storage_path() . "/json/airports.json";
		$path_airline = storage_path() . "/json/airlines.json";
		$path_station = storage_path() . "/json/stations.json";
		$path_railink = storage_path() . "/json/railink_stations.json";
		$path_hotel = storage_path() . "/json/hotel_domestik.json";
		$path_hotel_int = storage_path() . "/json/hotel_international.json";
		if (
			!File::exists($path_airport) ||
			!File::exists($path_airline) ||
			!File::exists($path_station) ||
			!File::exists($path_railink) ||
			!File::exists($path_hotel) ||
			!File::exists($path_hotel_int)
		) {
			throw new Exception("Invalid File");
		}
		$file_airport = File::get($path_airport);
		$file_airline = File::get($path_airline);
		$file_station = File::get($path_station);
		$file_railink = File::get($path_railink);
		$file_hotel = File::get($path_hotel);
		$file_hotel_int = File::get($path_hotel_int);
		$airports_decode = json_decode($file_airport, true);
		$airlines_decode = json_decode($file_airline, true);
		$stations_decode = json_decode($file_station, true);
		$railink_decode = json_decode($file_railink, true);
		$hotel_decode = json_decode($file_hotel, true);
		$hotel_int_decode = json_decode($file_hotel_int, true);
		$airports = $airports_decode['airport'];
		$airlines = $airlines_decode;
		$stations = $stations_decode;
		$railink_stations = $railink_decode;
		$hotel = $hotel_decode;
		$hotel_int = $hotel_int_decode;
		$cookie = Cookie::get('kuisioner');
		// Sets the cookie for the shopping cart if doesn't exist
		//  if (!$cookie) {
		//    Cookie::queue(
		//        'kuisioner',
		//        1, 60
		//    );
		// $questionnaires = Questionnaire::where('status','=',1)->get();
		// foreach ($questionnaires as $key => $questionnaire) {
		//   $statusRes = QuestionnaireResult::where('questionnaire_id','=',$questionnaire->id)->where('user_id','=',Auth()->user()->id)->first();
		//   if($statusRes === null && auth()->user()->type_user_id !==1){
		//     // ada kuisioner belum di isi
		//     $request->session()->flash('alert-success', 'Demi Meningkatkan Pelayanan, Kami meminta Anda untuk bersedia mengisi Kuisoner');
		//     break;
		//   }
		// }
		//  }
		return view('home', compact('airports', 'airlines', 'services', 'user', 'stations', 'railink_stations', 'hotel', 'hotel_int'));
	}
	public function term() {
		$content = SipContent::find(25);
		$sk = SipContent::find(82);
		$free = SipContent::find(121);
		return view('pages.term', compact('content', 'sk', 'free'));
	}
	public function faq() {
		$faq = array();
		$faq['deposit'] = SipContent::whereBetween('id', [54, 63])->orWhere('id', 122)->orWhere('id', 123)->get();
		$faq['airlines'] = SipContent::whereBetween('id', [64, 76])->orWhere('id', 93)->orWhere('id', 94)->orWhere('id', 111)->orWhere('id', 112)->get();
		$faq['ppob'] = SipContent::whereBetween('id', [77, 78])
			->orWhereBetween('id', [95, 99])
			->get();
		$faq['login'] = SipContent::whereBetween('id', [83, 86])->orWhere('id', 92)->get();
		$faq['trains'] = SipContent::whereBetween('id', [100, 110])->get();
		$faq['free_trial'] = SipContent::whereBetween('id', [113, 120])->get();
		return view('pages.faq', compact('faq'));
	}
	public function announcements() {
		$announcements = Announcement::all()->sortByDesc('created_at');
		return view('pages.announcement', compact('announcements'));
	}

}
