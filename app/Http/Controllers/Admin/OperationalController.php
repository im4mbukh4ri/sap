<?php

namespace App\Http\Controllers\Admin;

use App\AirlinesTransaction;
use App\Helpers\SipAirlines;
use App\Http\Controllers\Controller;

class OperationalController extends Controller {
	//

	private $rqid;
	private $mmid;
	public function __construct() {
		$this->middleware(['auth', 'csrf']);
	}
	public function airlinesCancelBooking($transaction_id) {
		$transaction = AirlinesTransaction::find($transaction_id);
		$this->rqid = config('sip-config')['rqid'];
		$this->mmid = config('sip-config')['mmid'];
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
		} else {
			foreach ($transaction->bookings as $booking) {
				$booking->status = 'canceled';
				$booking->save();
			}
			flash()->overlay('Berhasil cancel booking', 'INFO');
			return redirect()->back();
		}
	}
}
