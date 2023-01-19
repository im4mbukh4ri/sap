<?php

namespace App\Http\Controllers;

use App\CharityTransaction;
use App\Helpers\Deposit\Deposit;
use App\Helpers\SipCharity;
use Auth;
use Illuminate\Http\Request;
use JavaScript;

class CharitiesController extends Controller {
	public function __construct() {
		$this->middleware(['auth', 'csrf']);
	}
	public function index() {
		return view('charities.index');
	}
	public function transferCharity(Request $request) {
		$messages = [
			'required' => 'Form ini wajib di isi',
		];
		$this->validate($request, [
			'charity_id' => 'required|exists:charities,id',
			'nominal' => 'required',
			'password' => 'required',
		], $messages);
		$credentials = ['username' => $request->user()->username, 'password' => $request->password];
		$userLogin = Auth::once($credentials);
		if ($userLogin) {
			$nominal = (int) str_replace(',', '', $request->nominal);
			$minCharity = 1000;
			if ((int) $nominal % $minCharity != 0) {
				$message = 'Minimal transfer charity adalah kelipatan IDR ' . number_format($minCharity) . '';
				flash()->overlay($message, 'INFO');
				// $request->session()->flash('alert-danger', $message);
				return redirect()->back();
			}
			if (!Deposit::check($request->user()->id, $nominal)) {
				flash()->overlay('Saldo Anda tidak cukup untuk melakukan transfer charity.', 'INFO');
				// $request->session()->flash('alert-danger', 'Saldo Anda tidak cukup untuk melakukan transfer charity.');
				return redirect()->back();
			}
			$transferCharity = SipCharity::TransferCharity($request->user()->id, $request->charity_id, $nominal);
			if ($transferCharity['status']['code'] == 200) {
				// flash()->overlay('Berhasil transfer charity.', 'INFO');
				$request->session()->flash('alert-success', 'Transfer Berhasil');
				return redirect()->back();
			}
			flash()->overlay('Gagal transfer charity.', 'INFO');
			// $request->session()->flash('alert-danger', 'Gagal Tranfer Charity');
			return redirect()->back();
		}
		flash()->overlay('Password Salah.', 'INFO');
		// $request->session()->flash('alert-danger', 'Password Salah');
		return redirect()->back();
	}
	public function report(Request $request) {
		$from = date("Y-m-d", time());
		$until = date("Y-m-d", time());
		if ($request->has('from') && $request->has('until')) {
			$from = date('Y-m-d', strtotime($request->from));
			$until = date('Y-m-d', strtotime($request->until));
			$charities = CharityTransaction::whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->where('user_id', $request->user()->id)->get();
			$request->flash();
			JavaScript::put([
				'request' => [
					'from' => $from,
					'until' => $until,
				],
			]);
			$request->flash();
		} else {
			$date = date('Y-m-d');
			$charities = CharityTransaction::whereBetween('created_at', [$date . ' 00:00:00', $date . ' 23:59:59'])->where('user_id', $request->user()->id)->get();
		}
		$from = date('d-m-Y', strtotime($from));
		$until = date('d-m-Y', strtotime($until));
		JavaScript::put([
			'request' => [
				'from' => $from,
				'until' => $until,
			],
		]);
		return view('charities.reports.index', compact('charities', 'from', 'until', 'charity'));
	}
}
