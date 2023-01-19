<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Excel;
use Illuminate\Http\Request;
use JavaScript;

class SummariesController extends Controller {
	public function __construct() {
		$this->middleware(['auth']);
	}
	public function index(Request $request) {
		$date = date('Y-m-d');
		$from = date('Y-m-d');
		$until = $from;
		$reqLimit = 10;
		$reqSort = 'total_transactions';
		if ($request->has('from') && $request->has('until')) {
			$this->validate($request, [
				'from' => 'date',
				'until' => 'date',
			]);
			$from = date('Y-m-d', strtotime($request->from));
			$until = date('Y-m-d', strtotime($request->until));
			$reqLimit = $request->limit;
			$reqSort = $request->sort;
			$_token = $request->_token;
			if (daysDifference($from, $until) > 31) {
				flash()->overlay('Data Summary yang bisa Anda cek maksimal 31 hari.', 'INFO');
				return redirect()->back();
			}
		}
		$summaries = DB::select("SELECT users.username,users.name,count(airlines_booking.id) as total_transactions , SUM(airlines_transactions.total_fare) as total_market_price,
SUM(airlines_commissions.member) as total_smart_cash
FROM airlines_booking
INNER JOIN airlines_transactions ON airlines_booking.airlines_transaction_id = airlines_transactions.id
INNER JOIN users ON airlines_transactions.user_id = users.id
INNER JOIN airlines_commissions ON airlines_booking.id = airlines_commissions.airlines_booking_id
WHERE airlines_booking.updated_at BETWEEN '$from 00:00:00' AND '$until 23:59:59'
AND airlines_booking.status = 'ISSUED' GROUP BY airlines_transactions.user_id ORDER BY $reqSort DESC LIMIT $reqLimit");
		if ($request->has('export') && $request->export == '1') {
			$totalQuery = count($summaries);
			$while = ceil($totalQuery / 500);
			$collections = collect($summaries);
			return Excel::create($from . '_' . $until, function ($excel) use ($while, $collections) {
				for ($i = 1; $i <= $while; $i++) {
					$items = $collections->forPage($i, 500);
					Log::info($items);
					$excel->sheet('page-' . $i, function ($sheet) use ($items) {
						$sheet->loadView('admin.summaries.report._report-excel-summary', ['summaries' => $items]);
					});
				}
			})->export('xls');
		}
		$from = date('d-m-Y', strtotime($from));
		$until = date('d-m-Y', strtotime($until));
		JavaScript::put([
			'request' => [
				'from' => $from,
				'until' => $until,
			],
		]);
		$request->flash();
		return view('admin.summaries.airlines.index', compact('summaries', 'reqLimit', 'reqSort', 'from', 'until'));
	}

	public function train(Request $request) {
		$date = date('Y-m-d');
		$from = date('Y-m-d');
		$until = $from;
		$reqLimit = 10;
		$reqSort = 'total_transactions';
		if ($request->has('from') && $request->has('until')) {
			$this->validate($request, [
				'from' => 'date',
				'until' => 'date',
			]);
			$from = date('Y-m-d', strtotime($request->from));
			$until = date('Y-m-d', strtotime($request->until));
			$reqLimit = $request->limit;
			$reqSort = $request->sort;
			$_token = $request->_token;
			if (daysDifference($from, $until) > 31) {
				flash()->overlay('Data Summary yang bisa Anda cek maksimal 31 hari.', 'INFO');
				return redirect()->back();
			}
		}
		$summaries = DB::select("SELECT users.username,users.name,count(train_bookings.id) as total_transactions , SUM(train_transactions.total_fare) as total_market_price,
SUM(train_commissions.member) as total_smart_cash
FROM train_bookings
INNER JOIN train_transactions ON train_bookings.train_transaction_id = train_transactions.id
INNER JOIN users ON train_transactions.user_id = users.id
INNER JOIN train_commissions ON train_bookings.id = train_commissions.train_booking_id
WHERE train_bookings.updated_at BETWEEN '$from 00:00:00' AND '$until 23:59:59'
AND train_bookings.status = 'ISSUED' AND train_transactions.sip_service_id ='3' GROUP BY train_transactions.user_id ORDER BY $reqSort DESC LIMIT $reqLimit");
		if ($request->has('export') && $request->export == '1') {
			$totalQuery = count($summaries);
			$while = ceil($totalQuery / 500);
			$collections = collect($summaries);
			return Excel::create($from . '_' . $until, function ($excel) use ($while, $collections) {
				for ($i = 1; $i <= $while; $i++) {
					$items = $collections->forPage($i, 500);
					$excel->sheet('page-' . $i, function ($sheet) use ($items) {
						$sheet->loadView('admin.summaries.report._report-excel-summary', ['summaries' => $items]);
					});
				}
			})->export('xls');
		}
		$from = date('d-m-Y', strtotime($from));
		$until = date('d-m-Y', strtotime($until));
		JavaScript::put([
			'request' => [
				'from' => $from,
				'until' => $until,
			],
		]);
		$request->flash();
		return view('admin.summaries.train.index', compact('summaries', 'reqLimit', 'reqSort', 'from', 'until'));
	}
	public function railink(Request $request) {
		$date = date('Y-m-d');
		$from = date('Y-m-d');
		$until = $from;
		$reqLimit = 10;
		$reqSort = 'total_transactions';
		if ($request->has('from') && $request->has('until')) {
			$this->validate($request, [
				'from' => 'date',
				'until' => 'date',
			]);
			$from = date('Y-m-d', strtotime($request->from));
			$until = date('Y-m-d', strtotime($request->until));
			$reqLimit = $request->limit;
			$reqSort = $request->sort;
			$_token = $request->_token;
			if (daysDifference($from, $until) > 31) {
				flash()->overlay('Data Summary yang bisa Anda cek maksimal 31 hari.', 'INFO');
				return redirect()->back();
			}
		}
		$summaries = DB::select("SELECT users.username,users.name,count(railink_bookings.id) as total_transactions , SUM(train_transactions.total_fare) as total_market_price,
SUM(railink_commissions.member) as total_smart_cash
FROM railink_bookings
INNER JOIN train_transactions ON railink_bookings.train_transaction_id = train_transactions.id
INNER JOIN users ON train_transactions.user_id = users.id
INNER JOIN railink_commissions ON railink_bookings.id = railink_commissions.railink_booking_id
WHERE railink_bookings.updated_at BETWEEN '$from 00:00:00' AND '$until 23:59:59'
AND railink_bookings.status = 'ISSUED' AND train_transactions.sip_service_id ='4' GROUP BY train_transactions.user_id ORDER BY $reqSort DESC LIMIT $reqLimit");
		if ($request->has('export') && $request->export == '1') {
			$totalQuery = count($summaries);
			$while = ceil($totalQuery / 500);
			$collections = collect($summaries);
			return Excel::create($from . '_' . $until, function ($excel) use ($while, $collections) {
				for ($i = 1; $i <= $while; $i++) {
					$items = $collections->forPage($i, 500);
					$excel->sheet('page-' . $i, function ($sheet) use ($items) {
						$sheet->loadView('admin.summaries.report._report-excel-summary', ['summaries' => $items]);
					});
				}
			})->export('xls');
		}
		$from = date('d-m-Y', strtotime($from));
		$until = date('d-m-Y', strtotime($until));
		JavaScript::put([
			'request' => [
				'from' => $from,
				'until' => $until,
			],
		]);
		$request->flash();
		return view('admin.summaries.railink.index', compact('summaries', 'reqLimit', 'reqSort', 'from', 'until'));
	}
	public function pulsa(Request $request) {
		$date = date('Y-m-d');
		$from = date('Y-m-d');
		$until = $from;
		$reqLimit = 10;
		$reqSort = 'total_transactions';
		if ($request->has('from') && $request->has('until')) {
			$this->validate($request, [
				'from' => 'date',
				'until' => 'date',
			]);
			$from = date('Y-m-d', strtotime($request->from));
			$until = date('Y-m-d', strtotime($request->until));
			$reqLimit = $request->limit;
			$reqSort = $request->sort;
			$_token = $request->_token;
			if (daysDifference($from, $until) > 31) {
				flash()->overlay('Data Summary yang bisa Anda cek maksimal 31 hari.', 'INFO');
				return redirect()->back();
			}
		}
		$summaries = DB::select("SELECT users.username,users.name,count(ppob_transactions.id) as total_transactions , SUM(ppob_transactions.paxpaid) as total_market_price,
SUM(ppob_commissions.member) as total_smart_cash
FROM ppob_transactions
INNER JOIN users ON ppob_transactions.user_id = users.id
INNER JOIN ppob_commissions ON ppob_transactions.id = ppob_commissions.ppob_transaction_id
WHERE ppob_transactions.updated_at BETWEEN '$from 00:00:00' AND '$until 23:59:59'
AND ppob_transactions.status = 'SUCCESS' AND ppob_transactions.service ='1' GROUP BY ppob_transactions.user_id ORDER BY $reqSort DESC LIMIT $reqLimit");
		if ($request->has('export') && $request->export == '1') {
			$totalQuery = count($summaries);
			$while = ceil($totalQuery / 500);
			$collections = collect($summaries);
			return Excel::create($from . '_' . $until, function ($excel) use ($while, $collections) {
				for ($i = 1; $i <= $while; $i++) {
					$items = $collections->forPage($i, 500);
					$excel->sheet('page-' . $i, function ($sheet) use ($items) {
						$sheet->loadView('admin.summaries.report._report-excel-summary', ['summaries' => $items]);
					});
				}
			})->export('xls');
		}
		$from = date('d-m-Y', strtotime($from));
		$until = date('d-m-Y', strtotime($until));
		JavaScript::put([
			'request' => [
				'from' => $from,
				'until' => $until,
			],
		]);
		$request->flash();
		return view('admin.summaries.pulsa.index', compact('summaries', 'reqLimit', 'reqSort', 'from', 'until'));
	}
	public function ppob(Request $request) {
		$date = date('Y-m-d');
		$from = date('Y-m-d');
		$until = $from;
		$reqLimit = 10;
		$reqSort = 'total_transactions';
		if ($request->has('from') && $request->has('until')) {
			$this->validate($request, [
				'from' => 'date',
				'until' => 'date',
			]);
			$from = date('Y-m-d', strtotime($request->from));
			$until = date('Y-m-d', strtotime($request->until));
			$reqLimit = $request->limit;
			$reqSort = $request->sort;
			$_token = $request->_token;
			if (daysDifference($from, $until) > 31) {
				flash()->overlay('Data Summary yang bisa Anda cek maksimal 31 hari.', 'INFO');
				return redirect()->back();
			}
		}
		$summaries = DB::select("SELECT users.username,users.name,count(ppob_transactions.id) as total_transactions , SUM(ppob_transactions.paxpaid) as total_market_price,
SUM(ppob_commissions.member) as total_smart_cash
FROM ppob_transactions
INNER JOIN users ON ppob_transactions.user_id = users.id
INNER JOIN ppob_commissions ON ppob_transactions.id = ppob_commissions.ppob_transaction_id
WHERE ppob_transactions.updated_at BETWEEN '$from 00:00:00' AND '$until 23:59:59'
AND ppob_transactions.status = 'SUCCESS' AND ppob_transactions.service <>'1' GROUP BY ppob_transactions.user_id ORDER BY $reqSort DESC LIMIT $reqLimit");
		if ($request->has('export') && $request->export == '1') {
			$totalQuery = count($summaries);
			$while = ceil($totalQuery / 500);
			$collections = collect($summaries);
			return Excel::create($from . '_' . $until, function ($excel) use ($while, $collections) {
				for ($i = 1; $i <= $while; $i++) {
					$items = $collections->forPage($i, 500);
					$excel->sheet('page-' . $i, function ($sheet) use ($items) {
						$sheet->loadView('admin.summaries.report._report-excel-summary', ['summaries' => $items]);
					});
				}
			})->export('xls');
		}
		$from = date('d-m-Y', strtotime($from));
		$until = date('d-m-Y', strtotime($until));
		JavaScript::put([
			'request' => [
				'from' => $from,
				'until' => $until,
			],
		]);
		$request->flash();
		return view('admin.summaries.ppob.index', compact('summaries', 'reqLimit', 'reqSort', 'from', 'until'));
	}
	public function hotel(Request $request) {
		$date = date('Y-m-d');
		$from = date('Y-m-d');
		$until = $from;
		$reqLimit = 10;
		$reqSort = 'total_transactions';
		if ($request->has('from') && $request->has('until')) {
			$this->validate($request, [
				'from' => 'date',
				'until' => 'date',
			]);
			$from = date('Y-m-d', strtotime($request->from));
			$until = date('Y-m-d', strtotime($request->until));
			$reqLimit = $request->limit;
			$reqSort = $request->sort;
			$_token = $request->_token;
			if (daysDifference($from, $until) > 31) {
				flash()->overlay('Data Summary yang bisa Anda cek maksimal 31 hari.', 'INFO');
				return redirect()->back();
			}
		}
		$summaries = DB::select("SELECT users.username,users.name,count(hotel_transactions.id) as total_transactions , SUM(hotel_transactions.total_fare) as total_market_price,
SUM(hotel_commissions.member) as total_smart_cash
FROM hotel_transactions
INNER JOIN users ON hotel_transactions.user_id = users.id
INNER JOIN hotel_commissions ON hotel_transactions.id = hotel_commissions.hotel_transaction_id
WHERE hotel_transactions.updated_at BETWEEN '$from 00:00:00' AND '$until 23:59:59'
AND hotel_transactions.status = 'ISSUED' GROUP BY hotel_transactions.user_id ORDER BY $reqSort DESC LIMIT $reqLimit");
		if ($request->has('export') && $request->export == '1') {
			$totalQuery = count($summaries);
			$while = ceil($totalQuery / 500);
			$collections = collect($summaries);
			return Excel::create($from . '_' . $until, function ($excel) use ($while, $collections) {
				for ($i = 1; $i <= $while; $i++) {
					$items = $collections->forPage($i, 500);
					$excel->sheet('page-' . $i, function ($sheet) use ($items) {
						$sheet->loadView('admin.summaries.report._report-excel-summary', ['summaries' => $items]);
					});
				}
			})->export('xls');
		}
		$from = date('d-m-Y', strtotime($from));
		$until = date('d-m-Y', strtotime($until));
		JavaScript::put([
			'request' => [
				'from' => $from,
				'until' => $until,
			],
		]);
		$request->flash();
		return view('admin.summaries.hotel.index', compact('summaries', 'reqLimit', 'reqSort', 'from', 'until'));
	}
}
