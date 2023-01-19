<?php

namespace App\Http\Controllers\Admin;

use App\AirlinesBooking;
use App\HistoryDeposit;
use App\Http\Controllers\Controller;
use App\PpobTransaction;

class MonitoringController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
	public function airlinesPassenger() {
		$bookings = AirlinesBooking::orderBy('id', 'DESC')->paginate(100);
		return view('admin.monitorings.monitoring-passenger', compact('bookings'));
	}
	public function depositMonitoring() {
		$deposits = HistoryDeposit::orderBy('id', 'DESC')->paginate(100);
		return view('admin.monitorings.monitoring-deposit', compact('deposits'));
	}
	public function pulsaMonitoring() {
		$transactions = PpobTransaction::where('service', 1)->orderBy('id', 'DESC')->paginate(100);
		return view('admin.monitorings.monitoring-pulsa', compact('transactions'));
	}
	public function ppobMonitoring() {
		$transactions = PpobTransaction::where('service', '<>', '1')->orderBy('id', 'DESC')->paginate(100);
		return view('admin.monitorings.monitoring-ppob', compact('transactions'));
	}

}
