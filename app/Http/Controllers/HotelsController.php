<?php

namespace App\Http\Controllers;

use App\Helpers\Deposit\Deposit;
use App\Helpers\Point\Point;
use App\Helpers\SipHotel;
use App\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use JavaScript;
use Log;
use DB;

class HotelsController extends Controller {
	protected $rqid;
	protected $mmid;
	protected $action;
	protected $app;
	public function __construct() {
		$this->middleware(['auth', 'active:1', 'csrf', 'suspend:0']);
		$this->rqid = config('sip-config')['rqid'];
		$this->mmid = config('sip-config')['mmid'];
		$this->app = 'information';
	}
	public function getSearchPage(Request $request) {
		if ($request->hotel_type == 'domestik') {
			if ($request->domesticDes == '') {
				flash()->overlay('Kota tujuan wajib diisi.');
				return redirect()->back();
			}
			$request->request->add(['des' => $request->domesticDes]);
		} else {
			if ($request->intDes == '') {
				flash()->overlay('Kota tujuan wajib diisi.');
				return redirect()->back();
			}
			$request->request->add(['des' => $request->intDes]);
		}
		JavaScript::put([
			'request' => $request->all(),
			'url' => route('hotels.search_hotel'),
			'url_keyword' => route('hotels.search_hotel_by_keyword'),
			'url_next' => route('hotels.search_hotel_by_next'),
			'url_sort' => route('hotels.search_hotel_sort'),
			'url_detail' => route('hotels.hotel_detail'),
		]
		);
		return view('hotels.result-search');
	}

	public function search(Request $request) {
		$param = [
			'mmid' => $this->mmid,
			'rqid' => $this->rqid,
			'action' => 'search_hotel',
			'app' => $this->app,
			'checkin' => date('Y-m-d', strtotime($request->checkin_date)),
			'checkout' => date('Y-m-d', strtotime($request->checkout_date)),
			'des' => $request->des,
			'room' => $request->room,
			'roomtype' => $request->roomtype,
			'adt' => $request->adt,
			'chd' => $request->chd,
		];
		if ((int) $param['adt'] > (int) $param['room']) {
			$param['adt'] = 2;
		} else {
			$param['adt'] = 1;
		}
		$param = json_encode($param);
		$response = SipHotel::search($param)->get();
		return $response;
	}
	public function searchByKeyword(Request $request) {
		$param = [
			'mmid' => $this->mmid,
			'rqid' => $this->rqid,
			'action' => 'search_keyword',
			'app' => $this->app,
			'checkin' => date('Y-m-d', strtotime($request->checkin_date)),
			'checkout' => date('Y-m-d', strtotime($request->checkout_date)),
			'des' => $request->des,
			'room' => $request->room,
			'roomtype' => $request->roomtype,
			'adt' => $request->adt,
			'chd' => $request->chd,
			'keyword' => $request->keyword,
			'next' => $request->next,
		];
		$param = json_encode($param);
		$response = SipHotel::search($param)->get();
		return $response;
	}
	public function searchByNext(Request $request) {
		$param = [
			'mmid' => $this->mmid,
			'rqid' => $this->rqid,
			'action' => 'search_next',
			'app' => $this->app,
			'checkin' => date('Y-m-d', strtotime($request->checkin_date)),
			'checkout' => date('Y-m-d', strtotime($request->checkout_date)),
			'des' => $request->des,
			'room' => $request->room,
			'roomtype' => $request->roomtype,
			'adt' => $request->adt,
			'chd' => $request->chd,
			'next' => $request->next,
		];
		$param = json_encode($param);
		$response = SipHotel::search($param)->get();
		return $response;
	}
	public function searchBySort(Request $request) {
		$param = [
			'mmid' => $this->mmid,
			'rqid' => $this->rqid,
			'action' => 'sortir',
			'app' => $this->app,
			'checkin' => date('Y-m-d', strtotime($request->checkin_date)),
			'checkout' => date('Y-m-d', strtotime($request->checkout_date)),
			'des' => $request->des,
			'room' => $request->room,
			'roomtype' => $request->roomtype,
			'adt' => $request->adt,
			'chd' => $request->chd,
			'next' => $request->next,
			'sortby' => $request->sort_by,
			'jns' => $request->type,
		];
		$param = json_encode($param);
		$response = SipHotel::search($param)->get();
		return $response;
	}
	public function hotelDetail(Request $request) {
		$param = [
			'mmid' => $this->mmid,
			'rqid' => $this->rqid,
			'action' => 'detail_hotel',
			'app' => $this->app,
			'selectedID' => $request->selectedID,
		];
		$param = json_encode($param);
		$hotel = SipHotel::detail($param)->get();
		Log::info($hotel);
		if ($hotel['error_code'] == '000') {
			$dataHotel = Hotel::firstOrCreate([
				'hotel_city_id' => $hotel['des'],
				'name' => $hotel['details']['data']['name'],
				'rating' => $hotel['details']['data']['rating'],
				'address' => $hotel['details']['data']['address'],
				'email' => $hotel['details']['data']['email'],
				'website' => $hotel['details']['data']['website'],
				'url_image' => (isset($hotel['details']['images'][0])) ? $hotel['details']['images'][0] : 'https://mysmartinpays.com/assets/images/material/unavailable.jpg',
			]);
			foreach ($hotel['details']['rooms'] as $key => $room) {
				$dataRoom = $dataHotel->rooms()->firstOrCreate([
					'name' => $room['characteristic'],
					'bed' => $room['bed'],
					'board' => $room['board'],
				]);
				$fare = \App\HotelRoomFare::find($room['selectedIDroom']);
				if (!$fare) {
					$dataRoom->fares()->save(new \App\HotelRoomFare([
						'selected_id' => $hotel['selectedID'],
						'selected_id_room' => $room['selectedIDroom'],
						'checkin' => $hotel['checkin'],
						'checkout' => $hotel['checkout'],
						'price' => $room['price'],
						'nta' => $room['nta'],
					]));
				} else {
					$fare->selected_id = $hotel['selectedID'];
					$fare->checkin = $hotel['checkin'];
					$fare->checkout = $hotel['checkout'];
					$fare->price = $room['price'];
					$fare->nta = $room['nta'];
					$fare->save();
				}
			}
			return view('hotels.detail-hotel', compact('hotel'));
		}
		flash()->overlay('Gagal mendapatkan data hotel terbaru. Silahkan pilih hotel lain.', 'INFO');
		return redirect()->back();
	}
	public function pageConfirmation(Request $request) {
		$hotel = json_decode($request->result, true);
		$price = 0;
		for ($i = 1; $i <= (int) $hotel['room']; $i++) {
			foreach ($hotel['details']['rooms'] as $key => $room) {
				if ($room['selectedIDroom'] == $request['bed_' . $i]) {
					$price = $price + (int) $room['price'];
				}
			}
		}
		$user = $request->user();
		$request->request->add(['result' => '']);
		$request = $request->all();
		Cookie::queue($user->id . 'HoteloCookie' . $hotel['selectedID'], $price);
		JavaScript::put([
			'request' => $request,
			'url' => route('hotels.hotel_booking_issued'),
		]);
		return view('hotels.confirmation', compact('request', 'hotel', 'user', 'price'));
	}
	public function bookingIssued(Request $request) {
		$this->validate($request, [
			'adt' => 'required|numeric',
			'chd' => 'required|numeric',
			'checkin' => 'required|date',
			'checkout' => 'required|date',
			'des' => 'required|exists:hotel_cities,id',
			'name' => 'required',
			'password' => 'required',
			'phoneNumber' => 'required',
			'pr' => 'required|numeric|min:0|max:3',
			'room' => 'required|numeric|min:0',
			'selectedID' => 'required|numeric|exists:hotel_room_fares,selected_id',
			'title' => 'required',
		]);
		$credentials = ['username' => $request->user()->username, 'password' => $request->password];
		$userLogin = Auth::once($credentials);
		if ($userLogin) {
			$issuedValidation = $this->issuedValidation($request, $request->user());
			if (!$issuedValidation) {
				return [
					'status' => [
						'code' => 400,
						'confirm' => 'failed',
						'message' => 'Issued gagal. Telah ditemukan transaksi dengan data yang sama..',
					],
				];
			}
			if ((int) $request->pr > 3) {
				return [
					'status' => [
						'code' => 400,
						'confirm' => 'failed',
						'message' => array('Proses gagal.'),
					],
				];
			}
			$price = 0;
			$bed = array();
			$beds = array();
			$hotelId = 1;
			for ($i = 1; $i <= (int) $request->room; $i++) {
				$this->validate($request, [
					'bed_' . $i => 'required|exists:hotel_room_fares,selected_id_room',
				]);
				$dataFare = \App\HotelRoomFare::find($request->get('bed_' . $i));
				$price = $price + $dataFare->price;
				$bed[] = $request->get('bed_' . $i);
				$beds[] = $dataFare->hotel_room->id;
				$hotelId = $dataFare->hotel_room->hotel_id;
			}
			if ((int) $request->pr > 0) {
				$point = Point::check($request->user()->id, (int) $request->pr)->get();
				if (!$point) {
					return [
						'status' => [
							'code' => 400,
							'confirm' => 'failed',
							'message' => 'Proses issued gagal. Periksa kembali point Anda / Refresh halaman ini. Terimakasih.',
						],
					];
				}
			}
			$prValue = \App\PointValue::find(1)->idr;
			$pr = (int) $request->pr * $prValue;
			if (!Deposit::check($request->user()->id, $price - $pr)->get()) {
				return [
					'status' => [
						'code' => 400,
						'confirm' => 'failed',
						'message' => 'Proses issued gagal. Saldo Anda tidak cukup.',
					],
				];
			}
			$implodeBed = implode(',', $bed);
			$param = [
				'mmid' => $this->mmid,
				'app' => 'transaction',
				'rqid' => $this->rqid,
				'action' => 'bookingIssued',
				'hotel_id' => $hotelId,
				'checkin' => $request->checkin,
				'checkout' => $request->checkout,
				'adt' => (int) $request->adt,
				'chd' => (int) $request->chd,
				'inf' => 0,
				'room' => (int) $request->room,
				'total_fare' => $price,
				'pr' => $pr,
				'device' => 'web',
				'beds' => $beds,
				'selectedID' => $request->selectedID,
				'selectedIDroom' => $implodeBed,
				'titguest' => $request->title,
				'nmguest' => $request->name,
				'hpguest' => $request->phoneNumber,
				'noteguest' => trim($request->note),
				'point' => (int) $request->pr,
			];
			$response = SipHotel::createTransaction($request->user()->id, $param)->get();
			return $response;
		}
		return [
			'status' => [
				'code' => 401,
				'confirm' => 'failed',
				'message' => 'Password Anda salah!',
			],
		];
	}
	public function report(Request $request) {
		$from = date("Y-m-d", time());
		$until = date("Y-m-d", time());
		$statusReq = $request->status;
		if ($request->has('from') && $request->has('until')) {
			$from = date('Y-m-d', strtotime($request->from));
			$until = date('Y-m-d', strtotime($request->until));
			$transactions = $request->user()->hotel_transactions()->where('status', 'LIKE', '%' . $statusReq . '%')
				->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('created_at');
			$request->flash();
		} else {
			$transactions = $request->user()->hotel_transactions()->where('status', 'LIKE', '%' . $statusReq . '%')
				->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('created_at');
		}
		$totalAmount = DB::select("SELECT SUM(hotel_transactions.total_fare) as total_marketprice, SUM(hotel_commissions.bv) as total_smartpoint, SUM(hotel_commissions.member) as total_smarcash FROM hotel_transactions
					INNER JOIN hotel_commissions ON hotel_transactions.id = hotel_commissions.hotel_transaction_id
					WHERE hotel_transactions.created_at BETWEEN '{$from} 00:00:00' AND '{$until} 23:59:59' AND hotel_transactions.user_id = '{$request->user()->id}' AND hotel_transactions.status LIKE '%{$statusReq}%'");
		$from = date('d-m-Y', strtotime($from));
		$until = date('d-m-Y', strtotime($until));
		JavaScript::put([
			'request' => [
				'from' => $from,
				'until' => $until,
			],
		]);
		return view('hotels.reports.index', compact('transactions', 'request','totalAmount','statusReq'));
	}
	public function issuedValidation($request, $user) {
		$guests = \App\HotelGuest::where('name', '=', $request->name)->get();
		if ($guests) {
			foreach ($guests as $key => $guest) {
				$transaction = $guest->transaction;
				if ($transaction->user_id == $user->id) {
					if ($transaction->status == 'issued' || $transaction->status == 'process' || $transaction->status == 'waiting-issued') {
						if ($transaction->checkin == $request->checkin) {
							$hotelFare = \App\HotelRoomFare::where('selected_id', '=', $request->selectedID)->first();
							if ($hotelFare->hotel_room->hotel_id == $transaction->hotel_id) {
								return false;
							}
						}
					}
				}
			}
			return true;
		}
		return true;
	}
}
