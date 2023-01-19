<?php
namespace app\Http\Controllers\Api\v1;

use App\AirlinesTransaction;
use App\Helpers\Deposit\Deposit;
use App\Helpers\LimitPaxpaid;
use App\Helpers\Point\Point;
use App\Helpers\SipAirlines;
use App\Http\Controllers\Controller;
use App\OauthAccessToken;
use App\OauthClientSecret;
use App\PointValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class ApiAirlinesController extends Controller {
	/*
		     *
	*/
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
		if ($client->user->role != 'free') {
			$commission90 = config('sip-config')['member_commission'];
			$commissionMember = $client->user->type_user->member_airlines->commission;
		} else {
			$commission90 = config('sip-config')['member_commission'];
			$commissionMember = $client->user->parent->type_user->member_airlines->commission;
		}
		$request['rqid'] = $this->rqid;
		$request['mmid'] = $this->mmid;
		$request['app'] = 'information';
		$request['action'] = 'get_schedule';
		if ($client->user->username == "trialdev") {
			$request['mmid'] = "retross_01";
		}
		$res = json_encode($request->all());
		if ($request->has('cabin') && $request->cabin != "") {
			$result = SipAirlines::GetSchedule($res, true)->get();
		} else {
			$result = SipAirlines::GetSchedule($res, false)->get();
		}
		if ($result['error_code'] != '000') {
			$this->setStatusMessage($result['error_msg']);
			return [
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
				'details' => $result,
			];
		}
		$response = $result;
		if (!$request->has('cabin') && $request->cabin == "") {
			foreach ($response['schedule']['departure'] as $key => $value) {
				foreach ($value['Fares'] as $keyFare => $valueFare) {
					foreach ($valueFare as $keyMain => $valueMain) {
						if ((int) $valueMain['NTA'] > 0) {
							$NRA = (int) $valueMain['TotalFare'] - (int) $valueMain['NTA'];
							$com90 = (int) ($NRA * $commission90) / 100;
							$comSC = (int) ($com90 * $commissionMember) / 100;
							if ($client->user->role == 'free') {
								$comSC = (int) ($comSC * $client->user->type_user->member_airlines->commission) / 100;
							}
							$estimate = (int) $valueMain['TotalFare'] - $comSC;
                            $response['schedule']['departure'][$key]['Fares'][$keyFare][$keyMain]['market_price'] = (int) $valueMain['TotalFare'];
							$response['schedule']['departure'][$key]['Fares'][$keyFare][$keyMain]['smart_price'] = ceil($estimate);
                            $response['schedule']['departure'][$key]['Fares'][$keyFare][$keyMain]['SmartPrice'] = ceil($estimate);
						} else {
                            $response['schedule']['departure'][$key]['Fares'][$keyFare][$keyMain]['market_price'] = (int) $valueMain['TotalFare'];
							$response['schedule']['departure'][$key]['Fares'][$keyFare][$keyMain]['smart_price'] = 0;
                            $response['schedule']['departure'][$key]['Fares'][$keyFare][$keyMain]['SmartPrice'] = 0;
						}
					}
				}
			}
			if ($response['flight'] == "R") {
				foreach ($response['schedule']['return'] as $key => $value) {
					foreach ($value['Fares'] as $keyFare => $valueFare) {
						foreach ($valueFare as $keyMain => $valueMain) {
							if (isset($valueMain['NTA']) && (int) $valueMain['NTA'] > 0) {
								$NRA = (int) $valueMain['TotalFare'] - (int) $valueMain['NTA'];
								$com90 = (int) ($NRA * $commission90) / 100;
								$comSC = (int) ($com90 * $commissionMember) / 100;
								if ($client->user->role == 'free') {
									$comSC = (int) ($comSC * $client->user->type_user->member_airlines->commission) / 100;
								}
								$estimate = (int) $valueMain['TotalFare'] - $comSC;
                                $response['schedule']['return'][$key]['Fares'][$keyFare][$keyMain]['market_price'] = (int) $valueMain['TotalFare'];
								$response['schedule']['return'][$key]['Fares'][$keyFare][$keyMain]['smart_price'] = ceil($estimate);
                                $response['schedule']['return'][$key]['Fares'][$keyFare][$keyMain]['SmartPrice'] = ceil($estimate);
							} else {
                                $response['schedule']['return'][$key]['Fares'][$keyFare][$keyMain]['market_price'] = (int) $valueMain['TotalFare'];
								$response['schedule']['return'][$key]['Fares'][$keyFare][$keyMain]['smart_price'] = 0;
                                $response['schedule']['return'][$key]['Fares'][$keyFare][$keyMain]['SmartPrice'] = 0;
							}
						}
					}
				}
			}
		} else {
            foreach($response['schedule']['departure'] as $key => $value) {
                foreach ($value['Fares'] as $keyFare => $valueFare) {
                    if ((int) $valueFare['NTA'] > 0) {
                        $NRA = (int) $valueFare['TotalFare'] - (int) $valueFare['NTA'];
                        $com90 = (int) ($NRA * $commission90) / 100;
                        $comSC = (int) ($com90 * $commissionMember) / 100;
                        if ($client->user->role == 'free') {
                            $comSC = (int) ($comSC * $client->user->type_user->member_airlines->commission) / 100;
                        }
                        $estimate = (int) $valueFare['TotalFare'] - $comSC;
                        $response['schedule']['departure'][$key]['Fares'][$keyFare]['market_price'] = (int) $valueFare['TotalFare'];
                        $response['schedule']['departure'][$key]['Fares'][$keyFare]['smart_price'] = ceil($estimate);
                        $response['schedule']['departure'][$key]['Fares'][$keyFare]['SmartPrice'] = ceil($estimate);
                    }else{
                        $response['schedule']['departure'][$key]['Fares'][$keyFare]['market_price'] = (int) $valueFare['TotalFare'];
                        $response['schedule']['departure'][$key]['Fares'][$keyFare]['smart_price'] = 0;
                        $response['schedule']['departure'][$key]['Fares'][$keyFare]['SmartPrice'] = 0;
                    }
                }
            }
            if($response['flight'] == "R") {
                foreach($response['schedule']['return'] as $key => $value) {
                    foreach ($value['Fares'] as $keyFare => $valueFare) {
                        if ((int) $valueFare['NTA'] > 0) {
                            $NRA = (int) $valueFare['TotalFare'] - (int) $valueFare['NTA'];
                            $com90 = (int) ($NRA * $commission90) / 100;
                            $comSC = (int) ($com90 * $commissionMember) / 100;
                            if ($client->user->role == 'free') {
                                $comSC = (int) ($comSC * $client->user->type_user->member_airlines->commission) / 100;
                            }
                            $estimate = (int) $valueFare['TotalFare'] - $comSC;
                            $response['schedule']['return'][$key]['Fares'][$keyFare]['market_price'] = (int) $valueFare['TotalFare'];
                            $response['schedule']['return'][$key]['Fares'][$keyFare]['smart_price'] = ceil($estimate);
                            $response['schedule']['return'][$key]['Fares'][$keyFare]['SmartPrice'] = ceil($estimate);
                        }else{
                            $response['schedule']['return'][$key]['Fares'][$keyFare]['market_price'] = (int) $valueFare['TotalFare'];
                            $response['schedule']['return'][$key]['Fares'][$keyFare]['smart_price'] = 0;
                            $response['schedule']['return'][$key]['Fares'][$keyFare]['SmartPrice'] = 0;
                        }
                    }
                }
            }
        }
		$this->setStatusMessage('Success get schedule.');
		return [
			'status' => [
				'code' => $this->getCodeSuccess(),
				'confirm' => $this->getConfirmSuccess(),
				'message' => $this->getStatusMessage(),
			],
			'details' => $response,
		];
	}
	public function getScheduleClass(Request $request) {
		if ($request->has("client_id")) {
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
			if ($client->user->role != 'free') {
				$commission90 = config('sip-config')['member_commission'];
				$commissionMember = $client->user->type_user->member_airlines->commission;
			} else {
				$commission90 = config('sip-config')['member_commission'];
				$commissionMember = $client->user->parent->type_user->member_airlines->commission;
			}
		}
		$request['rqid'] = $this->rqid;
		$request['mmid'] = $this->mmid;
		$request['app'] = 'information';
		$request['action'] = 'get_schedule_class';
		if ($client->user->username == "trialdev") {
			$request['mmid'] = "retross_01";
		}
		$res = json_encode($request->all());
		$result = SipAirlines::GetSchedule($res, false)->get();
		if ($result['error_code'] != '000') {
			$this->setStatusMessage($result['error_msg']);
			return [
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
				'details' => $result,
			];
		}
		if ($request->has("client_id")) {
			foreach ($result['schedule']['departure'] as $key => $value) {
				foreach ($value['Fares'] as $keyFare => $valueFare) {
					foreach ($valueFare as $keyMain => $valueMain) {
						if ((int) $valueMain['NTA'] > 0) {
							$NRA = (int) $valueMain['TotalFare'] - (int) $valueMain['NTA'];
							$com90 = (int) ($NRA * $commission90) / 100;
							$comSC = (int) ($com90 * $commissionMember) / 100;
							if ($client->user->role == 'free') {
								$comSC = (int) ($comSC * $client->user->type_user->member_airlines->commission) / 100;
							}
							$estimate = (int) $valueMain['TotalFare'] - $comSC;
                            $result['schedule']['departure'][$key]['Fares'][$keyFare][$keyMain]['market_price'] = (int) $valueMain['TotalFare'];
							$result['schedule']['departure'][$key]['Fares'][$keyFare][$keyMain]['smart_price'] = ceil($estimate);
                            $result['schedule']['departure'][$key]['Fares'][$keyFare][$keyMain]['SmartPrice'] = ceil($estimate);
						} else {
                            $result['schedule']['departure'][$key]['Fares'][$keyFare][$keyMain]['market_price'] = (int) $valueMain['TotalFare'];
							$result['schedule']['departure'][$key]['Fares'][$keyFare][$keyMain]['smart_price'] = 0;
                            $result['schedule']['departure'][$key]['Fares'][$keyFare][$keyMain]['SmartPrice'] = 0;
						}
					}
				}
			}
            if ($result['flight'] == "R") {
                foreach ($result['schedule']['return'] as $key => $value) {
                    foreach ($value['Fares'] as $keyFare => $valueFare) {
                        foreach ($valueFare as $keyMain => $valueMain) {
                            if (isset($valueMain['NTA']) && (int) $valueMain['NTA'] > 0) {
                                $NRA = (int) $valueMain['TotalFare'] - (int) $valueMain['NTA'];
                                $com90 = (int) ($NRA * $commission90) / 100;
                                $comSC = (int) ($com90 * $commissionMember) / 100;
                                if ($client->user->role == 'free') {
                                    $comSC = (int) ($comSC * $client->user->type_user->member_airlines->commission) / 100;
                                }
                                $estimate = (int) $valueMain['TotalFare'] - $comSC;
                                $result['schedule']['return'][$key]['Fares'][$keyFare][$keyMain]['market_price'] = (int) $valueMain['TotalFare'];
                                $result['schedule']['return'][$key]['Fares'][$keyFare][$keyMain]['smart_price'] = ceil($estimate);
                                $result['schedule']['return'][$key]['Fares'][$keyFare][$keyMain]['SmartPrice'] = ceil($estimate);
                            } else {
                                $result['schedule']['return'][$key]['Fares'][$keyFare][$keyMain]['market_price'] = (int) $valueMain['TotalFare'];
                                $result['schedule']['return'][$key]['Fares'][$keyFare][$keyMain]['smart_price'] = 0;
                                $result['schedule']['return'][$key]['Fares'][$keyFare][$keyMain]['SmartPrice'] = 0;
                            }
                        }
                    }
                }
            }

		}
		$this->setStatusMessage('Success get schedule class.');
		return [
			'status' => [
				'code' => $this->getCodeSuccess(),
				'confirm' => $this->getConfirmSuccess(),
				'message' => $this->getStatusMessage(),
			],
			'details' => $result,
		];
	}
	public function getFare(Request $request) {
		$client = OauthClientSecret::where('client_id', $request->client_id)->first();
		if ($client->user->actived == 0) {
			$this->setStatusMessage('Maaf, ID anda sedang dalam block list. Silahkan hubungi cutomer service.');
			return [
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			];
		}
		if ($client->user->role != 'free') {
			$commission90 = config('sip-config')['member_commission'];
			$commissionMember = $client->user->type_user->member_airlines->commission;
		} else {
			$commission90 = config('sip-config')['member_commission'];
			$commissionMember = $client->user->parent->type_user->member_airlines->commission;
		}
		$request['rqid'] = $this->rqid;
		$request['mmid'] = $this->mmid;
		$request['app'] = "information";
		$request['action'] = "get_fare";
		if ($client->user->username == "trialdev") {
			$request['mmid'] = "retross_01";
		}
		$res = json_encode($request->all());
		if ($request->has("cabin") && $request->cabin != "") {
			$result = SipAirlines::GetSchedule($res, true)->get();
		} else {
			$result = SipAirlines::GetSchedule($res, false)->get();
		}

		if ($result['error_code'] != '000') {
			$this->setStatusMessage($result['error_msg']);
			return [
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
				'details' => $result,
			];
		}
		if (!$request->has('cabin') && $request->cabin == "") {
			$NRA = (int) $result['TotalAmount'] - (int) $result['NTA'];
			$com90 = (int) ($NRA * $commission90) / 100;
			$comSC = (int) ($com90 * $commissionMember) / 100;
			if ($client->user->role == 'free') {
				$comSC = (int) ($comSC * $client->user->type_user->member_airlines->commission) / 100;
			}
			$estimate = (int) $result['TotalAmount'] - $comSC;
            $result['market_price'] = (int) $result['TotalAmount'];
			$result['smart_price'] = ceil($estimate);
            $result['SmartPrice'] = ceil($estimate);
		}
		$this->setStatusMessage('Success get fare.');
		return [
			'status' => [
				'code' => $this->getCodeSuccess(),
				'confirm' => $this->getConfirmSuccess(),
				'message' => $this->getStatusMessage(),
			],
			'details' => $result,
		];
	}
	public function booking(Request $request) {
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
		$valid = $this->bookingValidation($request, $user);
		if (!$valid) {
			$this->setStatusMessage('Booking gagal. Telah ditemukan penerbangan dengan penumpang yang sama. Silahkan cancel booking sebelumnya. Terimakasih.');
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			]);
		}
		if ($user->username == "member_silver") {
			$limit = LimitPaxpaid::GlobalPaxpaid($request->total_fare, $user->id)->get();
			if ($limit) {
				$this->setStatusMessage('Oops! Anda melebihi limit transaksi bulan ini.');
				return Response::json([
					'status' => [
						'code' => $this->getCodeFailed(),
						'confirm' => $this->getConfirmFailed(),
						'message' => $this->getStatusMessage(),
					],
				], 400);
			}
		}

		$userId = $user->id;
		$this->app = "transaction";
		$this->action = "booking";
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
			'cpname' => $request->cpname,
			'cpmail' => $request->cpmail,
			'cptlp' => $request->cptlp,
			'totalFare' => $request->total_fare,
			'pr' => 0,
		];
        if ($user->username == "trialdev") {
            $param['mmid'] = "retross_01";
        }
		if ($request->flight == "R") {
			$param['acRet'] = $request->acRet;
			$param['selectedIDret'] = $request->selectedIDret;
			$param['tgl_ret'] = $request->tgl_ret;
		}
		for ($i = 1; $i <= 7; $i++) {
			if ($request->has('titadt_' . $i)) {
				$param['titadt_' . $i] = $request->get('titadt_' . $i);
				$param['fnadt_' . $i] = $request->get('fnadt_' . $i);
				$param['lnadt_' . $i] = $request->get('lnadt_' . $i);
				$param['hpadt_' . $i] = $request->get('hpadt_' . $i);
				if ($request->has('birthadt_' . $i)) {
					$param['passnatadt_' . $i] = $request->get('passnatadt_' . $i);
					$param['natadt_' . $i] = $request->get('natadt_' . $i);
					$param['passnoadt_' . $i] = $request->get('natadt_' . $i);
					$param['birthadt_' . $i] = $request->get('birthadt_' . $i);
					$param['passenddateadt_' . $i] = $request->get('passenddateadt_' . $i);
				}
			} else {
				break;
			}
		}
		if ($request->has('titchd_1')) {
			for ($i = 1; $i <= 7; $i++) {
				if ($request->has('titchd_' . $i)) {
					$param['titchd_' . $i] = $request->get('titchd_' . $i);
					$param['fnchd_' . $i] = $request->get('fnchd_' . $i);
					$param['lnchd_' . $i] = $request->get('lnchd_' . $i);
					$param['birthchd_' . $i] = $request->get('birthchd_' . $i);
					if ($request->has('passnochd_' . $i)) {
						$param['passnatchd_' . $i] = $request->get('passnatchd_' . $i);
						$param['natchd_' . $i] = $request->get('natchd_' . $i);
						$param['passnochd_' . $i] = $request->get('natchd_' . $i);
						$param['birthchd_' . $i] = $request->get('birthchd_' . $i);
						$param['passenddatechd_' . $i] = $request->get('passenddatechd_' . $i);
					}
				} else {
					break;
				}
			}
		}
		if ($request->has('titinf_1')) {
			for ($i = 1; $i <= 7; $i++) {
				if ($request->has('titinf_' . $i)) {
					$param['titinf_' . $i] = $request->get('titinf_' . $i);
					$param['fninf_' . $i] = $request->get('fninf_' . $i);
					$param['lninf_' . $i] = $request->get('lninf_' . $i);
					$param['birthinf_' . $i] = $request->get('birthinf_' . $i);
					if ($request->has('passnoinf_' . $i)) {
						$param['passnatinf_' . $i] = $request->get('passnatinf_' . $i);
						$param['natinf_' . $i] = $request->get('natinf_' . $i);
						$param['passnoinf_' . $i] = $request->get('natinf_' . $i);
						$param['birthinf_' . $i] = $request->get('birthinf_' . $i);
						$param['passenddateinf_' . $i] = $request->get('passenddateinf_' . $i);
					}
				} else {
					break;
				}
			}
		}
		$param['device'] = $client->device_type;
		$param['result'] = $request->result_get_fare;
		$attributes = json_encode($param);
		$response = SipAirlines::createTransaction($userId, $attributes)->get();
		$this->setStatusMessage('Success get fare.');
		if ($response['status']['code'] == 400) {
			$this->setStatusMessage($response['status']['message']);
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
				'details' => [
					'transaction' => $response['response']['transaction'],
					'booking' => $response['response']['booking'],
				],
			], 400);
		}
		$this->setStatusMessage('Booking berhasil');
		return Response::json([
			'status' => [
				'code' => $this->getCodeSuccess(),
				'confirm' => $this->getConfirmSuccess(),
				'message' => $this->getStatusMessage(),
			],
			'details' => [
				'transaction' => $response['response']['transaction'],
				'booking' => $response['response']['booking'],
			],
		], 200);
	}
	public function cancelBooking(Request $request) {
		$client = $user = OauthClientSecret::where('client_id', $request->client_id)->first();
		if (!$client) {
			$this->setStatusMessage('client_id tidak terdaftar');
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			]);
		}
		$transaction = AirlinesTransaction::find($request->transaction_id);
		if ($client->user->id != $transaction->user->id) {
			$this->setStatusMessage('transaction_id tidak ditemukan');
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			]);
		}
		if ($transaction->bookings->first()->status != 'booking') {
			$this->setStatusMessage('Status transaksi ' . $transaction->bookings->first()->status . ', tidak dapat dicancel.');
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			]);
		}
		$transaction_number = $transaction->bookings->first()->transaction_number->transaction_number;
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
				$this->setStatusMessage('Berhasil cancel booking');
				return Response::json([
					'status' => [
						'code' => $this->getCodeSuccess(),
						'confirm' => $this->getConfirmSuccess(),
						'message' => $this->getStatusMessage(),
					],
					'details' => $result,
				]);
			} else {
				$param = [
					'rqid' => $this->rqid,
					'mmid' => $this->mmid,
					'app' => 'transaction',
					'action' => 'cancel',
					'notrx' => $transaction_number,
				];
				$attributes = json_encode($param);
				$result = SipAirlines::GetSchedule($attributes, false)->get();
				if ($result['error_code'] == "000") {
					foreach ($transaction->bookings as $booking) {
						$booking->status = 'canceled';
						$booking->save();
					}
					$this->setStatusMessage('Berhasil cancel booking');
					return Response::json([
						'status' => [
							'code' => $this->getCodeSuccess(),
							'confirm' => $this->getConfirmSuccess(),
							'message' => $this->getStatusMessage(),
						],
						'details' => $result,
					]);
				}
				$this->setStatusMessage($result['error_msg']);
				return Response::json([
					'status' => [
						'code' => $this->getCodeFailed(),
						'confirm' => $this->getConfirmFailed(),
						'message' => $this->getStatusMessage(),
					],
				]);
			}
		}
		$this->setStatusMessage($result['error_msg']);
		return Response::json([
			'status' => [
				'code' => $this->getCodeFailed(),
				'confirm' => $this->getConfirmFailed(),
				'message' => $this->getStatusMessage(),
			],
		]);
	}
	public function issued(Request $request) {
		$user = OauthClientSecret::where('client_id', $request->client_id)->first();
		if (!$user) {
			$this->setStatusMessage('client_id tidak terdaftar');
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
		$transaction = AirlinesTransaction::find($request->transaction_id);
		if ($user->user->id != $transaction->user->id) {
			$this->setStatusMessage('transaction_id tidak ditemukan');
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
		if (!$transaction) {
			$this->setStatusMessage('transaction_id tidak ditemukan');
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
		// if(
		//   $user->user->username=="member_silver"||
		//   $user->user->username=="member_platinum"||
		//   $user->user->username=="member_gold"||
		//   $user->user->username=="member_free"||
		//   $user->user->username=="trialdev"||
		//   $user->user->username=="prouser"||
		//   $user->user->username=="advanceuser"||
		//   $user->user->username=="basicuser"
		// ){
		//   $limit = LimitPaxpaid::GlobalPaxpaid($transaction->total_fare,$user->user->id)->get();
		//   if($limit){
		//     $this->setStatusMessage('Oops! Anda melebihi limit transaksi bulan ini.');
		//     return Response::json([
		//         'status'=>[
		//             'code'=>$this->getCodeFailed(),
		//             'confirm'=>$this->getConfirmFailed(),
		//             'message'=>$this->getStatusMessage()
		//         ]
		//     ],400);
		//   }
		// }
		$bookings = $transaction->bookings;
		if ($bookings[0]->status == "issued" || $bookings[0]->status == "waiting-issued" || $bookings[0]->status == "process") {
			$this->setStatusMessage('Transaksi selesai.');
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
		$totalPax = array();
		$totalCom = array();
		if ($request->has('pr') && (int) $request->pr > 3) {
			$this->setStatusMessage('Proses gagal.');
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
		$pr = 0;
		$prValue = PointValue::find(1)->idr;
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
			$totalPax[] = floatval($booking->paxpaid - $pr);
			$totalCom[] = floatval($booking->transaction_commission->member);
		}
		$totalPaxpaid = collect($totalPax)->sum();
		$totalCommission = collect($totalCom)->sum();
		$totalDebet = $totalPaxpaid - $totalCommission;
		$check = Deposit::check($user->user->id, $totalDebet)->get();
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
				$totalComValid = intval($booking->transaction_commission->member);
				$debet = intval($totalPaxValid) - intval($totalComValid);
				if ($prValid > 0) {
					Point::debit($user->user->id, (int) $request->pr, 'airlines|' . $request->transaction_id . "|Issued " .
						$booking->airline->name . " " .
						$booking->origin . "-" .
						$booking->destination . " (" .
						$booking->itineraries->first()->pnr . ")")->get();
				}
				$debit = Deposit::debit($user->user->id, $debet, 'airlines|' . $request->transaction_id . "|Issued " .
					$booking->airline->name . " " .
					$booking->origin . "-" .
					$booking->destination . " (" .
					$booking->itineraries->first()->pnr . ")")->get();
				if ($debit['status']['code'] != 200) {
					$this->setStatusMessage('Proses issued gagal. Debit saldo gagal. Silahkan hubungi CS kami. Terimakasih');
					return Response::json([
						'status' => [
							'code' => $this->getCodeFailed(),
							'confirm' => $this->getConfirmFailed(),
							'message' => $this->getStatusMessage(),
						],
					], 400);
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
            if ($user->user->username == "trialdev") {
                $param['mmid'] = "retross_01";
            }

			$attributes = json_encode($param);
			$result = SipAirlines::GetSchedule($attributes, false)->get();
			if ($result['error_code'] == "000") {
				if ($result['status'] == 'ISSUED') {
					$statusDep = 'issued';
//                    if ($user->role == 'free') {
//                        foreach ($bookings as $booking) {
//                            $totalComValid = intval($booking->transaction_commission->member) + intval($booking->transaction_commission->free);
//                            Deposit::credit($user->parent->id, $totalComValid, 'airlines|' . $transaction->id . "|Kredit komisi referal ( " . $user->username . " )" .
//                                $booking->airline->name . " " .
//                                $booking->origin . "-" .
//                                $booking->destination . " (" .
//                                $booking->itineraries->first()->pnr . ")"
//                            );
//                        }
//                    }
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
				$this->setStatusMessage('Issued berhasil');
				return Response::json([
					'status' => [
						'code' => $this->getCodeSuccess(),
						'confirm' => $this->getConfirmSuccess(),
						'message' => $this->getStatusMessage(),
					],
					'details' => [
						'transaction' => $transaction,
						'booking' => $bookings,
					],
				], 200);
			}
			/* GAGAL ISSUED */
			$k = 1;
			foreach ($bookings as $booking) {
				$booking->status = 'failed';
				$booking->save();
				if ($request->has('pr')) {
					if ($k === 1) {
						$prValid = (int) $request->pr * $prValue;
						$k++;
					} else {
						$prValid = 0;
					}
				}
				$totalPaxValid = intval($booking->paxpaid - $prValid);
				$totalComValid = intval($booking->transaction_commission->member);
				$debet = intval($totalPaxValid) - intval($totalComValid);
				if ($prValid > 0) {
					Point::credit($user->user->id, (int) $request->pr, 'airlines|' . $request->transaction_id . "|Gagal Issued " .
						$booking->airline->name . " " .
						$booking->origin . "-" .
						$booking->destination . " (" .
						$booking->itineraries->first()->pnr . ")")->get();
				}
				Deposit::credit($user->user->id, $debet, 'airlines|' . $request->transaction_id . "|Gagal Issued " .
					$booking->airline->name . " " .
					$booking->origin . "-" .
					$booking->destination . " (" .
					$booking->itineraries->first()->pnr . ")");
			}
			$this->setStatusMessage($result['error_msg']);
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			]);
		}
		$this->setStatusMessage('Saldo Anda tidak cukup');
		return Response::json([
			'status' => [
				'code' => $this->getCodeFailed(),
				'confirm' => $this->getConfirmFailed(),
				'message' => $this->getStatusMessage(),
			],
			'details' => [
				'transaction' => $transaction,
				'booking' => $bookings,
			],
		]);
	}
	public function bookingIssued(Request $request) {
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
		if (!$request->has("cabin")) {
			$valid = $this->bookingValidation($request, $client->user);
			if (!$valid) {
				$this->setStatusMessage('Issued gagal. Telah ditemukan penerbangan dengan penumpang yang sama. Silahkan cancel booking sebelumnya. Terimakasih.');
				return Response::json([
					'status' => [
						'code' => $this->getCodeFailed(),
						'confirm' => $this->getConfirmFailed(),
						'message' => $this->getStatusMessage(),
					],
				]);
			}
		}
		$pr = 0;
		if ($request->has('pr')) {
			if ((int) $request->pr > 3) {
				$this->setStatusMessage('Proses gagal.');
				return Response::json([
					'status' => [
						'code' => $this->getCodeFailed(),
						'confirm' => $this->getConfirmFailed(),
						'message' => $this->getStatusMessage(),
					],
				], 400);
			}
			$prValue = PointValue::find(1)->idr;
			$pr = (int) $request->pr * $prValue;
			$point = Point::check($client->user->id, (int) $request->pr)->get();
			if (!$point) {
				$this->setStatusMessage('Point Anda tidak cukup');
				return Response::json([
					'status' => [
						'code' => $this->getCodeFailed(),
						'confirm' => $this->getConfirmFailed(),
						'message' => $this->getStatusMessage(),
					],
				], 400);
			}
		}
        $limit = LimitPaxpaid::GlobalPaxpaid($request->total_fare, $client->user->id)->get();
        if ($limit) {
            $this->setStatusMessage('Oops! Anda melebihi limit transaksi bulan ini.');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ], 400);
        }
		$check = Deposit::check($client->user->id, $request->total_fare - $pr)->get();
		if ($check) {
			$user = $client->user;
			$userId = $user->id;
			$this->app = "transaction";
			$this->action = "bookingIssued";
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
				'cpname' => $request->cpname,
				'cpmail' => $request->cpmail,
				'cptlp' => $request->cptlp,
				'totalFare' => $request->total_fare,
				'pr' => $pr,
			];
			if ($request->has('pr')) {
				if ((int) $request->pr > 0) {
					$param['point'] = $request->pr;
				}
			}
			if ($request->flight == "R") {
				$param['acRet'] = $request->acRet;
				$param['selectedIDret'] = $request->selectedIDret;
				$param['tgl_ret'] = $request->tgl_ret;
			}
			for ($i = 1; $i <= 7; $i++) {
				if ($request->has('titadt_' . $i)) {
					$param['titadt_' . $i] = $request->get('titadt_' . $i);
					$param['fnadt_' . $i] = $request->get('fnadt_' . $i);
					$param['lnadt_' . $i] = $request->get('lnadt_' . $i);
					$param['hpadt_' . $i] = $request->get('hpadt_' . $i);
					if ($request->has('passnoadt_' . $i)) {
						$param['passnatadt_' . $i] = $request->get('passnatadt_' . $i);
						$param['natadt_' . $i] = $request->get('natadt_' . $i);
						$param['passnoadt_' . $i] = $request->get('passnoadt_' . $i);
						$param['birthadt_' . $i] = $request->get('birthadt_' . $i);
						$param['passenddateadt_' . $i] = $request->get('passenddateadt_' . $i);
					}
				} else {
					break;
				}
			}
			if ($request->has('titchd_1')) {
				for ($i = 1; $i <= 7; $i++) {
					if ($request->has('titchd_' . $i)) {
						$param['titchd_' . $i] = $request->get('titchd_' . $i);
						$param['fnchd_' . $i] = $request->get('fnchd_' . $i);
						$param['lnchd_' . $i] = $request->get('lnchd_' . $i);
						$param['birthchd_' . $i] = $request->get('birthchd_' . $i);
						if ($request->has('passnochd_' . $i)) {
							$param['passnatchd_' . $i] = $request->get('passnatchd_' . $i);
							$param['natchd_' . $i] = $request->get('natchd_' . $i);
							$param['passnochd_' . $i] = $request->get('passnochd_' . $i);
							$param['birthchd_' . $i] = $request->get('birthchd_' . $i);
							$param['passenddatechd_' . $i] = $request->get('passenddatechd_' . $i);
						}
					} else {
						break;
					}
				}
			}
			if ($request->has('titinf_1')) {
				for ($i = 1; $i <= 7; $i++) {
					if ($request->has('titinf_' . $i)) {
						$param['titinf_' . $i] = $request->get('titinf_' . $i);
						$param['fninf_' . $i] = $request->get('fninf_' . $i);
						$param['lninf_' . $i] = $request->get('lninf_' . $i);
						$param['birthinf_' . $i] = $request->get('birthinf_' . $i);
						if ($request->has('passnoinf_' . $i)) {
							$param['passnatinf_' . $i] = $request->get('passnatinf_' . $i);
							$param['natinf_' . $i] = $request->get('natinf_' . $i);
							$param['passnoinf_' . $i] = $request->get('passnoinf_' . $i);
							$param['birthinf_' . $i] = $request->get('birthinf_' . $i);
							$param['passenddateinf_' . $i] = $request->get('passenddateinf_' . $i);
						}
					} else {
						break;
					}
				}
			}
			$param['device'] = $client->device_type;
			$param['result'] = $request->result_get_fare;
			if ($request->has("cabin")) {
				$resultFare = json_decode($request->result_get_fare, true);
				$param['international'] = 1;
				$param['cabin'] = $request->cabin;
				$param['trxId'] = $resultFare['trxId'];
				$param['acDep'] = $resultFare['schedules']['departure'][0]["ac"];
			}
            if ($user->username == "trialdev") {
                $param['mmid'] = "retross_01";
            }
			$attributes = json_encode($param);
			$response = SipAirlines::createTransaction($userId, $attributes)->get();
			if ($response['status']['code'] == 400) {
				$this->setStatusMessage($response['status']['message']);
				return Response::json([
					'status' => [
						'code' => $this->getCodeFailed(),
						'confirm' => $this->getConfirmFailed(),
						'message' => $this->getStatusMessage(),
					],
					'details' => [
						'transaction' => $response['response']['transaction'],
						'booking' => $response['response']['booking'],
					],
				], 400);
			}
			$this->setStatusMessage('Issued berhasil');
			return Response::json([
				'status' => [
					'code' => $this->getCodeSuccess(),
					'confirm' => $this->getConfirmSuccess(),
					'message' => $this->getStatusMessage(),
				],
				'details' => [
					'transaction' => $response['response']['transaction'],
					'booking' => $response['response']['booking'],
				],
			], 200);
		}
		$this->setStatusMessage('Saldo Anda tidak cukup');
		return Response::json([
			'status' => [
				'code' => $this->getCodeFailed(),
				'confirm' => $this->getConfirmFailed(),
				'message' => $this->getStatusMessage(),
			],
		], 400);
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
				$this->setStatusMessage('Report airlines yang bisa Anda cek maksimal 31 hari.');
				return Response::json([
					'status' => [
						'code' => $this->getCodeFailed(),
						'confirm' => $this->getConfirmFailed(),
						'message' => $this->getStatusMessage(),
					],
				]);
			}
			$transactions = AirlinesTransaction::where('user_id', $userId)->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get();
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
		$transaction = AirlinesTransaction::find($request->transaction_id);
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
		$onlyTrx = collect($transaction);
		$bookings = $transaction->bookings;
		$buyer = $transaction->buyer;
		$passengers = $transaction->passengers;
		$onlyTrx->put('booking', $bookings);
		$onlyTrx->put('passengers', $passengers);
		$onlyTrx->put('buyer', $buyer);
		$this->setStatusMessage('Berhasil mendapatkan detail report');
		return Response::json([
			'status' => [
				'code' => $this->getCodeSuccess(),
				'confirm' => $this->getConfirmSuccess(),
				'message' => $this->getStatusMessage(),
			],
			'details' => [
				'transactions' => $onlyTrx,
			],
		]);
	}
	public function bookingValidation($request, $user) {
		$result = json_decode($request->result_get_fare, true);
		$itineraries = \App\AirlinesItinerary::where('flight_number', $result['schedule']['departure'][0]['Flights'][0]['FlightNo'])
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
				if ($transaction->user_id == $user->id) {
					foreach ($transaction->passengers as $val => $passenger) {
						if ($passenger->first_name == trim($request->get('fnadt_1')) && $passenger->last_name == trim($request->get('lnadt_1'))) {
							return false;
						}
					}
				}
			}
		}
		return true;
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
