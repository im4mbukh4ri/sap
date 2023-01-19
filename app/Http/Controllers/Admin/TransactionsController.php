<?php

namespace App\Http\Controllers\Admin;

use App\AirlinesBooking;
use App\AirlinesTransaction;
use App\Http\Controllers\Controller;
use App\PpobTransaction;
use App\RailinkBooking;
use App\RequestResetPassword;
use App\RequestTransferDeposit;
use App\TrainBooking;
use App\AirlinesItinerary;
use App\Hotel;
use App\HotelTransaction;
use App\HotelVoucher;
use Excel;
use Illuminate\Http\Request;
use JavaScript;
use Log;
use DB;

class TransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function airlines(Request $request)
    {
        $startDate = date("Y-m-d", time());
        $endDate = date("Y-m-d", time());
        $statusReq = $request->status;
        $_token = str_random(40);
        if ($request->has('pnr') && $request->pnr != '') {
            $pnrReq = $request->pnr;
            $sum = 0;
            $request->flash();
            $startDate = date('d-m-Y', strtotime($startDate));
            $endDate = date('d-m-Y', strtotime($endDate));
            JavaScript::put([
                'request' => [
                    'from' => $startDate,
                    'until' => $endDate,
                ],
            ]);
            $request->flash();
            $itineraries = AirlinesItinerary::where('pnr', $pnrReq)->get();
            return view('admin.transactions.airlines.find-pnr', compact('_token', 'itineraries', 'startDate', 'endDate', 'statusReq', 'pnrReq'));
        } else {
            if ($request->has('start_date') && $request->has('end_date') && $request->pnr == '') {
                $this->validate($request, [
                    'start_date' => 'date',
                    'end_date' => 'date',
                    '_token' => 'required',
                ]);
                $startDate = date('Y-m-d', strtotime($request->start_date));
                $endDate = date('Y-m-d', strtotime($request->end_date));
                $_token = $request->_token;
                if (daysDifference($startDate, $endDate) > 31) {
                    flash()->overlay('Transaksi maskapai yang bisa Anda cek maksimal 31 hari.', 'INFO');
                    return redirect()->back();
                }
            }
            if ($request->has('export') && $request->export == '1') {
                $bookings = AirlinesBooking::whereBetWeen('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'LIKE', '%' . $statusReq . '%')->where('status', '<>', 'failed')->get();
                $totalQuery = count($bookings);
                $while = ceil($totalQuery / 500);
                $collections = collect($bookings);
                return Excel::create($startDate . '_' . $endDate, function ($excel) use ($while, $collections) {
                    for ($i = 1; $i <= $while; $i++) {
                        $items = $collections->forPage($i, 500);
                        Log::info($items);
                        $excel->sheet('page-' . $i, function ($sheet) use ($items) {
                            $sheet->loadView('admin.partials._report-excel-airlines', ['bookings' => $items]);
                        });
                    }
                })->export('xls');
            }
            $bookings = AirlinesBooking::whereBetWeen('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'LIKE', '%' . $statusReq . '%')->where('status', '<>', 'failed')->paginate(500);
            $totalAmount = DB::select("SELECT SUM(airlines_booking.paxpaid) as total_marketprice, SUM(airlines_commissions.pusat) as total_pusat, SUM(airlines_commissions.bv) as total_smartpoint, SUM(airlines_commissions.member) as total_smarcash FROM airlines_booking
						INNER JOIN airlines_commissions ON airlines_booking.id = airlines_commissions.airlines_booking_id WHERE airlines_booking.created_at BETWEEN '{$startDate} 00:00:00' AND '{$endDate} 23:59:59' AND airlines_booking.status LIKE '%{$statusReq}%' AND status <> 'failed'");
        }
        $request->flash();
        $startDate = date('d-m-Y', strtotime($startDate));
        $endDate = date('d-m-Y', strtotime($endDate));
        JavaScript::put([
            'request' => [
                'from' => $startDate,
                'until' => $endDate,
            ],
        ]);
        return view('admin.transactions.airlines.index', compact('_token', 'bookings', 'startDate', 'endDate', 'statusReq', 'totalAmount'));
    }
    public function airlinesShow($id)
    {
        $transaction = AirlinesTransaction::find($id);
        if ($transaction) {
            return view('admin.transactions.airlines.show', compact('transaction'));
        }
        return redirect()->back();
    }
    public function train(Request $request)
    {
        $startDate = date("Y-m-d", time());
        $endDate = date("Y-m-d", time());
        $statusReq = $request->status;
        $_token = str_random(40);
        if ($request->has('pnr') && $request->pnr != '') {
            $pnrReq = $request->pnr;
            $sum = 0;
            $request->flash();
            $startDate = date('d-m-Y', strtotime($startDate));
            $endDate = date('d-m-Y', strtotime($endDate));
            JavaScript::put([
                'request' => [
                    'from' => $startDate,
                    'until' => $endDate,
                ],
            ]);
            $request->flash();
            $bookings = TrainBooking::where('pnr', $pnrReq)->paginate(10);

            return view('admin.transactions.train.index', compact('_token', 'bookings', 'startDate', 'endDate', 'statusReq', 'pnrReq'));
        }
        if ($request->has('start_date') && $request->has('end_date')) {
            $this->validate($request, [
                'start_date' => 'date',
                'end_date' => 'date',
                '_token' => 'required',
            ]);
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $_token = $request->_token;
            if (daysDifference($startDate, $endDate) > 31) {
                flash()->overlay('Transaksi maskapai yang bisa Anda cek maksimal 31 hari.', 'INFO');
                return redirect()->back();
            }
        }
        if ($request->has('export') && $request->export == '1') {
            $bookings = TrainBooking::whereBetWeen('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'LIKE', '%' . $statusReq . '%')->where('status', '<>', 'failed')->get();
            $totalQuery = count($bookings);
            $while = ceil($totalQuery / 500);
            $collections = collect($bookings);
            return Excel::create($startDate . '_' . $endDate, function ($excel) use ($while, $collections) {
                for ($i = 1; $i <= $while; $i++) {
                    $items = $collections->forPage($i, 500);
                    Log::info($items);
                    $excel->sheet('page-' . $i, function ($sheet) use ($items) {
                        $sheet->loadView('admin.partials._report-excel-train', ['bookings' => $items]);
                    });
                }
            })->export('xls');
        }
        $bookings = TrainBooking::whereBetWeen('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'LIKE', '%' . $statusReq . '%')->where('status', '<>', 'failed')->paginate(500);
        $totalAmount = DB::select("SELECT SUM(train_bookings.paxpaid) as total_marketprice, SUM(train_commissions.pusat) as total_pusat, SUM(train_commissions.bv) as total_smartpoint, SUM(train_commissions.member) as total_smarcash FROM train_bookings
					INNER JOIN train_commissions ON train_bookings.id = train_commissions.train_booking_id WHERE train_bookings.created_at BETWEEN '{$startDate} 00:00:00' AND '{$endDate} 23:59:59' AND train_bookings.status LIKE '%{$statusReq}%' AND status <> 'failed'");
        $request->flash();
        $startDate = date('d-m-Y', strtotime($startDate));
        $endDate = date('d-m-Y', strtotime($endDate));
        JavaScript::put([
            'request' => [
                'from' => $startDate,
                'until' => $endDate,
            ],
        ]);
        return view('admin.transactions.train.index', compact('_token', 'bookings', 'startDate', 'endDate', 'statusReq', 'totalAmount'));
    }
    public function railink(Request $request)
    {
        $startDate = date("Y-m-d", time());
        $endDate = date("Y-m-d", time());
        $statusReq = $request->status;
        $_token = str_random(40);
        if ($request->has('start_date') && $request->has('end_date')) {
            $this->validate($request, [
                'start_date' => 'date',
                'end_date' => 'date',
                '_token' => 'required',
            ]);
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $_token = $request->_token;
            if (daysDifference($startDate, $endDate) > 31) {
                flash()->overlay('Transaksi maskapai yang bisa Anda cek maksimal 31 hari.', 'INFO');
                return redirect()->back();
            }
        }
        if ($request->has('export') && $request->export == '1') {
            $bookings = RailinkBooking::whereBetWeen('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'LIKE', '%' . $statusReq . '%')->where('status', '<>', 'failed')->get();
            $totalQuery = count($bookings);
            $while = ceil($totalQuery / 500);
            $collections = collect($bookings);
            return Excel::create($startDate . '_' . $endDate, function ($excel) use ($while, $collections) {
                for ($i = 1; $i <= $while; $i++) {
                    $items = $collections->forPage($i, 500);
                    Log::info($items);
                    $excel->sheet('page-' . $i, function ($sheet) use ($items) {
                        $sheet->loadView('admin.partials._report-excel-railink', ['bookings' => $items]);
                    });
                }
            })->export('xls');
        }
        $bookings = RailinkBooking::whereBetWeen('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'LIKE', '%' . $statusReq . '%')->where('status', '<>', 'failed')->paginate(500);
        $totalAmount = DB::select("SELECT SUM(railink_bookings.paxpaid) as total_marketprice, SUM(railink_commissions.pusat) as total_pusat, SUM(railink_commissions.bv) as total_smartpoint, SUM(railink_commissions.member) as total_smarcash FROM railink_bookings
					INNER JOIN railink_commissions ON railink_bookings.id = railink_commissions.railink_booking_id WHERE railink_bookings.created_at BETWEEN '{$startDate} 00:00:00' AND '{$endDate} 23:59:59' AND railink_bookings.status LIKE '%{$statusReq}%' AND status <> 'failed'");
        $request->flash();
        $startDate = date('d-m-Y', strtotime($startDate));
        $endDate = date('d-m-Y', strtotime($endDate));
        JavaScript::put([
            'request' => [
                'from' => $startDate,
                'until' => $endDate,
            ],
        ]);
        return view('admin.transactions.railink.index', compact('_token', 'bookings', 'startDate', 'endDate', 'statusReq', 'totalAmount'));
    }
    public function pulsa(Request $request)
    {
        Log::info($request->all());
        $startDate = date("Y-m-d", time());
        $endDate = date("Y-m-d", time());
        $statusReq = $request->status;
        $_token = str_random(40);
        if ($request->has('start_date') && $request->has('end_date')) {
            $this->validate($request, [
                'start_date' => 'date',
                'end_date' => 'date',
                '_token' => 'required',
            ]);
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $_token = $request->_token;
            if (daysDifference($startDate, $endDate) > 31) {
                flash()->overlay('Transaksi pulsa yang bisa Anda cek maksimal 31 hari.', 'INFO');
                return redirect()->back();
            }
        }
        if ($request->has('export') && $request->export == '1') {
            // $transactions = PpobTransaction::where('service', 1)->where('status', 'LIKE', '%' . $statusReq . '%')->whereBetWeen('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();
            // Query baru
            $transactions = DB::table('ppob_transactions')
                ->join('users', 'users.id', '=', 'ppob_transactions.user_id')
                ->join('ppob_commissions', 'ppob_commissions.ppob_transaction_id', '=', 'ppob_transactions.id')
                ->join('ppob_services', 'ppob_services.id', '=', 'ppob_transactions.ppob_service_id')
                ->leftJoin('ppob_services AS services', 'services.id', '=', 'ppob_services.parent_id')
                ->select(
                    'ppob_transactions.id AS id',
                    'ppob_transactions.created_at AS created_at',
                    'users.username AS username',
                    'services.name AS service',
                    'ppob_services.name AS name',
                    'ppob_transactions.number AS number',
                    'ppob_transactions.paxpaid AS paxpaid',
                    'ppob_transactions.nta AS nta',
                    'ppob_transactions.nra AS nra',
                    'ppob_transactions.bv_markup AS bv_markup',
                    'ppob_transactions.status AS status',
                    'ppob_commissions.komisi AS commission_komisi',
                    'ppob_commissions.free AS commission_free',
                    'ppob_commissions.pusat AS commission_pusat',
                    'ppob_commissions.bv AS commission_bv',
                    'ppob_commissions.member AS commission_member',
                    'ppob_commissions.upline AS commission_upline'
                )->where('ppob_transactions.service', 1)->whereBetween('ppob_transactions.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('ppob_transactions.status', '=', $statusReq)->get();
            // return $transactions;
            // Akhir dari query baru
            // $totalQuery = count($transactions);
            // $while = ceil($totalQuery / 500);
            // $collections = collect($transactions);
            return Excel::create($startDate . '_' . $endDate, function ($excel) use ($transactions) {
                // $items = $collections->forPage($i, 500);
                $excel->sheet('pulsa', function ($sheet) use ($transactions) {
                    $sheet->loadView('admin.partials._report-excel-pulsa', ['transactions' => $transactions]);
                });
            })->export('csv');
        }
        $transactions = PpobTransaction::where('service', 1)->where('status', 'LIKE', '%' . $statusReq . '%')->whereBetWeen('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->paginate(500);
        $totalAmount = DB::select("SELECT SUM(ppob_transactions.paxpaid) as total_marketprice, SUM(ppob_commissions.pusat) as total_pusat, SUM(ppob_commissions.bv) as total_smartpoint, SUM(ppob_commissions.member) as total_smarcash FROM ppob_transactions
					INNER JOIN ppob_commissions ON ppob_transactions.id = ppob_commissions.ppob_transaction_id WHERE ppob_transactions.created_at BETWEEN '{$startDate} 00:00:00' AND '{$endDate} 23:59:59' AND ppob_transactions.status LIKE '%{$statusReq}%' AND status <> 'failed' AND service =1");
        $request->flash();
        $startDate = date('d-m-Y', strtotime($startDate));
        $endDate = date('d-m-Y', strtotime($endDate));
        JavaScript::put([
            'request' => [
                'from' => $startDate,
                'until' => $endDate,
            ],
        ]);
        return view('admin.transactions.pulsa.index', compact('_token', 'transactions', 'startDate', 'endDate', 'statusReq', 'totalAmount'));
    }
    public function ppob(Request $request)
    {
        $startDate = date("Y-m-d", time());
        $endDate = date("Y-m-d", time());
        $transactions = array();
        $statusReq = $request->status;
        $serviceReq = $request->service;
        $_token = str_random(40);
        if ($request->has('start_date') && $request->has('end_date')) {
            $this->validate($request, [
                'start_date' => 'date',
                'end_date' => 'date',
                '_token' => 'required',
            ]);
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $_token = $request->_token;
            if (daysDifference($startDate, $endDate) > 31) {
                flash()->overlay('Transaksi pulsa yang bisa Anda cek maksimal 31 hari.', 'INFO');
                return redirect()->back();
            }
        }
        if ($request->has('export') && $request->export == '1') {
            // where('service', $serviceReq)
            $transactions = DB::table('ppob_transactions')
                ->join('users', 'users.id', '=', 'ppob_transactions.user_id')
                ->join('ppob_commissions', 'ppob_commissions.ppob_transaction_id', '=', 'ppob_transactions.id')
                ->join('ppob_services', 'ppob_services.id', '=', 'ppob_transactions.ppob_service_id')
                ->leftJoin('ppob_services AS services', 'services.id', '=', 'ppob_services.parent_id')
                ->select(
                    'ppob_transactions.id AS id',
                    'ppob_transactions.created_at AS created_at',
                    'users.username AS username',
                    'services.name AS service',
                    'ppob_services.name AS name',
                    'ppob_transactions.number AS number',
                    'ppob_transactions.paxpaid AS paxpaid',
                    'ppob_transactions.nta AS nta',
                    'ppob_transactions.nra AS nra',
                    'ppob_transactions.bv_markup AS bv_markup',
                    'ppob_transactions.status AS status',
                    'ppob_commissions.komisi AS commission_komisi',
                    'ppob_commissions.free AS commission_free',
                    'ppob_commissions.pusat AS commission_pusat',
                    'ppob_commissions.bv AS commission_bv',
                    'ppob_commissions.member AS commission_member',
                    'ppob_commissions.upline AS commission_upline'
                )->where('ppob_transactions.service', $serviceReq)->whereBetween('ppob_transactions.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('ppob_transactions.status', '=', $statusReq)->get();
            // return $transactions;
            // Akhir dari query baru
            // $totalQuery = count($transactions);
            // $while = ceil($totalQuery / 500);
            // $collections = collect($transactions);
            return Excel::create($startDate . '_' . $endDate, function ($excel) use ($transactions) {
                // $items = $collections->forPage($i, 500);
                $excel->sheet('ppob', function ($sheet) use ($transactions) {
                    $sheet->loadView('admin.partials._report-excel-pulsa', ['transactions' => $transactions]);
                });
            })->export('csv');
        }
        $transactions = PpobTransaction::where('service', $serviceReq)->where('status', 'LIKE', '%' . $statusReq . '%')->whereBetWeen('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->paginate(500);
        $totalAmount = DB::select("SELECT SUM(ppob_transactions.paxpaid) as total_marketprice, SUM(ppob_commissions.pusat) as total_pusat, SUM(ppob_commissions.bv) as total_smartpoint, SUM(ppob_commissions.member) as total_smarcash FROM ppob_transactions
					INNER JOIN ppob_commissions ON ppob_transactions.id = ppob_commissions.ppob_transaction_id WHERE ppob_transactions.created_at BETWEEN '{$startDate} 00:00:00' AND '{$endDate} 23:59:59' AND ppob_transactions.status LIKE '%{$statusReq}%' AND status <> 'failed' AND service = '{$serviceReq}'");
        $request->flash();
        $startDate = date('d-m-Y', strtotime($startDate));
        $endDate = date('d-m-Y', strtotime($endDate));
        JavaScript::put([
            'request' => [
                'from' => $startDate,
                'until' => $endDate,
            ],
        ]);
        return view('admin.transactions.ppob.index', compact('_token', 'transactions', 'startDate', 'endDate', 'statusReq', 'serviceReq', 'totalAmount'));
    }
    public function statusPulsa(Request $request)
    {
        if ($request->has('id')) {
            $transaction = PpobTransaction::find($request->id);
            $transaction->serial_number = '-';
            if ($transaction != null) {
                switch ($transaction->service) {
                    case 1:
                        $findSN = $transaction->serial_number()->first();
                        if ($findSN != null) {
                            $transaction->serial_number = $findSN->serial_number;
                        }
                        break;
                    case 2:
                        $findSN = $transaction->pln_pra->token;
                        if ($findSN != null) {
                            $transaction->serial_number = $findSN;
                        }
                        break;
                    default:
                        $findSN = $transaction->serial_number()->first();
                        if ($findSN != null) {
                            $transaction->serial_number = $findSN->serial_number;
                        }
                        break;
                }
            }
            $request->flash();
            return view('admin.transactions.statuses.pulsa.index', compact('transaction'));
        }
        return view('admin.transactions.statuses.pulsa.index');
    }
    public function updateStatusPulsa(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:ppob_transactions,id',
            'status' => 'required',
        ]);
        $transaction = PpobTransaction::find($request->id);
        $transaction->status = $request->status;
        $transaction->save();
        flash()->overlay('Update berhasil.', 'INFO');
        return redirect()->back();
    }
    public function resetPassword(Request $request)
    {
        $startDate = date("Y-m-d", time());
        $endDate = date("Y-m-d", time());
        $statusReq = $request->status;
        if ($request->has('start_date') && $request->has('end_date')) {
            $this->validate($request, [
                'start_date' => 'date',
                'end_date' => 'date',
                '_token' => 'required',
            ]);
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $_token = $request->_token;
            if (daysDifference($startDate, $endDate) > 31) {
                flash()->overlay('Transaksi pulsa yang bisa Anda cek maksimal 31 hari.', 'INFO');
                return redirect()->back();
            }
        }

        $resetpasswords = RequestResetPassword::whereBetWeen('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'LIKE', '%' . $statusReq . '%')->get();
        $startDate = date('d-m-Y', strtotime($startDate));
        $endDate = date('d-m-Y', strtotime($endDate));
        $request->flash();
        JavaScript::put([
            'request' => [
                'from' => $startDate,
                'until' => $endDate,
            ],
        ]);
        return view('admin.transactions.reset-password.index', compact('_token', 'resetpasswords', 'startDate', 'endDate', 'statusReq'));
    }
    public function transferDeposit(Request $request)
    {
        $startDate = date("Y-m-d", time());
        $endDate = date("Y-m-d", time());
        $statusReq = $request->status;
        if ($request->has('start_date') && $request->has('end_date')) {
            $this->validate($request, [
                'start_date' => 'date',
                'end_date' => 'date',
                '_token' => 'required',
            ]);
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $_token = $request->_token;
            if (daysDifference($startDate, $endDate) > 31) {
                flash()->overlay('Transaksi Transfer Deposit yang bisa Anda cek maksimal 31 hari.', 'INFO');
                return redirect()->back();
            }
        }

        $transferdeposites = RequestTransferDeposit::whereBetWeen('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'LIKE', '%' . $statusReq . '%')->get();
        $startDate = date('d-m-Y', strtotime($startDate));
        $endDate = date('d-m-Y', strtotime($endDate));
        $request->flash();
        JavaScript::put([
            'request' => [
                'from' => $startDate,
                'until' => $endDate,
            ],
        ]);
        return view('admin.transactions.transfer-deposit.index', compact('_token', 'transferdeposites', 'startDate', 'endDate', 'statusReq'));
    }
    public function hotels(Request $request)
    {
        $startDate = date("Y-m-d", time());
        $endDate = date("Y-m-d", time());
        $statusReq = $request->status;
        $_token = str_random(40);
        if ($request->has('pnr') && $request->pnr != '') {
            $pnrReq = $request->pnr;
            $sum = 0;
            $request->flash();
            $startDate = date('d-m-Y', strtotime($startDate));
            $endDate = date('d-m-Y', strtotime($endDate));
            JavaScript::put([
                'request' => [
                    'from' => $startDate,
                    'until' => $endDate,
                ],
            ]);

            $voucher = HotelVoucher::where('voucher', $pnrReq)->first();
            if (!$voucher) {
                $request->flash();
                flash()->overlay('Kode Voucher ' . $pnrReq . ' tidak ditemukan', 'INFO');
                return redirect()->back();
            }
            $request->flash();
            $booking = $voucher->transaction;
            return view('admin.transactions.hotels.find-pnr', compact('_token', 'booking', 'startDate', 'endDate', 'statusReq', 'pnrReq'));
        } else {
            if ($request->has('start_date') && $request->has('end_date') && $request->pnr == '') {
                $this->validate($request, [
                    'start_date' => 'date',
                    'end_date' => 'date',
                    '_token' => 'required',
                ]);
                $startDate = date('Y-m-d', strtotime($request->start_date));
                $endDate = date('Y-m-d', strtotime($request->end_date));
                $_token = $request->_token;
                if (daysDifference($startDate, $endDate) > 31) {
                    flash()->overlay('Transaksi maskapai yang bisa Anda cek maksimal 31 hari.', 'INFO');
                    return redirect()->back();
                }
            }
            if ($request->has('export') && $request->export == '1') {
                $bookings = HotelTransaction::whereBetWeen('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'LIKE', '%' . $statusReq . '%')->where('status', '<>', 'failed')->get();
                $totalQuery = count($bookings);
                $while = ceil($totalQuery / 500);
                $collections = collect($bookings);
                return Excel::create($startDate . '_' . $endDate, function ($excel) use ($while, $collections) {
                    for ($i = 1; $i <= $while; $i++) {
                        $items = $collections->forPage($i, 500);
                        Log::info($items);
                        $excel->sheet('page-' . $i, function ($sheet) use ($items) {
                            $sheet->loadView('admin.partials._report-excel-hotel', ['bookings' => $items]);
                        });
                    }
                })->export('xls');
            }
            $bookings = HotelTransaction::whereBetWeen('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'LIKE', '%' . $statusReq . '%')->where('status', '<>', 'failed')->paginate(500);
            $totalAmount = DB::select("SELECT SUM(hotel_transactions.total_fare) as total_marketprice, SUM(hotel_commissions.pusat) as total_pusat, SUM(hotel_commissions.bv) as total_smartpoint, SUM(hotel_commissions.member) as total_smarcash FROM hotel_transactions
						INNER JOIN hotel_commissions ON hotel_transactions.id = hotel_commissions.hotel_transaction_id WHERE hotel_transactions.created_at BETWEEN '{$startDate} 00:00:00' AND '{$endDate} 23:59:59' AND hotel_transactions.status LIKE '%{$statusReq}%' AND status <> 'failed'");
        }
        $request->flash();
        $startDate = date('d-m-Y', strtotime($startDate));
        $endDate = date('d-m-Y', strtotime($endDate));
        JavaScript::put([
            'request' => [
                'from' => $startDate,
                'until' => $endDate,
            ],
        ]);
        return view('admin.transactions.hotels.index', compact('_token', 'bookings', 'startDate', 'endDate', 'statusReq', 'totalAmount'));
    }
}
