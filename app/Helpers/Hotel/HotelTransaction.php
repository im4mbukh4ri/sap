<?php

namespace App\Helpers\Hotel;

/**
 *
 */
use App\Helpers\Deposit\Deposit;
use App\Helpers\Point\Point;
use App\Helpers\SipHotel;
use App\User;
use DB;
use Log;

class HotelTransaction {
	protected $request;
	protected $response;
	protected $userId;
	private $hotelTransaction;
	private $user;
	private $percentPusat;
	private $percentBv;
	private $percentMember;

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
		if (Deposit::check($this->userId, $arrRequest['total_fare'] - $arrRequest['pr'])->get()) {
			$id = $this->getTransactionId();
			DB::beginTransaction();
			try {
				$this->hotelTransaction = \App\HotelTransaction::create([
					'id' => $id,
					'user_id' => $this->userId,
					'hotel_id' => $arrRequest['hotel_id'],
					'checkin' => $arrRequest['checkin'],
					'checkout' => $arrRequest['checkout'],
					'adt' => $arrRequest['adt_input'],
					'chd' => $arrRequest['chd'],
					'inf' => $arrRequest['inf'],
					'room' => $arrRequest['room'],
					'total_fare' => $arrRequest['total_fare'],
					'pr' => $arrRequest['pr'],
					'device' => $arrRequest['device'],
				]);
				foreach ($arrRequest['beds'] as $key => $value) {
					$this->hotelTransaction->hotel_rooms()->create(['hotel_room_id' => $value]);
				}
				$this->hotelTransaction->hotel_guest()->create([
					'title' => $arrRequest['titguest'],
					'name' => $arrRequest['nmguest'],
					'phone' => $arrRequest['hpguest'],
				]);
				if ($arrRequest['noteguest'] != '') {
					$this->hotelTransaction->guest_note()->create(['note' => $arrRequest['noteguest']]);
				}
			} catch (\Exception $e) {
				DB::rollback();
				Log::info('Failed input to database hotel transaction , error : ' . $e->getMessage());
				return $this->response = [
					'status' => [
						'code' => 400,
						'confirm' => 'failed',
						'message' => $e->getMessage(),
					],
				];
			}
			DB::commit();
			$debitDeposit = Deposit::debit($this->userId, $arrRequest['total_fare'] - $arrRequest['pr'],
				'hotel|' . $this->hotelTransaction->id . '|Issued hotel ' .
				$this->hotelTransaction->hotel->name . ' ' . $arrRequest['room'] . ' kamar')->get();
			if ($debitDeposit['status']['code'] != 200) {
				Log::info('Failed debit saldo hotel');
				return $this->response = [
					'status' => [
						'code' => 400,
						'confirm' => 'failed',
						'message' => "Gagal debit saldo !",
					],
				];
			}
			if ($arrRequest['pr'] > 0) {
				$debitPoint = Point::debit($this->userId, (int) $arrRequest['point'],
					'hotel|' . $this->hotelTransaction->id . '|Issued hotel ' .
					$this->hotelTransaction->hotel->name . ' ' . $arrRequest['room'] . ' kamar')->get();
				if ($debitPoint['status']['code'] != 200) {
					Log::info('Failed debit point hotel ');
					Deposit::credit($this->userId, $arrRequest['total_fare'] - $arrRequest['pr'],
						'hotel|' . $this->hotelTransaction->id . '|Refund hotel ' .
						$this->hotelTransaction->hotel->name . ' ' . $arrRequest['room'] . ' kamar')->get();
					return $this->response = [
						'status' => [
							'code' => 400,
							'confirm' => 'failed',
							'message' => "Gagal debit point !",
						],
					];
				}
			}
			$param = [
				'rqid' => $arrRequest['rqid'],
				'app' => $arrRequest['app'],
				'action' => $arrRequest['action'],
				'mmid' => $arrRequest['mmid'],
				'selectedID' => $arrRequest['selectedID'],
				'selectedIDroom' => $arrRequest['selectedIDroom'],
				'titguest' => $arrRequest['titguest'],
				'nmguest' => $arrRequest['nmguest'],
				'hpguest' => $arrRequest['hpguest'],
				'noteguest' => $arrRequest['noteguest'],
			];
			$param = json_encode($param);
			$response = SipHotel::Issued($param)->get();

			if ($response['error_code'] == '000') {
				$this->user = User::find($this->userId);
				if ($this->user->role != 'free') {
					$this->percentPusat = $this->user->type_user->pusat_hotel->commission;
					$this->percentBv = $this->user->type_user->bv_hotel->commission;
					$this->percentMember = $this->user->type_user->member_hotel->commission;
					$nra = abs((int) $arrRequest['total_fare'] - $response['NTA']);
					$komisi = floor(($nra * config('sip-config')['member_commission']) / 100);
					$free = (int) $nra - (int) $komisi;
					$pusat = (int) $komisi * (int) $this->percentPusat / 100;
					$bv = (int) $komisi * (int) $this->percentBv / 100;
					$member = (int) $komisi * (int) $this->percentMember / 100;
					$upline = 0;
					if ($member > 0) {
						Deposit::credit($this->userId, $member, 'hotel|' . $this->hotelTransaction->id . '|Cashback Smart Cash ' .
							$this->hotelTransaction->hotel->name . ' ' . $arrRequest['room'] . ' kamar' .
							'Voucher : ' . $response['VoucherNo'])->get();
					}
				} else {
					$this->percentPusat = $this->user->parent->type_user->pusat_hotel->commission;
					$this->percentBv = $this->user->parent->type_user->bv_hotel->commission;
					$this->percentMember = $this->user->parent->type_user->member_hotel->commission;
					$nra = abs((int) $arrRequest['total_fare'] - (int) $response['NTA']);
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
					if ($member > 0) {
						Deposit::credit($this->userId, $member, 'hotel|' . $this->hotelTransaction->id . '|Cashback Smart Cash ' .
							$this->hotelTransaction->hotel->name . ' ' . $arrRequest['room'] . ' kamar.' .
							' (' . $response['VoucherNo'] . ')')->get();
					}
					if ($upline > 0) {
						Deposit::credit($this->user->upline, $upline, 'hotel|' . $this->hotelTransaction->id . '|Smart Cash Referral hotel ' .
							'dari ' . $this->user->name)->get();
					}
				}
				if ($response['status'] == 'ISSUED') {
					$this->hotelTransaction->status = 'issued';
				} else {
					$this->hotelTransaction->status = 'waiting-issued';
				}
				$this->hotelTransaction->nta = $response['NTA'];
				$this->hotelTransaction->nra = $nra;
				$this->hotelTransaction->save();
				$this->hotelTransaction->commission()->create([
					'nra' => $nra,
					'komisi' => $komisi,
					'free' => floor($free),
					'pusat' => ceil($pusat),
					'bv' => floor($bv),
					'member' => floor($member),
					'upline' => floor($upline),
				]);
				$this->hotelTransaction->voucher()->create([
					'transaction_number' => $response['notrx'],
					'res' => $response['ResNo'],
					'voucher' => $response['VoucherNo'],
				]);

				return $this->response = [
					'status' => [
						'code' => 200,
						'confirm' => 'success',
						'message' => "Berhasil create data transaction",
					],
					'details' => $this->hotelTransaction,
				];
			}
			$this->hotelTransaction->status = 'failed';
			$this->hotelTransaction->save();
			Deposit::credit($this->userId, $arrRequest['total_fare'] - $arrRequest['pr'],
				'hotel|' . $this->hotelTransaction->id . '|Refund hotel ' .
				$this->hotelTransaction->hotel->name . ' ' . $arrRequest['room'] . ' kamar')->get();
			if ($arrRequest['pr'] > 0) {
				Point::credit($this->userId, (int) $arrRequest['point'],
					'hotel|' . $this->hotelTransaction->id . '|Refund hotel ' .
					$this->hotelTransaction->hotel->name . ' ' . $arrRequest['room'] . ' kamar')->get();
			}
			return $this->response = [
				'status' => [
					'code' => 400,
					'confirm' => 'success',
					'message' => $response['error_msg'],
				],
				'details' => $this->hotelTransaction,
				'param' => $param,
				'response' => $response,
			];
		}
		return $this->response = [
			'status' => [
				'code' => 400,
				'confirm' => 'failed',
				'message' => "Saldo Anda tidak cukup !",
			],
		];
	}
	private function getTransactionId() {
		$i = 1;
		$service = 05;
		$transactionId = null;
		while (true) {
			$transactionId = $i . $service . substr("" . time(), -5);
			if (\App\HotelTransaction::find($transactionId) === null) {
				break;
			}
			$i++;
		}
		return $transactionId;
	}
}
