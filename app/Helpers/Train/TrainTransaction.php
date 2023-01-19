<?php
namespace App\Helpers\Train;

use App\Buyer;
use App\Helpers\Deposit\Deposit;
use App\Helpers\Point\Point;
use App\Helpers\SipRailink;
use App\Helpers\SipTrain;
use App\RailinkBooking;
use App\RailinkBookingTransactionNumber;
use App\RailinkCommission;
use App\RailinkPassengerSeat;
use App\TrainBooking;
use App\TrainBookingTransactionNumber;
use App\TrainCommission;
use App\TrainPassenger;
use App\TrainPassengerSeat;
use App\TrainSeat;
use App\User;
use DB;
use Log;

class TrainTransaction {
	protected $request;
	protected $userId;
	protected $response;
	private $trainTransaction;
	private $status;
	private $booking;
	private $bookingReturn = null;
	private $user;
	private $percentPusat;
	private $percentBv;
	private $percentMember;
	private $totalAmount;
	private $totalAmountRet = 0;

	public function setRequest($request) {
		$this->request = $request;
	}
	public function getRequest() {
		return $this->request;
	}
	public function get() {
		return $this->response;
	}
	protected function createData() {
		$arrRequest = $this->getRequest();
		//Log::info($arrRequest);
		if (is_array($arrRequest['result'])) {
			$arrResult = $arrRequest['result'];
		} else {
			$arrRequest = json_decode($arrRequest['result'], true);
		}
		unset($arrRequest['result']);
		$totalFare = (int) $arrRequest['totalFare'];
		if ($arrRequest['trip'] == "R") {
			$totalFare = $totalFare + (int) $arrRequest['totalFareRet'];
		}
		if (Deposit::check($this->userId, $totalFare + $arrRequest['admin'] - $arrRequest['pr'])->get()) {
			$id = $this->getTransactionId();
			DB::beginTransaction();
			try {
				$buyer = Buyer::create([
					'name' => $arrRequest['cpname'],
					'email' => $arrRequest['cpmail'],
					'phone' => $arrRequest['cptlp'],
				]);
				$device = $arrRequest['device'];

				$buyer->trainTransaction()->save(
					$this->trainTransaction = new \App\TrainTransaction([
						'id' => $id,
						'user_id' => $this->userId,
						'trip_type_id' => $arrRequest['trip'],
						'sip_service_id' => $arrRequest['service_id'],
						'adt' => $arrRequest['adt'],
						'chd' => $arrRequest['chd'],
						'inf' => $arrRequest['inf'],
						'total_fare' => $totalFare + $arrRequest['admin'],
						'device' => $device,
					])
				);
				if (isset($arrRequest['indexFare'])) {
					$this->totalAmount = $arrResult['departure']['Fares'][$arrRequest['indexFare']]['TotalFare'];
					if ($arrRequest['service_id'] === 3) {
						$this->trainTransaction->bookings()->save(
							$this->booking = new TrainBooking([
								'origin' => $arrRequest['org'],
								'destination' => $arrRequest['des'],
								'paxpaid' => $arrResult['departure']['Fares'][$arrRequest['indexFare']]['TotalFare'],
								'pr' => $arrRequest['pr'],
								'admin' => $arrRequest['adminDep'],
								'train_name' => $arrResult['departure']['TrainName'],
								'train_number' => $arrResult['departure']['TrainNo'],
								'class' => $arrResult['departure']['Fares'][$arrRequest['indexFare']]['Class'],
								'subclass' => $arrResult['departure']['Fares'][$arrRequest['indexFare']]['SubClass'],
								'etd' => $arrResult['departure']['ETD'],
								'eta' => $arrResult['departure']['ETA'],
							])
						);
					} else {
						$this->trainTransaction->bookings()->save(
							$this->booking = new RailinkBooking([
								'origin' => $arrRequest['org'],
								'destination' => $arrRequest['des'],
								'paxpaid' => $arrResult['departure']['Fares'][$arrRequest['indexFare']]['TotalFare'],
								'pr' => $arrRequest['pr'],
								'train_name' => $arrResult['departure']['TrainName'],
								'train_number' => $arrResult['departure']['TrainNo'],
								'class' => $arrResult['departure']['Fares'][$arrRequest['indexFare']]['Class'],
								'subclass' => $arrResult['departure']['Fares'][$arrRequest['indexFare']]['SubClass'],
								'etd' => $arrResult['departure']['ETD'],
								'eta' => $arrResult['departure']['ETA'],
							])
						);
					}
				} else {
					foreach ($arrResult['departure']['Fares'] as $key => $value) {
						if ($arrRequest['selectedIDdep'] == $value['selectedIDdep']) {
							$this->totalAmount = $value['TotalFare'];
							if ($arrRequest['service_id'] === 3) {
								$this->trainTransaction->bookings()->save(
									$this->booking = new TrainBooking([
										'origin' => $arrRequest['org'],
										'destination' => $arrRequest['des'],
										'paxpaid' => $value['TotalFare'],
										'pr' => $arrRequest['pr'],
										'admin' => $arrRequest['adminDep'],
										'train_name' => $arrResult['departure']['TrainName'],
										'train_number' => $arrResult['departure']['TrainNo'],
										'class' => $value['Class'],
										'subclass' => $value['SubClass'],
										'etd' => $arrResult['departure']['ETD'],
										'eta' => $arrResult['departure']['ETA'],
									])
								);
							} else {
								$this->trainTransaction->bookings()->save(
									$this->booking = new RailinkBooking([
										'origin' => $arrRequest['org'],
										'destination' => $arrRequest['des'],
										'paxpaid' => $value['TotalFare'],
										'pr' => $arrRequest['pr'],
										'train_name' => $arrResult['departure']['TrainName'],
										'train_number' => $arrResult['departure']['TrainNo'],
										'class' => $value['Class'],
										'subclass' => $value['SubClass'],
										'etd' => $arrResult['departure']['ETD'],
										'eta' => $arrResult['departure']['ETA'],
									])
								);
							}
							break;
						}
					}
				}
				if ($arrRequest['trip'] == "R") {
					if (isset($arrRequest['indexFareRet'])) {
						$this->totalAmountRet = $arrResult['return']['Fares'][$arrRequest['indexFareRet']]['TotalFare'];
						if ($arrRequest['service_id'] === 3) {
							$this->trainTransaction->bookings()->save(
								$this->bookingReturn = new TrainBooking([
									'depart_return_id' => 'r',
									'origin' => $arrRequest['des'],
									'destination' => $arrRequest['org'],
									'paxpaid' => $arrResult['return']['Fares'][$arrRequest['indexFareRet']]['TotalFare'],
									'admin' => $arrRequest['adminRet'],
									'train_name' => $arrResult['return']['TrainName'],
									'train_number' => $arrResult['return']['TrainNo'],
									'class' => $arrResult['return']['Fares'][$arrRequest['indexFareRet']]['Class'],
									'subclass' => $arrResult['return']['Fares'][$arrRequest['indexFareRet']]['SubClass'],
									'etd' => $arrResult['return']['ETD'],
									'eta' => $arrResult['return']['ETA'],
								])
							);
						} else {
							$this->trainTransaction->bookings()->save(
								$this->bookingReturn = new RailinkBooking([
									'depart_return_id' => 'r',
									'origin' => $arrRequest['des'],
									'destination' => $arrRequest['org'],
									'paxpaid' => $arrResult['return']['Fares'][$arrRequest['indexFareRet']]['TotalFare'],
									'admin' => $arrRequest['adminRet'],
									'train_name' => $arrResult['return']['TrainName'],
									'train_number' => $arrResult['return']['TrainNo'],
									'class' => $arrResult['return']['Fares'][$arrRequest['indexFareRet']]['Class'],
									'subclass' => $arrResult['return']['Fares'][$arrRequest['indexFareRet']]['SubClass'],
									'etd' => $arrResult['return']['ETD'],
									'eta' => $arrResult['return']['ETA'],
								])
							);
						}
					} else {
						foreach ($arrResult['return']['Fares'] as $key => $value) {
							if ($arrRequest['selectedIDret'] == $value['selectedIDret']) {
								$this->totalAmountRet = $value['TotalFare'];
								if ($arrRequest['service_id'] === 3) {
									$this->trainTransaction->bookings()->save(
										$this->bookingReturn = new TrainBooking([
											'depart_return_id' => 'r',
											'origin' => $arrRequest['des'],
											'destination' => $arrRequest['org'],
											'paxpaid' => $value['TotalFare'],
											'admin' => $arrRequest['adminDep'],
											'train_name' => $arrResult['return']['TrainName'],
											'train_number' => $arrResult['return']['TrainNo'],
											'class' => $value['Class'],
											'subclass' => $value['SubClass'],
											'etd' => $arrResult['return']['ETD'],
											'eta' => $arrResult['return']['ETA'],
										])
									);
								} else {
									$this->trainTransaction->bookings()->save(
										$this->bookingReturn = new RailinkBooking([
											'depart_return_id' => 'r',
											'origin' => $arrRequest['des'],
											'destination' => $arrRequest['org'],
											'paxpaid' => $value['TotalFare'],
											'train_name' => $arrResult['return']['TrainName'],
											'train_number' => $arrResult['return']['TrainNo'],
											'class' => $value['Class'],
											'subclass' => $value['SubClass'],
											'etd' => $arrResult['return']['ETD'],
											'eta' => $arrResult['return']['ETA'],
										])
									);
								}
								break;
							}
						}
					}
				}
				$adt = 1;
				$chd = 1;
				$inf = 1;
				while ($adt <= 7) {
					if (array_has($arrRequest, 'nmadt_' . $adt)) {
						$this->trainTransaction->passengers()->save(
							$passenger = new TrainPassenger([
								'type' => 'adt',
								'name' => $arrRequest['nmadt_' . $adt],
								'phone' => $arrRequest['hpadt_' . $adt],
								'identity_number' => $arrRequest['idadt_' . $adt],
							])
						);
						$arrRequest['seatadt_' . $adt] = $arrRequest['departure']['seatadt_' . $adt];
						$seatSelected = explode('-', $arrRequest['departure']['seatadt_' . $adt]);
						$seat = TrainSeat::firstOrCreate([
							'wagon_code' => $seatSelected[0],
							'wagon_number' => $seatSelected[1],
							'seat' => $seatSelected[2],
						]);
						if ($arrRequest['service_id'] === 3) {
							$passenger->passanger_seats()->save(
								new TrainPassengerSeat([
									'train_booking_id' => $this->booking->id,
									'train_seat_id' => $seat->id,
								])
							);
						} else {
							$passenger->passanger_seats()->save(
								new RailinkPassengerSeat([
									'railink_booking_id' => $this->booking->id,
									'train_seat_id' => $seat->id,
								])
							);
						}
						if ($arrRequest['trip'] == "R") {
							$arrRequest['seatadt_' . $adt] .= "," . $arrRequest['return']['seatadt_' . $adt];
							$seatSelected = explode('-', $arrRequest['return']['seatadt_' . $adt]);
							$seat = TrainSeat::firstOrCreate([
								'wagon_code' => $seatSelected[0],
								'wagon_number' => $seatSelected[1],
								'seat' => $seatSelected[2],
							]);
							if ($arrRequest['service_id'] === 3) {
								$passenger->passanger_seats()->save(
									new TrainPassengerSeat([
										'train_booking_id' => $this->bookingReturn->id,
										'train_seat_id' => $seat->id,
									])
								);
							} else {
								$passenger->passanger_seats()->save(
									new RailinkPassengerSeat([
										'railink_booking_id' => $this->bookingReturn->id,
										'train_seat_id' => $seat->id,
									])
								);
							}

						}
					} else {
						break;
					}
					$adt++;
				}
				while ($chd <= 7) {
					if (array_has($arrRequest, 'nmchd_' . $chd)) {
						$this->trainTransaction->passengers()->save(
							$passenger = new TrainPassenger([
								'type' => 'chd',
								'name' => $arrRequest['nmchd_' . $chd],
								'phone' => null,
								'identity_number' => null,
							])
						);
						$arrRequest['seatchd_' . $chd] = $arrRequest['departure']['seatchd_' . $chd];
						$seatSelected = explode('-', $arrRequest['departure']['seatchd_' . $chd]);
						$seat = TrainSeat::firstOrCreate([
							'wagon_code' => $seatSelected[0],
							'wagon_number' => $seatSelected[1],
							'seat' => $seatSelected[2],
						]);
						$passenger->passanger_seats()->save(
							new RailinkPassengerSeat([
								'railink_booking_id' => $this->booking->id,
								'train_seat_id' => $seat->id,
							])
						);
						if ($arrRequest['trip'] == "R") {
							$arrRequest['seatchd_' . $chd] .= "," . $arrRequest['return']['seatchd_' . $chd];
							$seatSelected = explode('-', $arrRequest['return']['seatchd_' . $chd]);
							$seat = TrainSeat::firstOrCreate([
								'wagon_code' => $seatSelected[0],
								'wagon_number' => $seatSelected[1],
								'seat' => $seatSelected[2],
							]);
							$passenger->passanger_seats()->save(
								new RailinkPassengerSeat([
									'railink_booking_id' => $this->bookingReturn->id,
									'train_seat_id' => $seat->id,
								])
							);
						}
					} else {
						break;
					}
					$chd++;
				}
				while ($inf <= 7) {
					if (array_has($arrRequest, 'nminf_' . $inf)) {
						$this->trainTransaction->passengers()->save(
							$passenger = new TrainPassenger([
								'type' => 'inf',
								'name' => $arrRequest['nminf_' . $inf],
								'phone' => null,
								'identity_number' => null,
							])
						);
//            $arrRequest['seatinf_'.$inf]=$arrRequest['departure']['seatinf_'.$inf];
						//            $seatSelected=explode('-',$arrRequest['departure']['seatinf_'.$inf]);
						//            $seat=TrainSeat::firstOrCreate([
						//              'wagon_code'=>$seatSelected[0],
						//              'wagon_number'=>$seatSelected[1],
						//              'seat'=>$seatSelected[2]
						//            ]);
						//            $passenger->passanger_seats()->save(
						//              new TrainPassengerSeat([
						//                'train_booking_id'=>$this->booking->id,
						//                'train_seat_id'=>$seat->id,
						//              ])
						//            );
						//            if($arrRequest['trip']=="R"){
						//              $arrRequest['seatinf_'.$inf].=",".$arrRequest['return']['seatinf_'.$inf];
						//              $seatSelected=explode('-',$arrRequest['return']['seatinf_'.$inf]);
						//              $seat=TrainSeat::firstOrCreate([
						//                'wagon_code'=>$seatSelected[0],
						//                'wagon_number'=>$seatSelected[1],
						//                'seat'=>$seatSelected[2]
						//              ]);
						//              $passenger->passanger_seats()->save(
						//                new TrainPassengerSeat([
						//                  'train_booking_id'=>$this->bookingReturn->id,
						//                  'train_seat_id'=>$seat->id,
						//                ])
						//              );
						//            }
					} else {
						break;
					}
					$inf++;
				}
			} catch (\Exception $e) {
				Log::error($e->getMessage());
				DB::rollback();
				$this->response = [
					'status' => [
						'code' => 400,
						'message' => $e->getMessage(),
					],
				];
			}
			DB::commit();
			if ($arrRequest['trip'] == "O") {
				$trip = "One Way";
			} else {
				$trip = "Round Trip";
			}
			if ($arrRequest['service_id'] === 3) {
				$type = "train";
			} else {
				$type = "railink";
			}
			$debit = Deposit::debit($this->userId, $this->totalAmount + $this->totalAmountRet + $arrRequest['admin'] - $arrRequest['pr'], $type . "|" . $this->trainTransaction->id . "|Issued " . $trip . " " .
				$this->booking->train_name . " " .
				$this->booking->origin . "-" .
				$this->booking->destination)->get();
			if ($debit['status']['code'] != 200) {
				return $this->response = [
					'status' => [
						'code' => 400,
						'confirm' => 'failed',
						'message' => 'Failed debit deposit',
					],
				];
			}

			if (isset($arrRequest['point'])) {
				Point::debit($this->userId, (int) $arrRequest['point'], $type . "|" . $this->trainTransaction->id . "|Issued " . $trip . " " .
					$this->booking->train_name . " " .
					$this->booking->origin . "-" .
					$this->booking->destination)->get();
			}
			unset($arrRequest['departure']);
			if ($arrRequest['trip'] == "R") {
				unset($arrRequest['return']);
			}
			if ($arrRequest['service_id'] === 3) {
				$result = SipTrain::Issued(json_encode($arrRequest))->get();
			} else {
				$result = SipRailink::Issued(json_encode($arrRequest))->get();
			}

			if ($result['error_code'] == "000") {
				$this->user = User::find($this->userId);
				if ($this->user->role != 'free') {
					if ($arrRequest['service_id'] === 3) {
						$this->percentPusat = $this->user->type_user->pusat_train->commission;
						$this->percentBv = $this->user->type_user->bv_train->commission;
						$this->percentMember = $this->user->type_user->member_train->commission;
						$nra = abs((int) $this->totalAmount + $arrRequest['adminDep'] - (int) $result['NTADep']);
						$komisi = floor(($nra * config('sip-config')['member_commission']) / 100);
						$free = (int) $nra - (int) $komisi;
						$pusat = (int) $komisi * (int) $this->percentPusat / 100;
						$bv = (int) $komisi * (int) $this->percentBv / 100;
						$member = (int) $komisi * (int) $this->percentMember / 100;
						$upline = 0;
					} else {
						$this->percentPusat = $this->user->type_user->pusat_railink->commission;
						$this->percentBv = $this->user->type_user->bv_railink->commission;
						$this->percentMember = $this->user->type_user->member_railink->commission;
						$nra = abs((int) $this->totalAmount - (int) $result['NTADep']);
						$komisi = floor(($nra * config('sip-config')['member_commission']) / 100);
						$free = (int) $nra - (int) $komisi;
						$pusat = (int) $komisi * (int) $this->percentPusat / 100;
						$bv = (int) $komisi * (int) $this->percentBv / 100;
						$member = (int) $komisi * (int) $this->percentMember / 100;
						$upline = 0;
					}
				} else {
					if ($arrRequest['service_id'] === 3) {
						$this->percentPusat = $this->user->parent->type_user->pusat_train->commission;
						$this->percentBv = $this->user->parent->type_user->bv_train->commission;
						$this->percentMember = $this->user->parent->type_user->member_train->commission;
						$nra = abs((int) $this->totalAmount + $arrRequest['adminDep'] - (int) $result['NTADep']);
						$komisi = floor(($nra * config('sip-config')['member_commission']) / 100);
						$free = (int) $nra - (int) $komisi;
						$pusat = (int) $komisi * (int) $this->percentPusat / 100;
						$bv = (int) $komisi * (int) $this->percentBv / 100;
						$member = (int) $komisi * (int) $this->percentMember / 100;
						$comFree = (int) ($member * $this->user->type_user->member_hotel->commission) / 100;
						$comSIP = (int) ($member * $this->user->type_user->pusat_hotel->commission) / 100;
						$pusat = $pusat + $comSIP;
						$upline = $member - $comFree - $comSIP;
						$member = $comFree;
					} else {
						$this->percentPusat = $this->user->parent->type_user->pusat_railink->commission;
						$this->percentBv = $this->user->parent->type_user->bv_railink->commission;
						$this->percentMember = $this->user->parent->type_user->member_railink->commission;
						$nra = abs((int) $this->totalAmount + $arrRequest['adminDep'] - (int) $result['NTADep']);
						$komisi = floor(($nra * config('sip-config')['member_commission']) / 100);
						$free = (int) $nra - (int) $komisi;
						$pusat = (int) $komisi * (int) $this->percentPusat / 100;
						$bv = (int) $komisi * (int) $this->percentBv / 100;
						$member = (int) $komisi * (int) $this->percentMember / 100;
						$comFree = (int) ($member * $this->user->type_user->member_hotel->commission) / 100;
						$comSIP = (int) ($member * $this->user->type_user->pusat_hotel->commission) / 100;
						$pusat = $pusat + $comSIP;
						$upline = $member - $comFree - $comSIP;
						$member = $comFree;
					}
				}
				$this->booking->nta = $result['NTADep'];
				$this->booking->nra = $nra;
				$this->booking->status = "issued";
				$this->booking->pnr = $result['PNRDep'];
				$this->booking->save();
				if ($arrRequest['service_id'] === 3) {
					$this->booking->commission()->save(new TrainCommission([
						'nra' => $nra,
						'komisi' => $komisi,
						'free' => floor($free),
						'pusat' => ceil($pusat),
						'bv' => floor($bv),
						'member' => floor($member),
						'upline' => floor($upline),
					]));
					$this->booking->transaction_number()->save(new TrainBookingTransactionNumber([
						'transaction_number' => $result['notrx'],
					]));
				} else {
					$this->booking->commission()->save(new RailinkCommission([
						'nra' => $nra,
						'komisi' => $komisi,
						'free' => floor($free),
						'pusat' => ceil($pusat),
						'bv' => floor($bv),
						'member' => floor($member),
						'upline' => floor($upline),
					]));
					$this->booking->transaction_number()->save(new RailinkBookingTransactionNumber([
						'transaction_number' => $result['notrx'],
					]));
				}
				$referalUpline = $upline;
				$cashback = $member;
				$pnr = $this->booking->pnr;
				if ($arrRequest['trip'] == "R") {
					if ($this->user->role != 'free') {
						if ($arrRequest['service_id'] === 3) {
							$nra = abs((int) $this->totalAmountRet + $arrRequest['adminRet'] - (int) $result['NTARet']);
							$komisi = floor(($nra * config('sip-config')['member_commission']) / 100);
							$free = (int) $nra - (int) $komisi;
							$pusat = (int) $komisi * (int) $this->percentPusat / 100;
							$bv = (int) $komisi * (int) $this->percentBv / 100;
							$member = (int) $komisi * (int) $this->percentMember / 100;
							$upline = 0;
						} else {
							$nra = abs((int) $this->totalAmountRet - (int) $result['NTARet']);
							$komisi = floor(($nra * config('sip-config')['member_commission']) / 100);
							$free = (int) $nra - (int) $komisi;
							$pusat = (int) $komisi * (int) $this->percentPusat / 100;
							$bv = (int) $komisi * (int) $this->percentBv / 100;
							$member = (int) $komisi * (int) $this->percentMember / 100;
							$upline = 0;
						}
					} else {
						if ($arrRequest['service_id'] === 3) {
							$nra = abs((int) $this->totalAmountRet + $arrRequest['adminDep'] - (int) $result['NTARet']);
							$komisi = floor(($nra * config('sip-config')['member_commission']) / 100);
							$free = (int) $nra - (int) $komisi;
							$pusat = (int) $komisi * (int) $this->percentPusat / 100;
							$bv = (int) $komisi * (int) $this->percentBv / 100;
							$memberRet = (int) $komisi * (int) $this->percentMember / 100;
							$comFree = (int) ($member * $this->user->type_user->member_airlines->commission) / 100;
							$comSIP = (int) ($member * $this->user->type_user->pusat_airlines->commission) / 100;
							$pusat = $pusat + $comSIP;
							$upline = $memberRet - $comFree - $comSIP;
							$member = $comFree;
						} else {
							$nra = abs((int) $this->totalAmountRet - (int) $result['NTARet']);
							$komisi = floor(($nra * config('sip-config')['member_commission']) / 100);
							$free = (int) $nra - (int) $komisi;
							$pusat = (int) $komisi * (int) $this->percentPusat / 100;
							$bv = (int) $komisi * (int) $this->percentBv / 100;
							$memberRet = (int) $komisi * (int) $this->percentMember / 100;
							$comFree = (int) ($member * $this->user->type_user->member_airlines->commission) / 100;
							$comSIP = (int) ($member * $this->user->type_user->pusat_airlines->commission) / 100;
							$pusat = $pusat + $comSIP;
							$upline = $memberRet - $comFree - $comSIP;
							$member = $comFree;
						}
					}
					$this->bookingReturn->nta = $result['NTARet'];
					$this->bookingReturn->nra = $nra;
					$this->bookingReturn->status = "issued";
					$this->bookingReturn->pnr = $result['PNRRet'];
					$this->bookingReturn->save();
					if ($arrRequest['service_id'] === 3) {
						$this->bookingReturn->commission()->save(new TrainCommission([
							'nra' => $nra,
							'komisi' => $komisi,
							'free' => floor($free),
							'pusat' => ceil($pusat),
							'bv' => floor($bv),
							'member' => floor($member),
							'upline' => floor($upline),
						]));
						$this->bookingReturn->transaction_number()->save(new TrainBookingTransactionNumber([
							'transaction_number' => $result['notrx'],
						]));
					} else {
						$this->bookingReturn->commission()->save(new RailinkCommission([
							'nra' => $nra,
							'komisi' => $komisi,
							'free' => floor($free),
							'pusat' => ceil($pusat),
							'bv' => floor($bv),
							'member' => floor($member),
							'upline' => floor($upline),
						]));
						$this->bookingReturn->transaction_number()->save(new RailinkBookingTransactionNumber([
							'transaction_number' => $result['notrx'],
						]));
					}
					$referalUpline = $referalUpline + $upline;
					$cashback = $cashback + $member;
					$pnr .= "," . $this->bookingReturn->pnr;
				}
				Deposit::credit($this->userId, floor($cashback), $type . "|" . $this->trainTransaction->id . "|Cashback Smart Cash " . $trip . " " .
					$this->booking->train_name . " " .
					$this->booking->origin . "-" .
					$this->booking->destination . " (" . $pnr . ")")->get();
				if ($this->user->role == 'free') {
					try {
						Log::info('Freeuser transactions of train');
						Deposit::credit($this->user->upline, floor($referalUpline), $type . "|" . $this->trainTransaction->id . "|Cashback Smart Cash Referral" . $trip . " dari " . $this->user->name . " " .
							$this->booking->train_name . " " .
							$this->booking->origin . "-" .
							$this->booking->destination . " (" . $pnr . ")")->get();
						Log::info('Success credit smartcash referral of train');
					} catch (\Exception $e) {
						Log::info('Failed credit smartcash referral of train. Error : ' . $e->getMessage());
					}
				}
				$this->response = [
					'status' => [
						'code' => 200,
						'confirm' => 'success',
						'message' => 'success input transaction to database',
					],
					'response' => [
						'transaction' => $this->trainTransaction,
						'booking' => [
							'departure' => $this->booking,
							'return' => $this->bookingReturn,
						],
					],
				];
			} else {
				Deposit::credit($this->userId, $this->totalAmount + $this->totalAmountRet + $arrRequest['admin'] - $arrRequest['pr'], $type . "|" . $this->trainTransaction->id . "|Refund " . $trip . " " .
					$this->booking->train_name . " " .
					$this->booking->origin . "-" .
					$this->booking->destination)->get();
				if (isset($arrRequest['point'])) {
					Point::credit($this->userId, (int) $arrRequest['point'], $type . "|" . $this->trainTransaction->id . "|Refund " . $trip . " " .
						$this->booking->train_name . " " .
						$this->booking->origin . "-" .
						$this->booking->destination)->get();
				}
				$this->booking->status = "failed";
				$this->booking->save();
				$this->booking->failed_message()->save(new \App\TrainBookingFailedMessage([
					'message' => $result['error_msg'],
				]));
				if ($arrRequest['trip'] == "R") {
					$this->bookingReturn->status = "failed";
					$this->bookingReturn->save();
					$this->bookingReturn->failed_message()->save(new \App\TrainBookingFailedMessage([
						'message' => $result['error_msg'],
					]));
				}
				$this->response = [
					'status' => [
						'code' => 400,
						'confirm' => 'failed',
						'message' => $result['error_msg'],
					],
				];
			}
		} else {
			Log::info("Saldo tidak cukup (KAI)");
			$this->response = [
				'status' => [
					'code' => 400,
					'confirm' => 'failed',
					'message' => "Saldo Anda tidak cukup !",
				],
			];
		}
	}
	private function getTransactionId() {
		$i = 1;
		$service = 03;
		$transactionId = null;
		while (true) {
			$transactionId = $i . $service . substr("" . time(), -5);
			if (\App\TrainTransaction::find($transactionId) === null) {
				break;
			}
			$i++;
		}
		return $transactionId;
	}
}
