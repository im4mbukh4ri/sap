<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\Point\Point;
use App\Helpers\SipRailink;
use App\Http\Controllers\Controller;
use App\OauthAccessToken;
use App\OauthClientSecret;
use App\PointValue;
use App\RailinkSchedule;
use App\RailinkScheduleFare;
use App\TrainTransaction;
use Illuminate\Http\Request;
use Log;
use Response;
use Validator;

class ApiRailinksController extends Controller {
	//
	private $rqid;
	private $mmid;
	private $app;
	private $action;
	private $confirmSuccess = 'success';
	private $confirmFailed = 'failed';
	private $codeSuccess = 200;
	private $codeFailed = 400;
	private $statusMessage;

	public function __construct(Request $request) {
		$this->rqid = config('sip-config')['rqid'];
		$this->mmid = config('sip-config')['mmid'];
//		if ($request->hasHeader('authorization')) {
//			$token = explode(' ', $request->header('authorization'));
//			$newTime = time() + 259200;
//			$accessToken = OauthAccessToken::find($token[1]);
//			$accessToken->expire_time = $newTime;
//			$accessToken->save();
//		}
//		if ($request->has('access_token')) {
//			$newTime = time() + 259200;
//			$accessToken = OauthAccessToken::find($request->access_token);
//			$accessToken->expire_time = $newTime;
//			$accessToken->save();
//		}
	}
	public function getSchedule(Request $request) {
		$validator = Validator::make($request->all(), [
			'client_id' => 'required',
			'org' => 'required',
			'des' => 'required',
			'trip' => 'required',
			'tgl_dep' => 'required|date',
			'adt' => 'required',
			'chd' => 'required',
			'inf' => 'required',
		]);
		if ($validator->fails()) {
			$this->setStatusMessage($validator->errors());
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			]);
		}
		$client = OauthClientSecret::where('client_id', $request->client_id)->first();
		if (!$client) {
			$this->setStatusMessage(['Anda tidak terdaftar', 'clinet_id tidak ditemukan']);
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
		$param = [
			'rqid' => $this->rqid,
			'mmid' => $this->mmid,
			'action' => 'get_schedule',
			'app' => 'information',
			'org' => $request->org,
			'des' => $request->des,
			'trip' => $request->trip,
			'tgl_dep' => $request->tgl_dep,
			'adt' => $request->adt,
			'chd' => $request->chd,
			'inf' => $request->inf,
		];
		if ($request->trip == "R") {
			$param['tgl_ret'] = $request->tgl_ret;
		}
		$schedule = SipRailink::GetSchedule(json_encode($param))->get();
		if ($schedule['error_code'] == "000") {
			foreach ($schedule['schedule']['departure'] as $key => $value) {
				$saveSchedule = RailinkSchedule::firstOrCreate([
					'train_name' => $value['TrainName'],
					'train_number' => $value['TrainNo'],
					'origin' => $value['STD'],
					'destination' => $value['STA'],
					'etd' => $value['ETD'],
					'eta' => $value['ETA'],
				]);
				foreach ($value['Fares'] as $val => $fare) {
					$find = RailinkScheduleFare::find($fare['selectedIDdep']);
					if (!$find) {
						$saveSchedule->fares()->save(
							new RailinkScheduleFare([
								'id' => $fare['selectedIDdep'],
								'class' => $fare['Class'],
								'subclass' => $fare['SubClass'],
								'seat_avb' => $fare['SeatAvb'],
								'total_fare' => $fare['TotalFare'],
								'price_adt' => $fare['priceAdt'],
								'price_chd' => $fare['priceChd'],
								'price_inf' => $fare['priceInf'],
							])
						);
					} else {
						$find->class = $fare['Class'];
						$find->subclass = $fare['SubClass'];
						$find->seat_avb = $fare['SeatAvb'];
						$find->total_fare = $fare['TotalFare'];
						$find->price_adt = $fare['priceAdt'];
						$find->price_chd = $fare['priceChd'];
						$find->price_inf = $fare['priceInf'];
						$find->save();
					}
				}
			}
			if ($request->trip == "R") {
				foreach ($schedule['schedule']['return'] as $key => $value) {
					$saveSchedule = RailinkSchedule::firstOrCreate([
						'train_name' => $value['TrainName'],
						'train_number' => $value['TrainNo'],
						'origin' => $value['STD'],
						'destination' => $value['STA'],
						'etd' => $value['ETD'],
						'eta' => $value['ETA'],
					]);
					foreach ($value['Fares'] as $val => $fare) {
						$find = RailinkScheduleFare::find($fare['selectedIDret']);
						if (!$find) {
							$saveSchedule->fares()->save(
								new \App\RailinkScheduleFare([
									'id' => $fare['selectedIDret'],
									'class' => $fare['Class'],
									'subclass' => $fare['SubClass'],
									'seat_avb' => $fare['SeatAvb'],
									'total_fare' => $fare['TotalFare'],
									'price_adt' => $fare['priceAdt'],
									'price_chd' => $fare['priceChd'],
									'price_inf' => $fare['priceInf'],
								])
							);
						} else {
							$find->class = $fare['Class'];
							$find->subclass = $fare['SubClass'];
							$find->seat_avb = $fare['SeatAvb'];
							$find->total_fare = $fare['TotalFare'];
							$find->price_adt = $fare['priceAdt'];
							$find->price_chd = $fare['priceChd'];
							$find->price_inf = $fare['priceInf'];
							$find->save();
						}

					}
				}
			}
			$response = [
				'queries' => [
					'trip' => $request->trip,
					'org' => $request->org,
					'des' => $request->des,
					'tgl_dep' => $request->tgl_dep,
					'adt' => $request->adt,
					'chd' => $request->chd,
					'inf' => $request->inf,
				],
				'schedule' => $schedule['schedule'],
			];
			if ($request->trip == "R") {
				$response['queries']['tgl_ret'] = $request->tgl_ret;
			}
			$this->setStatusMessage("Success get schedule");
			return Response::json([
				'status' => [
					'code' => $this->getCodeSuccess(),
					'confirm' => $this->getConfirmSuccess(),
					'message' => $this->getStatusMessage(),
				],
				'details' => $response,
			], 200);
		}
		$this->setStatusMessage($schedule['error_msg']);
		return Response::json([
			'status' => [
				'code' => $this->getCodeFailed(),
				'confirm' => $this->getConfirmFailed(),
				'message' => $this->getStatusMessage(),
			],
		], 400);
	}
	public function getSeat(Request $request) {
		$validator = Validator::make($request->all(), [
			'client_id' => 'required',
			'org' => 'required',
			'des' => 'required',
			'trip' => 'required',
			'tgl_dep' => 'required|date',
			'adt' => 'required',
			'chd' => 'required',
			'inf' => 'required',
		]);
		if ($validator->fails()) {
			$this->setStatusMessage($validator->errors());
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			]);
		}
		$client = OauthClientSecret::where('client_id', $request->client_id)->first();
		if (!$client) {
			$this->setStatusMessage(['Anda tidak terdaftar', 'clinet_id tidak ditemukan']);
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
		$param = [
			'rqid' => $this->rqid,
			'mmid' => $this->mmid,
			'action' => 'get_seat',
			'app' => 'information',
			'org' => $request->org,
			'des' => $request->des,
			'trip' => $request->trip,
			'tgl_dep' => $request->tgl_dep,
			'adt' => $request->adt,
			'chd' => $request->chd,
			'inf' => $request->inf,
			'selectedIDdep' => $request->selectedIDdep,
		];
		$queries = [
			'trip' => $request->trip,
			'org' => $request->org,
			'des' => $request->des,
			'tgl_dep' => $request->tgl_dep,
			'adt' => $request->adt,
			'chd' => $request->chd,
			'inf' => $request->inf,
			'selectedIDdep' => $request->selectedIDdep,
		];
		// $admin=\App\TrainAdminFee::find(1)->admin;
		$admin = 0;
		if ($request->trip == "R") {
			$param['tgl_ret'] = $request->tgl_ret;
			$param['selectedIDret'] = $request->selectedIDret;
			$queries['tgl_ret'] = $request->tgl_ret;
			$queries['selectedIDret'] = $request->selectedIDret;
			$admin *= 2;
		}
		$seat = SipRailink::GetSeat(json_encode($param))->get();
		if ($seat['error_code'] == '000') {
			$response = [
				'queries' => $queries,
				'admin' => $admin,
				'seat' => $seat['seat'],
			];
			$this->setStatusMessage("Success get seat");
			return Response::json([
				'status' => [
					'code' => $this->getCodeSuccess(),
					'confirm' => $this->getConfirmSuccess(),
					'message' => $this->getStatusMessage(),
				],
				'details' => $response,
			], 200);
		}
		$this->setStatusMessage($seat['error_msg']);
		return Response::json([
			'status' => [
				'code' => $this->getCodeFailed(),
				'confirm' => $this->getConfirmFailed(),
				'message' => $this->getStatusMessage(),
			],
		], 400);
	}
	public function bookingIssued(Request $request) {
		$validator = Validator::make($request->all(), [
			'client_id' => 'required',
			'org' => 'required',
			'des' => 'required',
			'trip' => 'required',
			'tgl_dep' => 'required|date',
			'adt' => 'required',
			'chd' => 'required',
			'inf' => 'required',
			'selectedIDdep' => 'required',
			'cpname' => 'required',
			'cpmail' => 'required',
			'cptlp' => 'required',
			'pr' => 'required|numeric',
			'nmadt_1' => 'required',
			'hpadt_1' => 'required',
			'idadt_1' => 'required',
			'seatadt_1' => 'required',
		]);
		if ($validator->fails()) {
			$this->setStatusMessage($validator->errors());
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			]);
		}
		if ((int) $request->pr > 3) {
			$this->setStatusMessage('Point reward yang digunakan tidak boleh lebih dari 3.');
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			]);
		}
		if ($request->trip == "R") {
			$validator = Validator::make($request->all(), [
				'tgl_ret' => 'required|date',
				'selectedIDret' => 'required',
			]);
			if ($validator->fails()) {
				$this->setStatusMessage($validator->errors());
				return Response::json([
					'status' => [
						'code' => $this->getCodeFailed(),
						'confirm' => $this->getConfirmFailed(),
						'message' => $this->getStatusMessage(),
					],
				]);
			}
		}
		if ((int) $request->inf > 0) {
			$validator = Validator::make($request->all(), [
				'nminf_1' => 'required',
				'seatinf_1' => 'required',
			]);
			if ($validator->fails()) {
				$this->setStatusMessage($validator->errors());
				return Response::json([
					'status' => [
						'code' => $this->getCodeFailed(),
						'confirm' => $this->getConfirmFailed(),
						'message' => $this->getStatusMessage(),
					],
				]);
			}
		}
		$client = OauthClientSecret::where('client_id', $request->client_id)->first();
		if (!$client) {
			$this->setStatusMessage(['Anda tidak terdaftar', 'clinet_id tidak ditemukan']);
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
		$user = $client->user;
		$selectedDep = RailinkScheduleFare::find($request->selectedIDdep);
		$prValue = PointValue::find(1)->idr;
		$point = Point::check($user->id, (int) $request->pr)->get();
		if (!$point) {
			$this->setStatusMessage('Proses issued gagal. Periksa kembali point Anda / Refresh halaman ini. Terimakasih.');
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
		$param = [
			'rqid' => $this->rqid,
			'app' => "transaction",
			'action' => "bookingIssued",
			'mmid' => $this->mmid,
			'org' => $request->org,
			'des' => $request->des,
			'trip' => $request->trip,
			'tgl_dep' => $request->tgl_dep,
			'adt' => $request->adt,
			'chd' => $request->chd,
			'inf' => $request->inf,
			'selectedIDdep' => $request->selectedIDdep,
			'cpname' => $request->cpname,
			'cpmail' => $request->cpmail,
			'cptlp' => $request->cptlp,
			'indexFare' => 0,
		];
		$param['pr'] = (int) $request->pr * $prValue;
		if ($param['pr'] > 0) {
			$param['point'] = $request->pr;
		}
		for ($i = 1; $i <= 7; $i++) {
			if ($request->has('nmadt_' . $i)) {
				$seat = explode(',', $request->get('seatadt_' . $i));
				$param['nmadt_' . $i] = $request->get('nmadt_' . $i);
				$param['hpadt_' . $i] = $request->get('hpadt_' . $i);
				$param['idadt_' . $i] = $request->get('idadt_' . $i);
				$param['departure']['seatadt_' . $i] = $seat[0];
			} else {
				break;
			}
		}
		if ((int) $request->inf > 0) {
			for ($i = 1; $i <= 7; $i++) {
				if ($request->has('nminf_' . $i)) {
					$seat = explode(',', $request->get('seatinf_' . $i));
					$param['nminf_' . $i] = $request->get('nminf_' . $i);
					$param['departure']['seatinf_' . $i] = $seat[0];
				} else {
					break;
				}
			}
		}
		$param['totalFare'] = $selectedDep->total_fare;
		$param['result'] = [
			'departure' => [
				'TrainNo' => $selectedDep->schedule->train_number,
				'TrainName' => $selectedDep->schedule->train_name,
				'STD' => $selectedDep->schedule->origin,
				'STD' => $selectedDep->schedule->destination,
				'ETD' => $selectedDep->schedule->etd,
				'ETA' => $selectedDep->schedule->eta,
				'Fares' => array([
					'SubClass' => $selectedDep->subclass,
					'Class' => $selectedDep->class,
					'TotalFare' => $selectedDep->total_fare,
					'priceAdt' => $selectedDep->price_adt,
					'priceChd' => $selectedDep->price_chd,
					'priceInf' => $selectedDep->price_inf,
					'selectedIDdep' => $selectedDep->id,
				]),
			],
		];
		$param['admin'] = 0;
		$param['adminDep'] = 0;
		if ($request->trip == "R") {
			$param['adminRet'] = 0;
			$param['indexFareRet'] = 0;
			$selectedRet = RailinkScheduleFare::find($request->selectedIDret);
			$param['selectedIDret'] = $request->selectedIDret;
			$param['tgl_ret'] = $request->tgl_ret;
			$param['totalFareRet'] = $selectedRet->total_fare;
			for ($i = 1; $i <= 7; $i++) {
				if ($request->has('nmadt_' . $i)) {
					$seat = explode(',', $request->get('seatadt_' . $i));
					if (count($seat) < 2) {
						$this->setStatusMessage('Seat return penumpang dewasa kosong.');
						return Response::json([
							'status' => [
								'code' => $this->getCodeFailed(),
								'confirm' => $this->getConfirmFailed(),
								'message' => $this->getStatusMessage(),
							],
						], 400);
					}
					$param['return']['seatadt_' . $i] = $seat[1];
				} else {
					break;
				}
			}
			if ((int) $request->inf > 0) {
				for ($i = 1; $i <= 7; $i++) {
					if ($request->has('nminf_' . $i)) {
						$seat = explode(',', $request->get('seatinf_' . $i));
						if (count($seat) < 2) {
							$this->setStatusMessage('Seat return penumpang bayi kosong.');
							return Response::json([
								'status' => [
									'code' => $this->getCodeFailed(),
									'confirm' => $this->getConfirmFailed(),
									'message' => $this->getStatusMessage(),
								],
							], 400);
						}
						$param['return']['seatinf_' . $i] = $seat[1];
					} else {
						break;
					}
				}
			}
			$param['result']['return'] = [
				'TrainNo' => $selectedRet->schedule->train_number,
				'TrainName' => $selectedRet->schedule->train_name,
				'STD' => $selectedRet->schedule->origin,
				'STD' => $selectedRet->schedule->destination,
				'ETD' => $selectedRet->schedule->etd,
				'ETA' => $selectedRet->schedule->eta,
				'Fares' => array([
					'SubClass' => $selectedRet->subclass,
					'Class' => $selectedRet->class,
					'TotalFare' => $selectedRet->total_fare,
					'priceAdt' => $selectedRet->price_adt,
					'priceChd' => $selectedRet->price_chd,
					'priceInf' => $selectedRet->price_inf,
					'selectedIDret' => $selectedRet->id,
				]),
			];
		}
		$param['service_id'] = 4;
		$param['device'] = $client->device_type;
		// return $param;
		Log::info($param);
		$result = SipRailink::CreateTransaction($user->id, $param)->get();

		//return $result;
		if ($result['status']['code'] == 200) {
			$this->setStatusMessage("BookingIssued Success");
			return Response::json([
				'status' => [
					'code' => $this->getCodeSuccess(),
					'confirm' => $this->getConfirmSuccess(),
					'message' => $this->getStatusMessage(),
				],
				'details' => $result['response']['transaction']['attributes'],
			], 200);
		} else {
			$this->setStatusMessage($result['status']['message']);
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
	}

	public function reports(Request $request) {
		$client = OauthClientSecret::where('client_id', $request->client_id)->first();
		if (!$client) {
			$this->setStatusMessage(['Anda tidak terdaftar', 'clinet_id tidak ditemukan']);
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
		$userId = $client->user->id;
		if ($request->has('start_date') && $request->has('end_date')) {
			$from = date('Y-m-d', strtotime($request->start_date));
			$until = date('Y-m-d', strtotime($request->end_date));
			if (daysDifference($until, $from) > 31) {
				$this->setStatusMessage('Report railink yang bisa Anda cek maksimal 31 hari.');
				return Response::json([
					'status' => [
						'code' => $this->getCodeFailed(),
						'confirm' => $this->getConfirmFailed(),
						'message' => $this->getStatusMessage(),
					],
				]);
			}
			$transactions = TrainTransaction::where('user_id', $userId)->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get();
			$results = array();
			if (count($transactions) > 0) {
				foreach ($transactions as $transaction) {
					if ($transaction->status != 'failed') {
						$results[] = $transaction;
					}
				}
			}
			$this->setStatusMessage('Berhasil mendapatkan report');
			return Response::json([
				'status' => [
					'code' => $this->getCodeSuccess(),
					'confirm' => $this->getConfirmSuccess(),
					'message' => $this->getStatusMessage(),
				],
				'details' => $results,
			]);
		}
		$this->setStatusMessage('periksa tanggal awal dan tanggal akhir (start_date & end_date');
		return Response::json([
			'status' => [
				'code' => $this->getCodeFailed(),
				'confirm' => $this->getConfirmFailed(),
				'message' => $this->getStatusMessage(),
			],
		]);
	}
	public function reportsDetail(Request $request) {
		$client = OauthClientSecret::where('client_id', $request->client_id)->first();
		if (!$client) {
			$this->setStatusMessage(['Anda tidak terdaftar', 'clinet_id tidak ditemukan']);
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
		$userId = $client->user->id;
		$transaction = TrainTransaction::find($request->transaction_id);
		if ($transaction->user->id != $userId) {
			$this->setStatusMessage(['ID Transaksi tidak ditemukan']);
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
		$transaction->bookings;
		$transaction->passengers;
		$transaction->buyer;
		$this->setStatusMessage('Berhasil mendapatkan detail report');
		return Response::json([
			'status' => [
				'code' => $this->getCodeSuccess(),
				'confirm' => $this->getConfirmSuccess(),
				'message' => $this->getStatusMessage(),
			],
			'details' => [
				'transactions' => $transaction,
			],
		]);
	}

	private function getCodeSuccess() {
		return $this->codeSuccess;
	}
	private function getCodeFailed() {
		return $this->codeFailed;
	}
	private function getConfirmSuccess() {
		return $this->confirmSuccess;
	}
	private function getConfirmFailed() {
		return $this->confirmFailed;
	}
	private function setStatusMessage($message) {
		(is_array($message) ? $this->statusMessage = $message : $this->statusMessage = array($message));
	}
	private function getStatusMessage() {
		return $this->statusMessage;
	}
}
