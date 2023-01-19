<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Deposit\Deposit;
use App\HistoryDeposit;
use App\Http\Controllers\Controller;
use App\TicketDeposit;
use App\User;
use Excel;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JavaScript;
use Laracasts\Flash\Flash;
use Log;

class DepositsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $time = time();
        $date = date('Y-m-d', $time);
        $user = auth()->user();
        $deposits = $user->deposits()->where('created_at', 'LIKE', $date . '%')->get();
        // $deposits = \App\Deposit::where('created_at', 'LIKE', $date . '%')->where('created_by', 1)->get();
        return view('admin.deposits.index', compact('deposits', 'date'));
    }

    public function update(Request $request)
    {
        if (Auth::attempt(['username' => $request->user()->username, 'password' => $request->password])) {
            $user = User::where('username', $request->username)->first();
            DB::beginTransaction();
            try {
                if ($request->deposit === 'credit') {
                    $credit = \App\Deposit::create([
                        'user_id' => $user->id,
                        'user_deposit' => $request->user_deposit,
                        'debit' => 0,
                        'credit' => $request->nominal,
                        'note' => 'Penambahan deposit IDR ' . number_format($request->nominal) . '. ' . $request->note,
                        'created_by' => $request->user()->id,
                    ]);
                    $result = Deposit::credit($user->id, $request->nominal, 'credit|' . $credit->id . '|Penambahan deposit IDR ' . number_format($request->nominal) . '. ' . $request->note)->get();
                    if ($result['status']['code'] == 400) {
                        DB::rollback();
                        flash()->overlay('Penambahkan deposit gagal, Silahkan ulangi kembali.', 'INFO');
                        return redirect()->route('admin.deposits_index');
                    }
                    flash()->overlay('Penambahkan deposit berhasil.', 'INFO');
                } else {
                    $debit = \App\Deposit::create([
                        'user_id' => $user->id,
                        'user_deposit' => $request->user_deposit,
                        'debit' => $request->nominal,
                        'credit' => 0,
                        'note' => 'Penarikan deposit IDR ' . number_format($request->nominal) . '. ' . $request->note,
                        'created_by' => $request->user()->id,
                    ]);
                    $result = Deposit::debit($user->id, $request->nominal, 'debit|' . $debit->id . '|Penarikan deposit IDR ' . number_format($request->nominal) . '. ' . $request->note)->get();
                    if ($result['status']['code'] == 400) {
                        DB::rollback();
                        flash()->overlay('Penarikan deposit gagal, Silahkan ulangi kembali.', 'INFO');
                        return redirect()->route('admin.deposits_index');
                    }
                    flash()->overlay('Penarikan deposit berhasil.', 'INFO');
                }
            } catch (\Exception $e) {
                DB::rollback();
                Log::info('failed credit deposit, error : ' . $e->getMessage());
                flash()->overlay('Gagal menambahkan deposit.', 'INFO');
                return redirect()->route('admin.deposits_index');
            }
            DB::commit();
            return redirect()->route('admin.deposits_index');
        }
        return "Unauthorization";
    }
    public function report_manual_deposit(Request $request)
    {
        $admin = User::where('role', '=', 'admin')->get();
        $adminList = array();
        foreach ($admin as $key => $value) {
            $adminList[]= $value->id;
        }
        $tickets = array();
        if ($request->has('from') && $request->has('until')) {
            $this->validate($request, [
                'from' => 'required|date',
                'until' => 'required|date',
            ]);
            $from = date("Y-m-d", strtotime($request->from));
            $until = date("Y-m-d", strtotime($request->until));
            if (daysDifference($from, $until) > 31) {
                flash()->overlay('Pengecekan maksimal 31 hari.', 'INFO');
                return redirect()->back();
            }
            if ($request->has('export') && $request->export == '1') {
                $tickets = \App\Deposit::whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])
                    ->whereIn('created_by', $adminList)->get();
                $totalQuery = count($tickets);
                $while = ceil($totalQuery / 500);
                $collections = collect($tickets);
                return Excel::create($from . '_' . $until, function ($excel) use ($while, $collections) {
                    for ($i = 1; $i <= $while; $i++) {
                        $items = $collections->forPage($i, 500);
                        $excel->sheet('page-' . $i, function ($sheet) use ($items) {
                            $sheet->loadView('admin.partials._report-excel-manual-deposit', ['tickets' => $items]);
                        });
                    }
                })->export('xls');
            }
            $tickets = \App\Deposit::whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])
                ->whereIn('created_by', $adminList)->get();
            $request->flash();
            return view('admin.deposits.report-manual-deposit', compact('tickets', 'from', 'until'));
        }
        $from = date('Y-m-d');
        $until = date('Y-m-d');
        JavaScript::put([
            'request' => [
                'from' => date('d-m-Y'),
                'until' => date('d-m-Y'),
            ],
        ]);
        $tickets = \App\Deposit::whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])
            ->whereIn('created_by', [1, 48794, 52129, 66878, 66885, 66890, 66891, 66892, 66897, 66918, 66921, 67407, 67410, 70404, 70421, 71051])->get();
        $request->flash();
        return view('admin.deposits.report-manual-deposit', compact('tickets', 'from', 'until'));
    }
    public function showTicket(Request $request)
    {
        $tickets = array();
        if ($request->has('from')) {
            $this->validate($request, [
                'from' => 'required|date',
                'until' => 'required|date',
                'status' => 'required',
                'sip_bank_id' => 'required'
            ]);
            $from = date("Y-m-d", strtotime($request->from));
            $until = date("Y-m-d", strtotime($request->until));
            ($request->status == 'ALL') ? $status = '' : $status = $request->status;
            ($request->sip_bank_id == 'ALL') ? $bankId = null : $bankId = $request->sip_bank_id;
            if ($request->has('export') && $request->export == '1') {
                if ($bankId != null) {
                    $tickets = TicketDeposit::where('status', 'like', '%' . $status . '%')
                      ->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->where('sip_bank_id', '=', $bankId)->get();
                } else {
                    $tickets = TicketDeposit::where('status', 'like', '%' . $status . '%')
                      ->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get();
                }
                $totalQuery = count($tickets);
                $while = ceil($totalQuery / 500);
                $collections = collect($tickets);

                return Excel::create($from . '_' . $until, function ($excel) use ($while, $collections) {
                    for ($i = 1; $i <= $while; $i++) {
                        $items = $collections->forPage($i, 500);
                        $excel->sheet('page-' . $i, function ($sheet) use ($items) {
                            $sheet->loadView('admin.partials._report-excel-deposit', ['tickets' => $items]);
                        });
                    }
                })->export('xls');
            }

            if ($bankId != null) {
                $tickets = TicketDeposit::where('status', 'like', '%' . $status . '%')
                    ->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->where('sip_bank_id', '=', $bankId)->get();
            } else {
                $tickets = TicketDeposit::where('status', 'like', '%' . $status . '%')
                    ->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get();
            }
        }
        $request->flash();
        return view('admin.deposits.ticket', compact('tickets'));
    }
    public function updateTicket(Request $request)
    {
        $this->validate($request, [
            'ticket_id' => 'required|exists:ticket_deposits,id',
        ]);
        DB::beginTransaction();
        try {
            $ticket = TicketDeposit::find($request->ticket_id);
            $user_id = $ticket->user->id;
            if ($ticket->status == "waiting-transfer") {
                $result = Deposit::credit($user_id, $ticket->nominal, 'ticket|' . $ticket->id . '|Penambahan deposit IDR ' . number_format($ticket->nominal))->get();
                if ($result['status']['code'] == 400) {
                    DB::rollback();
                    flash()->overlay('Gagal menambahkan deposit.', 'INFO');
                    return redirect()->back();
                }
                $ticket->status = 'accepted';
                $ticket->updated_by = auth()->user()->id;
                $ticket->save();
                if($ticket->user->phone_number) {
                    $client = new Client;
                    $client->post('https://api.smartinpays.com:8443/others/notifications',[
                            'headers' => [
                                'Content-Type'=> 'application/json',
                                'Accept'=> 'application/json',
                                'Locale'=> 'id',
                                'Lat'=> -7.229307,
                                'Device-Id'=> '988yqwfbjsdf',
                                'Device-Model' => 'SM-N9500',
                                'Device-Manufacture' => 'samsung',
                                'Device-OS-Version' => '8.0',
                                'Lng' => 112.123234,
                                'App-Version' => '1.0.0',
                                'Device-Type' => 'android'
                            ],
                            'json' => [
                                "phone_number" => $ticket->user->phone_number,
                                "title" => 'Penambahan deposit IDR ' . number_format($ticket->nominal),
                                "description"  => 'Penambahan deposit IDR ' . number_format($ticket->nominal),
                                "url_image"=> "https://smartinpays.com/assets/images/login/services/smart-store.png",
                                "route"=> "default",
                                "sound"=> "default",
                                "silent"=> false,
                                "badge"=> "default"

                            ]]
                    );
                }
            } else {
                flash()->overlay('Gagal menambahkan deposit. Tiket sudah dikonfirmasi', 'INFO');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::info('failed confirm deposit, error : ' . $e);
            flash()->overlay('Gagal menambahkan deposit.', 'INFO');
            return redirect()->back();
        }
        DB::commit();
        return redirect()->back();
    }
    public function depositHistory(Request $request)
    {
        $from = date('Y-m-d', time());
        $until = $from;
        $histories = array();
        if ($request->has('from') && $request->has('until')) {
            $user = User::where('username', $request->username)->first();
            if (!$user) {
                flash()->overlay('Username tidak ditemukan.', 'INFO');
                return redirect()->back();
            }
            $from = date('Y-m-d', strtotime($request->from));
            $until = date('Y-m-d', strtotime($request->until));
            if (daysDifference($until, $from) < 31) {
                $histories = HistoryDeposit::where('user_id', $user->id)
                    ->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('id');
                //	return $transactions;
                $request->flash();
            } else {
                flash()->overlay('History deposit yang bisa Anda cek maksimal 31 hari.', 'INFO');
                return redirect()->back();
            }
        }
        $from = date('d-m-Y', strtotime($from));
        $until = date('d-m-Y', strtotime($until));
        JavaScript::put([
            'request' => [
                'from' => $from,
                'until' => $until,
            ],
        ]);
        return view('admin.deposits.history-deposit', compact('histories'));
    }
    public function depositTotal()
    {
        $users['basic'] = User::where('type_user_id', 2);
        $users['advance'] = User::where('type_user_id', 3);
        $users['pro'] = User::where('type_user_id', 4);
        $users['free'] = User::where('type_user_id', 5);
        $total['basic'] = $users['basic']->count();
        $total['advance'] = $users['advance']->count();
        $total['pro'] = $users['pro']->count();
        $total['free'] = $users['free']->count();
        $total['ALL'] = $total['basic'] + $total['advance'] + $total['pro'] + $total['free'];
        $total_deposit['basic'] = $users['basic']->sum('deposit');
        $total_deposit['advance'] = $users['advance']->sum('deposit');
        $total_deposit['pro'] = $users['pro']->sum('deposit');
        $total_deposit['free'] = $users['free']->sum('deposit');
        $total_deposit['ALL'] = $total_deposit['basic'] + $total_deposit['advance'] + $total_deposit['pro'] + $total_deposit['free'];

        return view('admin.deposits.history-total', compact('total', 'total_deposit'));
    }
    public function cancelTicket(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:ticket_deposits,id',
        ]);
        $ticket = TicketDeposit::find($request->id);
        $ticket->status = 'rejected';
        $ticket->updated_by = auth()->user()->id;
        $ticket->save();
        $message = "<strong>Reject ticket deposit berhasil.</strong></p>";
        flash()->overlay($message, 'INFO');
        return redirect()->back();
    }
}
