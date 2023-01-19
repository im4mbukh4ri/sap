<?php

namespace App\Http\Controllers;

use App\AirlinesCode;
use App\AirlinesItinerary;
use App\AirlinesTransaction;
use App\Airport;
use App\Helpers\Deposit\Deposit;
use App\Helpers\LimitPaxpaid;
use App\Helpers\Point\Point;
use App\Helpers\SipAirlines;
use App\Http\Requests;
use App\PointMax;
use App\PointValue;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use JavaScript;
use Log;

class AirlinesController extends Controller {
	//
	protected $rqid;
	protected $mmid;
	protected $action;
	protected $app;
	public $schedule;
	public function __construct() {
		$this->middleware(['auth', 'active:1', 'csrf']);
		$this->rqid = config('sip-config')['rqid'];
		$this->mmid = config('sip-config')['mmid'];
		$this->app = 'information';
	}

	public function index() {
		$path_airport = storage_path() . "/json/airports.json";
		$path_airline = storage_path() . "/json/airlines.json";
		if (!File::exists($path_airport) || !File::exists($path_airline)) {
			throw new Exception("Invalid File");
		}
		$file_airport = File::get($path_airport);
		$file_airline = File::get($path_airline);
		$airports_decode = json_decode($file_airport, true);
		$airlines_decode = json_decode($file_airline, true);
		$airports = $airports_decode['airport'];
		$airlines = $airlines_decode;
		return view('airlines.index', compact('airports', 'airlines'));
	}

	public function getDailyReport($user_id) {
		$report = AirlinesTransaction::where('user_id', $user_id)->get();
		return $report;
	}

	public function getScheduleClass(Request $request) {

		$this->action = "get_schedule_class";
		$airline = array();
		$getSchedule = session()->get('getSchedule');
		if ($getSchedule['flight']) {

		}
		if ($getSchedule['ac'] == "GA") {
			$this->validate($request, [
				'selectedIDdep0' => 'required',
			]);
			$selectedIDdep = $this->getSelectedId($request, 'selectedIDdep');
			$param = [
				'rqid' => $this->rqid,
				'mmid' => $this->mmid,
				'action' => $this->action,
				'ac' => $request->acDep,
				'org' => $getSchedule['org'],
				'des' => $getSchedule['des'],
				'flight' => $getSchedule['flight'],
				'tgl_dep' => date('Y-m-d', strtotime($getSchedule['tgl_dep'])),
				'app' => $this->app,
				'adt' => $getSchedule['adt'],
				'chd' => $getSchedule['chd'],
				'inf' => $getSchedule['inf'],
				'selectedIDdep' => $selectedIDdep,
			];

			if ($getSchedule['flight'] == 'R') {
				$this->validate($request, [
					'selectedIDret0' => 'required',
				]);
				$selectedIDret = $this->getSelectedId($request, 'selectedIDret');
				$param['tgl_ret'] = $getSchedule['tgl_ret'];
				$param['selectedIDret'] = $selectedIDret;
			}
			$index = 0;
			$attributes = json_encode($param);
			$origin = session()->get('origin');
			$destination = session()->get('destination');
			$airline = session()->get('airline');
			$result = SipAirlines::GetSchedule($attributes, false)->get();
			if ($result['error_code'] == "001") {
				flash()->overlay($result['error_msg'], 'INFO');
				return redirect()->route('index');
			}
			return view('airlines.get-schedule-class', compact('result', 'origin', 'destination', 'airline', 'index'));
		}
		if ($getSchedule['flight'] == 'R') {
			$indexDep = $request->selectedIDdep0;
			$indexRet = $request->selectedIDret0;
			$origin = session()->get('origin');
			$destination = session()->get('destination');
			$airline = session()->get('airline');
			$result = $getSchedule;
			return view('airlines.get-schedule-class', compact('result', 'origin', 'destination', 'airline', 'indexDep', 'indexRet'));
		}
		$index = $request->index;
		$origin = session()->get('origin');
		$destination = session()->get('destination');
		$airline = session()->get('airline');
		$result = $getSchedule;
		return view('airlines.get-schedule-class', compact('result', 'origin', 'destination', 'airline', 'index'));

	}

	public function getFare(Request $request) {
		$this->validate($request, [
			'selectedIDdep0' => 'required',
		]);
		$selectedIDdep = $this->getSelectedId($request, 'selectedIDdep');
		$getSchedule = session()->get('getSchedule');
		if (session()->has('getFares')) {
			session()->forget('getFares');
		}
		$this->action = "get_fare";
		$param = [
			'rqid' => $this->rqid,
			'mmid' => $this->mmid,
			'action' => $this->action,
			'app' => $this->app,
			'acDep' => $request->acDep,
			'org' => $getSchedule['org'],
			'des' => $getSchedule['des'],
			'flight' => $getSchedule['flight'],
			'tgl_dep' => $getSchedule['tgl_dep'],
			'adt' => $getSchedule['adt'],
			'chd' => $getSchedule['chd'],
			'inf' => $getSchedule['inf'],
			'selectedIDdep' => $selectedIDdep,
		];
		if ($getSchedule['flight'] == "R") {
			$selectedIDret = $this->getSelectedId($request, 'selectedIDret');
			$param['acRet'] = $request->acRet;
			$param['tgl_ret'] = $getSchedule['tgl_ret'];
			$param['selectedIDret'] = $selectedIDret;
		}
		$attributes = json_encode($param);
		$origin = session()->get('origin');
		$destination = session()->get('destination');
		$airline = session()->get('airline');
		$result = SipAirlines::GetSchedule($attributes, false)->get();
		if ($result['error_code'] == '001') {
			flash()->overlay($result['error_msg'], 'INFO');
			return redirect()->route('index');
		}
		return view('airlines.get-fare', compact('result', 'origin', 'destination', 'airline'));

	}

	public function booking(Requests\AirlinesBooking $request) {
		if (!$request->has('international')) {
			$valid = $this->bookingVaidation($request);
			if (!$valid) {
				return \Response::json([
					'status' => [
						'code' => 400,
						'message' => 'Booking gagal. Telah ditemukan penerbangan dengan penumpang yang sama. Silahkan cancel booking sebelumnya. Terimakasih.',
					],
				]);
			}
		}
		$limit = LimitPaxpaid::GlobalPaxpaid((int) $request->totalFare, $request->user()->id)->get();
		if ($limit) {
			return [
				'status' => [
					'code' => 400,
					'confirm' => 'failed',
					'message' => 'Oops! Anda melebihi limit transaksi bulan ini.',
				],
			];
		}
		$credentials = ['username' => $request->user()->username, 'password' => $request->CaptchaCode];
		$userLogin = Auth::once($credentials);
		if ($userLogin) {
			/*
				             * Do issued / booking
			*/
			$userId = $request->user()->id;
			$this->action = "booking";
			$this->app = "transaction";
			$param = [
				'rqid' => $this->rqid,
				'app' => $this->app,
				'action' => $this->action,
				'mmid' => $this->mmid,
				'acDep' => $request->acDep,
				'org' => $request->org,
				'des' => $request->des,
				'flight' => $request->flight,
				'tgl_dep' => $request->tgl_dep,
				'adt' => $request->adt,
				'chd' => $request->chd,
				'inf' => $request->inf,
				'selectedIDdep' => $request->selectedIDdep,
				'cpname' => $request->buyName,
				'cpmail' => $request->buyEmail,
				'cptlp' => $request->buyPhone,
				'totalFare' => $request->totalFare,
				'pr' => 0,
			];
			if ($request->flight == "R") {
				$param['acRet'] = $request->acRet;
				$param['selectedIDret'] = $request->selectedIDret;
				$param['tgl_ret'] = $request->tgl_ret;
			}
			for ($i = 1; $i <= count($request->adtFirstName); $i++) {
				$param['titadt_' . $i] = $request->adtTitle[$i - 1];
				$param['fnadt_' . $i] = $request->adtFirstName[$i - 1];
				$param['lnadt_' . $i] = $request->adtLastName[$i - 1];
				$param['hpadt_' . $i] = $request->adtPhone[$i - 1];
				if ($request->has('adtDate')) {
					$param['passnatadt_' . $i] = $request->issuedCountry[$i - 1];
					$param['natadt_' . $i] = $request->nationality[$i - 1];
					$param['passnoadt_' . $i] = $request->number[$i - 1];
					$param['birthadt_' . $i] = $request->adtYear[$i - 1] . "-" . $request->adtMonth[$i - 1] . "-" . $request->adtDate[$i - 1];
					$param['passenddateadt_' . $i] = $request->passportYear[$i - 1] . "-" . $request->passportMonth[$i - 1] . "-" . $request->passportDate[$i - 1];
				}
			}
			if ($request->has('chdFirstName')) {
				for ($i = 1; $i <= count($request->chdFirstName); $i++) {
					$param['titchd_' . $i] = $request->chdTitle[$i - 1];
					$param['fnchd_' . $i] = $request->chdFirstName[$i - 1];
					$param['lnchd_' . $i] = $request->chdLastName[$i - 1];
					$param['birthchd_' . $i] = $request->chdYear[$i - 1] . "-" . $request->chdMonth[$i - 1] . "-" . $request->chdDate[$i - 1];
					if ($request->has('chdNumber')) {
						$param['passnatchd_' . $i] = $request->chdIssuedCountry[$i - 1];
						$param['natchd_' . $i] = $request->chdNationality[$i - 1];
						$param['passnochd_' . $i] = $request->chdNumber[$i - 1];
						$param['birthchd_' . $i] = $request->chdYear[$i - 1] . "-" . $request->chdMonth[$i - 1] . "-" . $request->chdDate[$i - 1];
						$param['passenddatechd_' . $i] = $request->chdPassportYear[$i - 1] . "-" . $request->chdPassportMonth[$i - 1] . "-" . $request->chdPassportDate[$i - 1];
					}
				}
			}
			if ($request->has('infFirstName')) {
				for ($i = 1; $i <= count($request->infFirstName); $i++) {
					$param['titinf_' . $i] = $request->infTitle[$i - 1];
					$param['fninf_' . $i] = $request->infFirstName[$i - 1];
					$param['lninf_' . $i] = $request->infLastName[$i - 1];
					$param['birthinf_' . $i] = $request->infYear[$i - 1] . "-" . $request->infMonth[$i - 1] . "-" . $request->infDate[$i - 1];
					if ($request->has('infNumber')) {
						$param['passnatinf_' . $i] = $request->infIssuedCountry[$i - 1];
						$param['natinf_' . $i] = $request->infNationality[$i - 1];
						$param['passnoinf_' . $i] = $request->infNumber[$i - 1];
						$param['birthinf_' . $i] = $request->infYear[$i - 1] . "-" . $request->infMonth[$i - 1] . "-" . $request->infDate[$i - 1];
						$param['passenddateinf_' . $i] = $request->infPassportYear[$i - 1] . "-" . $request->infPassportMonth[$i - 1] . "-" . $request->infPassportDate[$i - 1];
					}
				}
			}
			$param['device'] = 'web';
			$param['result'] = $request->result;
			$attributes = json_encode($param);
			$response = SipAirlines::createTransaction($userId, $attributes)->get();
			return $response;
			/*
				             * End of issued / booking
			*/
		} else {
			return \Response::json([
				'status' => [
					'code' => 400,
					'message' => 'Password yang anda masukan salah',
				],
			]);
		}
	}
	public function cancelBooking($transaction_id) {
		$transaction = AirlinesTransaction::find($transaction_id);
		$param = [
			'rqid' => $this->rqid,
			'mmid' => $this->mmid,
			'app' => 'information',
			'action' => 'get_trx_detail',
			'notrx' => $transaction->bookings->first()->transaction_number->transaction_number,
		];
		$attributes = json_encode($param);
		$result = SipAirlines::GetSchedule($attributes, false)->get();
		if ($result['error_code'] == "000") {
			if ($result['status'] == "CANCELED") {
				foreach ($transaction->bookings as $booking) {
					$booking->status = 'canceled';
					$booking->save();
				}
				flash()->overlay('Berhasil cancel booking', 'INFO');
				return redirect()->back();
			} else {
				$param = [
					'rqid' => $this->rqid,
					'mmid' => $this->mmid,
					'app' => 'transaction',
					'action' => 'cancel',
					'notrx' => $transaction->bookings->first()->transaction_number->transaction_number,
				];
				$attributes = json_encode($param);
				$result = SipAirlines::GetSchedule($attributes, false)->get();
				if ($result['error_code'] == "000") {
					foreach ($transaction->bookings as $booking) {
						$booking->status = 'canceled';
						$booking->save();

					}
					flash()->overlay('Berhasil cancel booking', 'INFO');
					return redirect()->back();
				}
				flash()->overlay('Gagal cancel booking. Silangkah hubungi CS kami. Terima kasih.', 'INFO');
				return redirect()->back();
			}
		}
		flash()->overlay('Gagal cancel booking. Silangkah hubungi CS kami. Terima kasih.', 'INFO');
		return redirect()->back();

	}
	public function issued(Request $request, $transaction_id) {
		$this->validate($request, [
			'password' => 'required',
			'notrx' => 'required',
		]);

		$pr = 0;
		if ((int) $request->pr > 3) {
			return Response::json([
				'status' => [
					'code' => 400,
					'confirm' => 'failed',
					'message' => array('Proses gagal.'),
				],
			]);
		}
		$prValue = PointValue::find(1)->idr;
		$user = $request->user();
		$point = Point::check($user->id, (int) $request->pr)->get();
		if (!$point) {
			flash()->overlay('Proses issued gagal. Periksa kembali point Anda. Terimakasih.', 'INFO');
			return redirect()->route('airlines.report_show', $transaction_id);
		}
		$credentials = [
			'username' => $user->username,
			'password' => $request->password,
		];
		$userLogin = Auth::once($credentials);
		if ($userLogin) {
			$transaction = AirlinesTransaction::find($transaction_id);
			$bookings = $transaction->bookings;
			if ($bookings[0]->status == "issued" || $bookings[0]->status == "waiting-issued" || $bookings[0]->status == "process") {
				flash()->overlay('Transaksi selesai.', 'INFO');
				return redirect()->route('airlines.report_show', $transaction);
			}
			$totalPax = array();
			$totalCom = array();
			$i = 1;
			foreach ($bookings as $booking) {

				if ($request->has('pr')) {
					if ($i === 1) {
						$pr = (int) $request->pr * $prValue;
						$i++;
					} else {
						$pr = 0;
					}
				}
				$totalPax[] = intval($booking->paxpaid - $pr);
				$totalCom[] = intval($booking->transaction_commission->member);
				if ($user->role != 'free') {
					$debet[] = intval($booking->paxpaid) - (intval($booking->transaction_commission->member));
				} else {
					$debet[] = intval($booking->paxpaid);
				}
			}
			$totalPaxpaid = collect($totalPax)->sum();
			$totalCommission = collect($totalCom)->sum();
			$totalDebet = $totalPaxpaid - $totalCommission;
			$check = Deposit::check($user->id, $totalDebet)->get();
			if ($check) {
				$prValid = 0;
				$j = 1;
				foreach ($bookings as $booking) {
					if ($request->has('pr')) {
						if ($j === 1) {
							$prValid = (int) $request->pr * $prValue;
							$j++;
						} else {
							$prValid = 0;
						}
					}
					$totalPaxValid = intval($booking->paxpaid) - $prValid;
					if ($user->role != 'free') {
						$totalComValid = intval($booking->transaction_commission->member);
						/*
							                             * Sebelum dirubah . 30 % terlibat di debit
							                             *
							                             *$totalComValid=intval($booking->transaction_commission->member)+intval($booking->transaction_commission->free);
							                             *
						*/
					} else {
						$totalComValid = 0;
					}
					$debet = intval($totalPaxValid) - intval($totalComValid);
					if ($prValid > 0) {
						Point::debit($user->id, (int) $request->pr, 'airlines|' . $transaction_id . "|Issued " .
							$booking->airline->name . " " .
							$booking->origin . "-" .
							$booking->destination . " (" .
							$booking->itineraries->first()->pnr . ")")->get();
					}
					$debit = Deposit::debit($user->id, $debet, 'airlines|' . $transaction_id . "|Issued " .
						$booking->airline->name . " " .
						$booking->origin . "-" .
						$booking->destination . " (" .
						$booking->itineraries->first()->pnr . ")")->get();
					if ($debit['status']['code'] != 200) {
						flash()->overlay('Maaf proses issued gagal.', 'INFO');
						return redirect()->route('airlines.report_show', $transaction);
					}
					$booking->status = 'process';
					$booking->save();
				}
				$param = [
					'rqid' => $this->rqid,
					'mmid' => $this->mmid,
					'app' => 'transaction',
					'action' => 'issued',
					'notrx' => $transaction->bookings->first()->transaction_number->transaction_number,
				];
				$attributes = json_encode($param);
				$result = SipAirlines::GetSchedule($attributes, false)->get();
				if ($result['error_code'] == "000") {
					if ($result['status'] == 'ISSUED') {
						$statusDep = 'issued';
//						if ($user->role == 'free') {
//							foreach ($bookings as $booking) {
//								$totalComValid = intval($booking->transaction_commission->member) + intval($booking->transaction_commission->free);
//								Deposit::credit($user->parent->id, $totalComValid, 'airlines|' . $transaction_id . "|Kredit komisi referal ( " . $user->username . " )" .
//									$booking->airline->name . " " .
//									$booking->origin . "-" .
//									$booking->destination . " (" .
//									$booking->itineraries->first()->pnr . ")"
//								);
//							}
//						}
                        foreach ($result['penumpang'] as $value) {
                            $passenger = $transaction->passengers()->where('title','=',$value['title'])->where('first_name', '=', $value['fn'])
                                ->where('last_name', '=', $value['ln'])->first();
                            if($passenger){
                                $passenger->departure_ticket_number = $value['noticket'];
                                $passenger->save();
                                if($transaction->trip_type_id == 'R') {
                                    $passenger->return_ticket_number = $value['noticket_ret'];
                                    $passenger->save();
                                }
                            }
                        }
					} else {
						$statusDep = 'waiting-issued';
					}
					$first = $bookings->first();
					$first->status = $statusDep;
					$first->pr = $prValid;
					$first->save();
					if (count($bookings) > 1) {
						if ($result['statusRet'] == 'ISSUED') {
							$statusRet = 'issued';
						} else {
							$statusRet = 'waiting-issued';
						}
						$first = $bookings->last();
						$first->status = $statusRet;
						$first->save();
					}
					flash()->overlay('Proses issued berhasil.', 'INFO');
					return redirect()->route('airlines.report_show', $transaction);
				}
				/* GAGAL ISSUED */
				$k = 1;
				foreach ($bookings as $booking) {
					$booking->status = 'failed';
					$booking->save();
					if ($k === 1) {
						$prValid = (int) $request->pr * $prValue;
						$k++;
					} else {
						$prValid = 0;
					}
					$totalPaxValid = intval($booking->paxpaid - $prValid);
					$totalComValid = intval($booking->transaction_commission->member);
					$debet = intval($totalPaxValid) - intval($totalComValid);
					if ($prValid > 0) {
						Point::credit($user->id, (int) $request->pr, 'airlines|' . $transaction_id . "|Gagal Issued " .
							$booking->airline->name . " " .
							$booking->origin . "-" .
							$booking->destination . " (" .
							$booking->itineraries->first()->pnr . ")")->get();
					}
					Deposit::credit($request->user()->id, $debet, 'airlines|' . $transaction_id . "|Gagal Issued " .
						$booking->airline->name . " " .
						$booking->origin . "-" .
						$booking->destination . " (" .
						$booking->itineraries->first()->pnr . ")");
				}
				flash()->overlay('Proses issued gagal. Error: ' . $result['error_msg'], 'INFO');
				return redirect()->route('airlines.report_show', $transaction);
			}
			flash()->overlay('Deposit Anda tidak mencukupi, silahkan topup terlebih dahulu.', 'INFO');
			return redirect()->route('airlines.report_show', $transaction);
		}
		return "Password salah";
	}

	public function bookingIssued(Requests\AirlinesBooking $request) {
		if (!$request->has('international')) {
			$valid = $this->bookingVaidation($request);
			if (!$valid) {
				return \Response::json([
					'status' => [
						'code' => 400,
						'message' => 'Booking gagal. Telah ditemukan penerbangan dengan penumpang yang sama. Silahkan cancel booking sebelumnya. Terimakasih.',
					],
				]);
			}
		}
		$credentials = ['username' => $request->user()->username, 'password' => $request->CaptchaCode];
		$userLogin = Auth::once($credentials);
		if ($userLogin) {
			Log::info("Point Maskapai : " . $request->pr);
			if ((int) $request->pr > 3) {
				return Response::json([
					'status' => [
						'code' => 400,
						'confirm' => 'failed',
						'message' => array('Proses gagal.'),
					],
				]);
			}
			$userId = $request->user()->id;
			$prValue = PointValue::find(1)->idr;
			$point = Point::check($userId, (int) $request->pr)->get();
			if (!$point) {
				return [
					'status' => [
						'code' => 400,
						'confirm' => 'failed',
						'message' => 'Proses issued gagal. Periksa kembali point Anda / Refresh halaman ini. Terimakasih.',
					],
				];
			}
			if ($request->user()->username == "ADVANCEUSER") {
				$limit = LimitPaxpaid::GlobalPaxpaid((int) $request->totalFare, $request->user()->id)->get();
				if ($limit) {
					return [
						'status' => [
							'code' => 400,
							'confirm' => 'failed',
							'message' => 'Oops! Anda melebihi limit transaksi bulan ini.',
						],
					];
				}
			}
			$this->action = "bookingIssued";
			$this->app = "transaction";
			$param = [
				'rqid' => $this->rqid,
				'app' => $this->app,
				'action' => $this->action,
				'mmid' => $this->mmid,
				'acDep' => $request->acDep,
				'org' => $request->org,
				'des' => $request->des,
				'flight' => $request->flight,
				'tgl_dep' => $request->tgl_dep,
				'adt' => $request->adt,
				'chd' => $request->chd,
				'inf' => $request->inf,
				'selectedIDdep' => $request->selectedIDdep,
				'cpname' => $request->buyName,
				'cpmail' => $request->buyEmail,
				'cptlp' => $request->buyPhone,
				'totalFare' => $request->totalFare,
				'pr' => 0,
			];
			if ($request->has('international')) {
				$param['cabin'] = $request->cabin;
				$param['international'] = 1;
				$param['trxId'] = $request->trxId;
			}
			$param['pr'] = (int) $request->pr * $prValue;
			if ($param['pr'] > 0) {
				$param['point'] = $request->pr;
			}
			if ($request->flight == "R") {
				$param['acRet'] = $request->acRet;
				$param['selectedIDret'] = $request->selectedIDret;
				$param['tgl_ret'] = $request->tgl_ret;
			}
			for ($i = 1; $i <= count($request->adtFirstName); $i++) {
				$param['titadt_' . $i] = $request->adtTitle[$i - 1];
				$param['fnadt_' . $i] = $request->adtFirstName[$i - 1];
				$param['lnadt_' . $i] = $request->adtLastName[$i - 1];
				$param['hpadt_' . $i] = $request->adtPhone[$i - 1];
				if ($request->has('adtDate')) {
					$param['passnatadt_' . $i] = $request->issuedCountry[$i - 1];
					$param['natadt_' . $i] = $request->nationality[$i - 1];
					$param['passnoadt_' . $i] = $request->number[$i - 1];
					$param['birthadt_' . $i] = $request->adtYear[$i - 1] . "-" . $request->adtMonth[$i - 1] . "-" . $request->adtDate[$i - 1];
					$param['passenddateadt_' . $i] = $request->passportYear[$i - 1] . "-" . $request->passportMonth[$i - 1] . "-" . $request->passportDate[$i - 1];
				}
			}
			if ($request->has('chdFirstName')) {
				for ($i = 1; $i <= count($request->chdFirstName); $i++) {
					$param['titchd_' . $i] = $request->chdTitle[$i - 1];
					$param['fnchd_' . $i] = $request->chdFirstName[$i - 1];
					$param['lnchd_' . $i] = $request->chdLastName[$i - 1];
					$param['birthchd_' . $i] = $request->chdYear[$i - 1] . "-" . $request->chdMonth[$i - 1] . "-" . $request->chdDate[$i - 1];
					if ($request->has('chdIssuedCountry')) {
						$param['passnatchd_' . $i] = $request->chdIssuedCountry[$i - 1];
						$param['natchd_' . $i] = $request->chdNationality[$i - 1];
						$param['passnochd_' . $i] = $request->chdNumber[$i - 1];
						$param['birthchd_' . $i] = $request->chdPassYear[$i - 1] . "-" . $request->chdPassMonth[$i - 1] . "-" . $request->chdPassDate[$i - 1];
						$param['passenddatechd_' . $i] = $request->chdPassportYear[$i - 1] . "-" . $request->chdPassportMonth[$i - 1] . "-" . $request->chdPassportDate[$i - 1];
					}
				}
			}
			if ($request->has('infFirstName')) {
				for ($i = 1; $i <= count($request->infFirstName); $i++) {
					$param['titinf_' . $i] = $request->infTitle[$i - 1];
					$param['fninf_' . $i] = $request->infFirstName[$i - 1];
					$param['lninf_' . $i] = $request->infLastName[$i - 1];
					$param['birthinf_' . $i] = $request->infYear[$i - 1] . "-" . $request->infMonth[$i - 1] . "-" . $request->infDate[$i - 1];
					if ($request->has('infIssuedCountry')) {
						$param['passnatinf_' . $i] = $request->infIssuedCountry[$i - 1];
						$param['natinf_' . $i] = $request->infNationality[$i - 1];
						$param['passnoinf_' . $i] = $request->infNumber[$i - 1];
						$param['birthinf_' . $i] = $request->infPassYear[$i - 1] . "-" . $request->infPassMonth[$i - 1] . "-" . $request->infPassDate[$i - 1];
						$param['passenddateinf_' . $i] = $request->infPassportYear[$i - 1] . "-" . $request->infPassportMonth[$i - 1] . "-" . $request->infPassportDate[$i - 1];
					}
				}
			}
			$param['device'] = 'web';
			$param['result'] = $request->result;
			$attributes = json_encode($param);
			$response = SipAirlines::createTransaction($userId, $attributes)->get();
			return $response;
			/*
				             * End of issued / booking
			*/
		} else {
			return \Response::json([
				'status' => [
					'code' => 400,
					'message' => 'Password yang anda masukan salah',
				],
			]);
		}
	}
	public function getPageResult( /*Requests\AirlinesBooking*/Request $request) {
		$validation = Validator::make($request->all(), [
			'acDep' => 'required|exists:airlines_codes,code',
			'org' => 'required|exists:airports,id',
			'des' => 'required|exists:airports,id',
			'flight' => 'required|exists:trip_types,id',
			'tgl_dep' => 'required',
			'adt' => 'required|numeric',
			'chd' => 'required|numeric',
			'inf' => 'required|numeric',
			'selectedIDdep' => 'required',
			'bookStat' => 'required',
			'buyName' => 'required',
			'buyPhone' => 'required|numeric',
			'buyEmail' => 'required|email',
			'adtTitle.*' => 'required',
			'adtFirstName.*' => 'required',
			'adtLastName.*' => 'required',
			'adtPhone.*' => 'required',
		]);
		$request['user_point'] = $request->user()->point;
		$request['max_point'] = PointMax::find(1)->point;
		if ($validation->fails()) {
			return "<script>window.history.back()</script>";
		}
		$result = json_decode($request->result, true);
		$airline = Cache::get('airline');
		$origin = $this->getOriginData($result['org']);
		$destination = $this->getDestinationData($result['des']);
		$request = $request->all();
		if ($request['bookStat'] == 'issued') {
			$url = route('airlines.booking_issued');
		} else {
			$url = route('airlines.booking');
		}
		if (isset($request['international'])) {
			$index = $request['index'];
			$indexRet = 0;
			if (isset($request['indexRet'])) {
				$indexRet = $request['indexRet'];
			}
			$url = route('airlines.booking_issued');
			JavaScript::put([
				'request' => $request,
				'url' => $url,
			]);
			return view('airlines.result-int', compact('result', 'airline', 'origin', 'destination', 'request', 'index', 'indexRet'));
		}
		JavaScript::put([
			'request' => $request,
			'url' => $url,
		]);
		return view('airlines.result', compact('result', 'airline', 'origin', 'destination', 'request'));
	}
	public function allSchedule(Request $request) {
		$this->validate($request, [
			'flight' => 'required',
			'origin' => 'required',
			'destination' => 'required',
			'departure_date' => 'required',
			'adt' => 'required|numeric|min:1|max:7',
			'chd' => 'required|numeric|min:0|max:7',
			'inf' => 'required|numeric|min:0|max:7',
			'airlines_code' => 'required',
		]);
		$username = $request->user()->username;
		$percentCommission = config('sip-config')['member_commission'];
		$percentSmartCash = $request->user()->type_user->member_airlines->commission;
		$this->action = 'get_schedule';
		if ($request->international == 'true') {
			$international = true;
		} else {
			$international = false;
		}
		$airline = $this->getAirlineData($request->airlines_code);
		$origin = $this->getOriginData($request->origin);
		$destination = $this->getDestinationData($request->destination);
		$parameters = $this->getJsonParameters($request);

		$result = $this->getScheduleData($parameters, $international);
		if ($result['error_code'] == '001') {
			return $result;
		}
		if ($request->flight == "O") {
			if ($international) {
				//if($result['cabin']=='economy'){
				$response = view('airlines._all-oneway-get-schedule-int', compact('result', 'origin', 'destination', 'airline', 'username'));
//                }else{
				//                    $result=json_encode($result);
				//                    $response=view('airlines._business-embed',compact('result'));
				//                }
			} else {
				$response = view('airlines._all-oneway-get-schedule', compact('result', 'origin', 'destination', 'airline', 'percentCommission', 'percentSmartCash', 'username'));
			}
		} else {
			$responseDep = "";
			$responseRes = "";
			$indexDep = 0;
			$indexRet = 0;
			if ($international) {
				$cabin = $result['cabin'];
				$responseDep = "<div id='dep" . $cabin . "'>";
			}
			foreach ($result['schedule']['departure'] as $airlines) {
				if ($international) {
					$responseDep .= view('airlines._departure-int', compact('result', 'airlines', 'origin', 'destination', 'airline', 'indexDep', 'cabin'));
					if ($indexDep === 10) {
						break;
					}
				} else {
					$responseDep .= view('airlines._departure', compact('result', 'airlines', 'origin', 'destination', 'airline', 'indexDep', 'percentCommission', 'percentSmartCash', 'username'));
				}

				$indexDep++;
			}
			if ($international) {
				$responseRes = "<div id='ret" . $cabin . "'>";
			}
			foreach ($result['schedule']['return'] as $airlines) {
				if ($international) {
					$responseRes .= view('airlines._return-int', compact('result', 'airlines', 'origin', 'destination', 'airline', 'indexRet', 'cabin'));
					if ($indexRet === 10) {
						break;
					}
				} else {
					$responseRes .= view('airlines._return', compact('result', 'airlines', 'origin', 'destination', 'airline', 'indexRet', 'percentCommission', 'percentSmartCash', 'username'));
				}
				$indexRet++;
			}
			if ($international) {
				if ($result['cabin'] == 'economy') {
					$responseDep .= "</div><script>
    $(\"#btnReturnEco\").prop('disabled', true);
    $(\"#depeconomy\").show();
    $(\"#depbusiness\").hide();
</script>";
					$responseRes .= "</div><script>
    $(\"#btnReturnEco\").prop('disabled', true);
    $(\"#reteconomy\").show();
    $(\"#retbusiness\").hide();
</script>";
				} else {
					$responseDep .= "</div><script>
    $(\"#depbusiness\").hide();
</script>";
					$responseRes .= "</div><script>
    $(\"#retbusiness\").hide();
</script>";
				}
			}
			$response = [
				'departure' => $responseDep,
				'return' => $responseRes,
			];
		}
		return $response;
	}

	public function allScheduleClass(Request $request) {
		$username = $request->user()->username;
		$percentCommission = $request->percentCommission;
		$percentSmartCash = $request->percentSmartCash;
		$this->action = "get_schedule_class";
		$response = array();
		if ($request->has('acRet')) {
			$getScheduleDep = json_decode($request->resultDep, true);
			$getScheduleRet = json_decode($request->resultRet, true);
			$selectedIDdep = $this->getSelectedId($request, 'selectedIDdep');
			$selectedIDret = $this->getSelectedId($request, 'selectedIDret');

			/*
				             * departure when all airlines
			*/
			if ($request->acDep == "GA") {
				$this->validate($request, [
					'selectedIDdep0' => 'required',
				]);
				$param = [
					'rqid' => $this->rqid,
					'mmid' => $this->mmid,
					'action' => $this->action,
					'ac' => $request->acDep,
					'org' => $getScheduleDep['org'],
					'des' => $getScheduleDep['des'],
					'flight' => 'O',
					'tgl_dep' => date('Y-m-d', strtotime($getScheduleDep['tgl_dep'])),
					'app' => $this->app,
					'adt' => $getScheduleDep['adt'],
					'chd' => $getScheduleDep['chd'],
					'inf' => $getScheduleDep['inf'],
					'selectedIDdep' => $selectedIDdep,
				];
				$response['departure'] = "";
				$indexDep = 0;
				$attributes = json_encode($param);
				$origin = $this->getOriginData($getScheduleDep['org']);
				$destination = $this->getDestinationData($getScheduleDep['des']);
				$airline = $this->getAirlineData("GA");
				$result = SipAirlines::GetSchedule($attributes, false)->get();
				if ($result['error_code'] == "001") {
					flash()->overlay($result['error_msg'], 'INFO');
					return redirect()->route('index');
				}
				$response['departure'] .= view('airlines._all-departure-class', compact('result', 'origin', 'destination', 'airline', 'indexDep', 'getScheduleDep', 'username', 'percentCommission', 'percentSmartCash'));
			} else {
				$response['departure'] = "";
				$indexDep = $selectedIDdep;
				$origin = $this->getOriginData($getScheduleDep['org']);
				$destination = $this->getDestinationData($getScheduleDep['des']);
				$airline = $this->getAirlineData($getScheduleDep['ac']);
				$result = $getScheduleDep;
				$response['departure'] .= view('airlines._all-departure-class', compact('result', 'origin', 'destination', 'airline', 'indexDep', 'getScheduleDep', 'username', 'percentCommission', 'percentSmartCash'));
			}

			/*
				             * Return when all airlines
			*/
			if ($request->acRet == "GA") {
				$this->validate($request, [
					'selectedIDret0' => 'required',
				]);
				$param = [
					'rqid' => $this->rqid,
					'mmid' => $this->mmid,
					'action' => $this->action,
					'ac' => $request->acRet,
					'org' => $getScheduleRet['des'],
					'des' => $getScheduleRet['org'],
					'flight' => 'O',
					'tgl_dep' => date('Y-m-d', strtotime($getScheduleDep['tgl_ret'])),
					'app' => $this->app,
					'adt' => $getScheduleDep['adt'],
					'chd' => $getScheduleDep['chd'],
					'inf' => $getScheduleDep['inf'],
					'selectedIDdep' => $selectedIDret,
				];
				$response['return'] = "";
				$indexRet = 0;
				$attributes = json_encode($param);
				$origin = $this->getOriginData($getScheduleRet['des']);
				$destination = $this->getDestinationData($getScheduleRet['org']);
				$airline = $this->getAirlineData("GA");
				$result = SipAirlines::GetSchedule($attributes, false)->get();
				if ($result['error_code'] == "001") {
					flash()->overlay($result['error_msg'], 'INFO');
					return redirect()->route('index');
				}
				$response['return'] .= view('airlines._all-return-class', compact('result', 'origin', 'destination', 'airline', 'indexRet', 'username', 'percentCommission', 'percentSmartCash'));
			} else {
				$response['return'] = "";
				$indexRet = $selectedIDret;
				$origin = $this->getOriginData($getScheduleRet['des']);
				$destination = $this->getDestinationData($getScheduleRet['org']);
				$airline = $this->getAirlineData($getScheduleRet['ac']);
				$result = $getScheduleRet;
				$response['return'] .= view('airlines._all-return-class', compact('result', 'origin', 'destination', 'airline', 'indexRet', 'username', 'percentCommission', 'percentSmartCash'));
			}
			return $response;
		}
		$getSchedule = json_decode($request->result, true);
		if ($getSchedule['ac'] == "GA") {
			$this->validate($request, [
				'selectedIDdep0' => 'required',
			]);
			$selectedIDdep = $this->getSelectedId($request, 'selectedIDdep');
			$param = [
				'rqid' => $this->rqid,
				'mmid' => $this->mmid,
				'action' => $this->action,
				'ac' => $request->acDep,
				'org' => $getSchedule['org'],
				'des' => $getSchedule['des'],
				'flight' => $getSchedule['flight'],
				'tgl_dep' => date('Y-m-d', strtotime($getSchedule['tgl_dep'])),
				'app' => $this->app,
				'adt' => $getSchedule['adt'],
				'chd' => $getSchedule['chd'],
				'inf' => $getSchedule['inf'],
				'selectedIDdep' => $selectedIDdep,
			];

			if ($getSchedule['flight'] == 'R') {
				$this->validate($request, [
					'selectedIDret0' => 'required',
				]);
				$selectedIDret = $this->getSelectedId($request, 'selectedIDret');
				$param['tgl_ret'] = $getSchedule['tgl_ret'];
				$param['selectedIDret'] = $selectedIDret;
			}
			$index = 0;
			$attributes = json_encode($param);
			$origin = $this->getOriginData($getSchedule['org']);
			$destination = $this->getDestinationData($getSchedule['des']);
			$airline = $this->getAirlineData("GA");
			$result = SipAirlines::GetSchedule($attributes, false)->get();
			if ($result['error_code'] == "001") {
				flash()->overlay($result['error_msg'], 'INFO');
				return redirect()->route('index');
			}
			$response = view('airlines._all-schedule-class', compact('result', 'origin', 'destination', 'airline', 'index', 'username', 'percentCommission', 'percentSmartCash'));
			return $response;
		}
		if ($getSchedule['flight'] == 'R') {
			$indexDep = $request->selectedIDdep0;
			$indexRet = $request->selectedIDret0;
			$origin = session()->get('origin');
			$destination = session()->get('destination');
			$airline = $this->getAirlineData($getSchedule['ac']);
			$result = $getSchedule;
			$response = view('airlines._all-schedule-class', compact('result', 'origin', 'destination', 'airline', 'indexDep', 'indexRet', 'username', 'percentCommission', 'percentSmartCash'));
			return $response;
		}
		$index = $request->index;
		$origin = session()->get('origin');
		$destination = session()->get('destination');
		$airline = $this->getAirlineData($getSchedule['ac']);
		$result = $getSchedule;
		$response = view('airlines._all-schedule-class', compact('result', 'origin', 'destination', 'airline', 'index', 'username', 'percentCommission', 'percentSmartCash'));
		return $response;
	}
	public function allScheduleClassInt(Request $request) {
		if ($request->has("acRet")) {
			$getScheduleDep = json_decode($request->resultDep, true);
			$getScheduleRet = json_decode($request->resultRet, true);
			$selectedIDdep = $this->getSelectedId($request, 'selectedIDdep');
			$selectedIDret = $this->getSelectedId($request, 'selectedIDret');
			$response['departure'] = "";
			$indexDep = $selectedIDdep;
			$cabin = $request->cabin;
			$origin = $this->getOriginData($getScheduleDep['org']);
			$destination = $this->getDestinationData($getScheduleDep['des']);
			$airline = $this->getAirlineData($getScheduleDep['schedule']['departure'][$indexDep]['ac']);
			$result = $getScheduleDep;
			$response['departure'] .= view('airlines._all-departure-class-int', compact('result', 'origin', 'destination', 'airline', 'indexDep', 'getScheduleDep', 'cabin'));
			$response['return'] = "";
			$indexRet = $selectedIDret;
			$origin = $this->getOriginData($getScheduleRet['des']);
			$destination = $this->getDestinationData($getScheduleRet['org']);
			$airline = $this->getAirlineData($getScheduleRet['schedule']['return'][$indexRet]['ac']);
			$result = $getScheduleRet;
			$response['return'] .= view('airlines._all-return-class-int', compact('result', 'origin', 'destination', 'airline', 'indexRet'));
		} else {
			$getSchedule = json_decode($request->result, true);
			$index = $request->index;
			$origin = session()->get('origin');
			$destination = session()->get('destination');
			$airline = $this->getAirlineData($getSchedule['schedule']['departure'][$index]['ac']);
			$result = $getSchedule;
			$business = json_decode($request->business);
			$response = view('airlines._all-schedule-class-int', compact('result', 'origin', 'destination', 'airline', 'index', 'business'));
		}
		return $response;
	}

	public function allFares(Request $request) {
		$this->validate($request, [
			'selectedIDdep0' => 'required',
		]);
		$username = $request->user()->username;
		$percentCommission = $request->percentCommission;
		$percentSmartCash = $request->percentSmartCash;
		$selectedIDdep = $this->getSelectedId($request, 'selectedIDdep');
		$getSchedule = json_decode($request->result, true);
		$getScheduleDep = json_decode($request->resultDep, true);
		$this->action = "get_fare";
		$param = [
			'rqid' => $this->rqid,
			'mmid' => $this->mmid,
			'action' => $this->action,
			'app' => $this->app,
			'acDep' => $request->acDep,
			'org' => $getSchedule['org'],
			'des' => $getSchedule['des'],
			'flight' => $getSchedule['flight'],
			'tgl_dep' => $getSchedule['tgl_dep'],
			'adt' => $getSchedule['adt'],
			'chd' => $getSchedule['chd'],
			'inf' => $getSchedule['inf'],
			'selectedIDdep' => $selectedIDdep,
		];
		if ($getScheduleDep['flight'] == "R") {
			$selectedIDret = $this->getSelectedId($request, 'selectedIDret');
			$param['acRet'] = $request->acRet;
			$param['tgl_ret'] = $getScheduleDep['tgl_ret'];
			$param['selectedIDret'] = $selectedIDret;
			$param['flight'] = "R";
		}

		if ($request->has('international')) {
			$origin = session()->get('origin');
			$destination = session()->get('destination');
			$airline = Cache::get('airline');
			$index = $request->index;
			$param['cabin'] = $request->cabin;
			$attributes = json_encode($param);
			$result = SipAirlines::GetSchedule($attributes, true)->get();
		} else {
			$attributes = json_encode($param);
			$origin = session()->get('origin');
			$destination = session()->get('destination');
			$airline = Cache::get('airline');
			$result = SipAirlines::GetSchedule($attributes, false)->get();
		}
		if ($result['error_code'] == '001') {
			flash()->overlay($result['error_msg'], 'INFO');
			return redirect()->route('index');
		}
		if ($request->has('international')) {
			if ($result['flight'] == "R") {
				$index = $request->indexDep;
				$indexRet = $request->indexRet;
				return view('airlines.get-fare-int', compact('result', 'origin', 'destination', 'airline', 'getSchedule', 'index', 'indexRet'));
			}
			return view('airlines.get-fare-int', compact('result', 'origin', 'destination', 'airline', 'getSchedule', 'index'));
		}
		return view('airlines.get-fare', compact('result', 'origin', 'destination', 'airline', 'username', 'percentCommission', 'percentSmartCash'));
	}
	public function getFaresInt(Request $request) {
		return $request->business;
	}

	public function getScheduleClassPage(Request $request) {
		$url = route('airlines.all_schedule_class');
		if ($request->has('international')) {
			$url = route('airlines.schedule_class_int');
		}
		$percentCommission = $request->percentCommission;
		$percentSmartCash = $request->percentSmartCash;
		if ($request->acRet) {
			JavaScript::put([
				'request' => $request->all(),
				'url' => $url,
			]);
			$airlines_code = $request->acDep;
			$airlines_code_ret = $request->acRet;
			$result = json_decode($request->resultDep, true);
			$origin = $this->getOriginData($result['org']);
			$destination = $this->getDestinationData($result['des']);
			$req = $request->all();
			return view('airlines.test-get-schedule-class', compact('airlines_code', 'airlines_code_ret', 'origin', 'destination', 'result', 'req', 'percentSmartCash', 'percentCommission'));
		}
		JavaScript::put([
			'request' => $request->all(),
			'url' => $url,
		]);
		$airlines_code = $request->acDep;
		return view('airlines.test-get-schedule-class', compact('airlines_code'));
	}

	public function vue(Request $request) {
		$this->validate($request, [
			'flight' => 'required',
			'origin' => 'required',
			'destination' => 'required',
			'departure_date' => 'required',
			'adt' => 'required|numeric|min:1|max:7',
			'chd' => 'required|numeric|min:0|max:7',
			'inf' => 'required|numeric|min:0|max:7',
			'airlines_code' => 'required',
		]);

		if (session()->has('getSchedule')) {
			session()->forget('getSchedule');
		}
		if (session()->has('schedules')) {
			session()->forget('schedules');
		}
		if (session()->has('origin')) {
			session()->forget('origin');
		}
		if (session()->has('destination')) {
			session()->forget('destination');
		}
		if (session()->has('airline')) {
			session()->forget('airline');
			session()->forget('airline');
		}
		$percentCommission = config('sip-config')['member_commission'];
		$percentSmartCash = $request->user()->type_user->member_airlines->commission;
		$path_airport = storage_path() . "/json/airports.json";
		$path_airline = storage_path() . "/json/airlines.json";
		if (!File::exists($path_airport) || !File::exists($path_airline)) {
			throw new Exception("Invalid File");
		}
		$file_airport = File::get($path_airport);
		$file_airline = File::get($path_airline);
		$airports_decode = json_decode($file_airport, true);
		$airlines_decode = json_decode($file_airline, true);
		$origin = $this->getOriginData($request->origin);
		$destination = $this->getDestinationData($request->destination);
		if($origin->domestic == 1 && $destination->domestic == 1) {
		    $international= false;
        }else{
			$international = true;
		}
		$airports = $airports_decode['airport'];
		$airlines = $airlines_decode;
		if ($request['airlines_code'] == "ALL") {

			$flight = $request->flight;
			$url = route('airlines.all_schedule');
			JavaScript::put([
				'request' => $request->all(),
				'url' => $url,
				'international' => $international,
				'username' => $request->user()->username,
			]);
			$request->flash();
			return view('airlines.all-get-schedule', compact('flight', 'airports', 'airlines', 'international', 'percentSmartCash', 'percentCommission'));
		}
		$url = route('airlines.schedule');
		JavaScript::put([
			'request' => $request->all(),
			'url' => $url,
		]);
		$airlines_code = $request->airlines_code;
		$flight = $request->flight;
		$request->flash();
		return view('airlines.test-get-schedule', compact('airlines_code', 'flight', 'airports', 'airlines', 'percentSmartCash', 'percentCommission'));
	}

	public function bookingVaidation($request) {
		$result = json_decode($request->result, true);
		$itineraries = AirlinesItinerary::where('flight_number', $result['schedule']['departure'][0]['Flights'][0]['FlightNo'])
			->where('std', $result['schedule']['departure'][0]['Flights'][0]['STD'])
			->where('sta', $result['schedule']['departure'][0]['Flights'][0]['STA'])
			->where('etd', $result['schedule']['departure'][0]['Flights'][0]['ETD'])
			->where('eta', $result['schedule']['departure'][0]['Flights'][0]['ETA'])->get();
		if (count($itineraries) === 0) {
			return true;
		}
		foreach ($itineraries as $key => $itinerary) {
			$status = $itinerary->booking->status;
			if ($status == "booking" || $status == "issued" || $status == "waiting-issued" || $status == "process") {
				$transaction = $itinerary->booking->transaction;
				if ($transaction->user_id == $request->user()->id) {
					foreach ($transaction->passengers as $val => $passenger) {
						if ($passenger->first_name == trim($request->adtFirstName[0]) && $passenger->last_name == trim($request->adtLastName[0])) {
							return false;
						}
					}
				}
			}
		}
		return true;
	}
	private function getJsonParameters($request) {
		$params = [
			'rqid' => $this->rqid,
			'mmid' => $this->mmid,
			'action' => $this->action,
			'ac' => $request->airlines_code,
			'org' => $request->origin,
			'des' => $request->destination,
			'flight' => $request->flight,
			'tgl_dep' => date('Y-m-d', strtotime($request->departure_date)),
			'app' => $this->app,
			'adt' => $request->adt,
			'chd' => $request->chd,
			'inf' => $request->inf,
		];
		if ($request->flight == 'R') {
			$params['tgl_ret'] = date('Y-m-d', strtotime($request->return_date));
		}
		if ($request->international == 'true') {
			$params['cabin'] = $request->cabin;
		}
		$attributes = json_encode($params);
		return $attributes;
	}

	private function getAirlineData($airlinesCode) {
		$airline = array();
		$airlines_data = AirlinesCode::find($airlinesCode);

		$airline[$airlines_data->code] = [
			'code' => $airlines_data->code,
			'name' => $airlines_data->name,
			'icon' => $airlines_data->icon,
		];
		if (Cache::has('airline')) {
			$tmpAirline = Cache::get('airline');
			$tmpAirline[$airlines_data->code] = [
				'code' => $airlines_data->code,
				'name' => $airlines_data->name,
				'icon' => $airlines_data->icon,
			];
			Cache::forever('airline', $tmpAirline);
			return $airline;
		}
		Cache::forever('airline', $airline);
		return $airline;
	}
	private function getOriginData($originCode) {
		$origin = Airport::find($originCode);
		session(['origin' => $origin]);
		return $origin;
	}
	private function getDestinationData($destinationCode) {
		$destination = Airport::find($destinationCode);
		session(['destination' => $destination]);
		return $destination;

	}

	private function getSelectedId($request, $key) {
		$selectedIDdepArr = array();
		for ($i = 0; $i < count($request->all()) - 1; $i++) {
			if ($request->get($key . $i) != "") {
				$selectedIDdepArr[] = $request->get($key . $i);
			}
		}
		$selectedIDdep = implode(",", $selectedIDdepArr);
		return $selectedIDdep;
	}
	private function getScheduleData($parameters, $international) {
		$result = SipAirlines::GetSchedule($parameters, $international)->get();
		return $result;
	}
	public function report(Request $request) {
		$bookings = array();
		$from = date("Y-m-d", time());
		$until = date("Y-m-d", time());
		$statusReq = $request->status;
		if ($request->has('from') && $request->has('until')) {
			$from = date('Y-m-d', strtotime($request->from));
			$until = date('Y-m-d', strtotime($request->until));
			$transactions = $request->user()->airlines_transactions()
				->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('created_at');
			$request->flash();
		} else {
			$transactions = $request->user()->airlines_transactions()
				->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('created_at');
		}
		$totalAmount = DB::select("SELECT SUM(airlines_booking.paxpaid) as total_marketprice, SUM(airlines_commissions.bv) as total_smartpoint, SUM(airlines_commissions.member) as total_smarcash FROM airlines_booking
					INNER JOIN airlines_commissions ON airlines_booking.id = airlines_commissions.airlines_booking_id
					INNER JOIN airlines_transactions ON airlines_booking.airlines_transaction_id = airlines_transactions.id
					WHERE airlines_booking.created_at BETWEEN '{$from} 00:00:00' AND '{$until} 23:59:59' AND airlines_transactions.user_id = '{$request->user()->id}' AND airlines_booking.status LIKE '%{$statusReq}%' AND airlines_booking.status <> 'failed'");
		$from = date('d-m-Y', strtotime($from));
		$until = date('d-m-Y', strtotime($until));
		JavaScript::put([
			'request' => [
				'from' => $from,
				'until' => $until,
			],
		]);
		return view('airlines.reports.index', compact('transactions', 'request', 'bookings', 'totalAmount', 'statusReq'));
	}
	public function showReport(Request $request, $id) {
		$transaction = $request->user()->airlines_transactions->find($id);
		if ($transaction) {
			return view('airlines.reports.show', compact('transaction'));
		}
		return response('not found', 401);
	}

	public function checkin(){
		return view('airlines.reports.checkin');
	}
}
