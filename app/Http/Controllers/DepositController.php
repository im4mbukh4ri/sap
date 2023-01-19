<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\HistoryDeposit;
use App\PointValue;
use App\SipBank;
use App\TicketDeposit;
use App\UniqueCodeTicketDeposit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JavaScript;

class DepositController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware(['auth', 'csrf', 'active:1', 'suspend:0']);
    }
    public function ticket(Request $request)
    {
        return view('deposits.tickets.index');
    }
    public function createTicket(Request $request)
    {
        $this->validate($request, [
            'sip_bank_id' => 'required|exists:sip_banks,id',
            'nominal' => 'required',
        ]);
        $bank = SipBank::find($request->sip_bank_id);
        if ($bank->status == 0) {
            $message = '<strong>Tiket deposit gagal</strong>,<br><p>Bank yang Anda pilihsedang kami tutup sementara waktu. Silahkan pilih bank lain. Terimakasih.</p>';
            flash()->overlay($message, 'INFO');
            return redirect()->back();
        }
        $reqDeposit = str_replace(',', '', $request->nominal);
        if ($request->user()->role != 'pro') {
            $limit = PointValue::find($request->user()->type_user_id)->idr;
            $date = date("Y-m-d");
            $starDate = date('Y-m-01', strtotime($date));
            $endDate = date('Y-m-t', strtotime($date));
            $deposit = TicketDeposit::where('user_id', $request->user()->id)
                ->whereBetween('created_at', [$starDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'accepted')->sum('nominal');
            if ((int) ($deposit + $reqDeposit) > $limit) {
                $sisa = $limit - $deposit;
                if ($sisa < 0) {
                    $message = '<strong>Tiket deposit gagal</strong>,<br><p>Limit deposit melebihi batas maksimum bulanan. Tiket deposit Anda bulan ini sudah IDR ' . number_format($deposit) . '</p>';
                } else {
                    $message = '<strong>Tiket deposit gagal</strong>,<br><p>Limit deposit melebihi batas maksimum bulanan, Sisa limit IDR ' . number_format($sisa) . '</p>';
                }
                flash()->overlay($message, 'INFO');
                return redirect()->back();
            }
        }

        if ((int) $reqDeposit % 50000 != 0) {
            $message = '<strong>Tiket deposit gagal</strong>,<br><p>Tiket deposit harus kelipatan Rp50.000.</p>';
            flash()->overlay($message, 'INFO');
            return redirect()->back();
        }
        $message = null;
        $user = $request->user();
        $today = date("Y-m-d", time());
        $todayTicket = $user->ticket_deposits()->where('status', 'waiting-transfer')
            ->whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])->get();
        if (count($todayTicket) >= 1) {
            $message = "<strong>Tiket deposit gagal</strong>,<br><p>Anda telah melakukan tiket deposit 1X hari ini. Untuk melakukan tiket deposit lagi. Silahkan lakukan transfer untuk tiket sebelumnya.</p>";
            flash()->overlay($message, 'INFO');
            return redirect()->back();
        }
        // $nominal = $this->generateNominal($reqDeposit, $today);
        $unique_code = $this->generateNominal();
        $nominal = $reqDeposit + $unique_code;
        try {
            $user->ticket_deposits()->create([
                'nominal_request' => $reqDeposit,
                'unique_code' => $unique_code,
                'nominal' => $nominal,
                'sip_bank_id' => $request->sip_bank_id,
                'note' => $request->note,
            ]);
        } catch (Exception $e) {
            $message = "<strong>Tiket deposit gagal</strong>,<br><p>Terjadi kesalahan.</p>";
            // Log::info('Ticket deposit failed. Error : '.$e);
            flash()->overlay($message, 'INFO');
            return redirect()->back();
        }
        $message = $this->successMessage($request->user(), $request->sip_bank_id, $reqDeposit, $unique_code, $nominal);
        flash()->overlay($message, 'INFO');
        return redirect()->back();
    }
    public function cancelTicket(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:ticket_deposits,id',
        ]);
        $ticket = TicketDeposit::find($request->id);
        $ticket->status = 'cancel';
        $ticket->updated_by = auth()->user()->id;
        $ticket->save();
        $message = "<strong>Cancel ticket deposit berhasil.</strong></p>";
        flash()->overlay($message, 'INFO');
        return redirect()->back();
    }
    public function ticketHistory(Request $request)
    {
        $from = date('Y-m-d', time());
        $until = $from;
        if ($request->has('from') && $request->has('until')) {
            $from = date('Y-m-d', strtotime($request->from));
            $until = date('Y-m-d', strtotime($request->until));
            if (daysDifference($until, $from) < 31) {
                $histories = TicketDeposit::where('user_id', $request->user()->id)
                    ->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('id');
                $request->flash();
            } else {
                flash()->overlay('History ticket yang bisa Anda cek maksimal 31 hari.', 'INFO');
                return redirect()->back();
            }
        } else {
            $histories = TicketDeposit::where('user_id', $request->user()->id)
                ->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('id');
        }
        $from = date('d-m-Y', strtotime($from));
        $until = date('d-m-Y', strtotime($until));
        JavaScript::put([
            'request' => [
                'from' => $from,
                'until' => $until,
            ],
        ]);
        return view('deposits.tickets.history', compact('histories'));
    }
    public function depositHistory(Request $request)
    {
        $from = date('Y-m-d', time());
        $until = $from;
        if ($request->has('from') && $request->has('until')) {
            $from = date('Y-m-d', strtotime($request->from));
            $until = date('Y-m-d', strtotime($request->until));
            if (daysDifference($until, $from) < 31) {
                $histories = HistoryDeposit::where('user_id', $request->user()->id)
                    ->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('id');
                $request->flash();
            } else {
                flash()->overlay('History deposit yang bisa Anda cek maksimal 31 hari.', 'INFO');
                return redirect()->back();
            }
        } else {
            $histories = $request->user()->history_deposits()
                ->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('id');
        }
        $from = date('d-m-Y', strtotime($from));
        $until = date('d-m-Y', strtotime($until));
        JavaScript::put([
            'request' => [
                'from' => $from,
                'until' => $until,
            ],
        ]);
        return view('deposits.histories.index', compact('histories'));
    }
    public function transferDepositPage(Request $request)
    {
        //		$message = '<p>Transfer deposit sedang dalam maintenance.</p>';
        //		flash()->overlay($message, 'INFO');
        //		return redirect()->back();
        $time = time();
        $date = date('Y-m-d', $time);
        $deposits = Deposit::where('created_at', 'LIKE', $date . '%')->where('user_id', '<>', $request->user()->id)->where('created_by', $request->user()->id)->get();
        return view('deposits.transfers.index', compact('deposits', 'date'));
    }
    public function requestTransferDeposit(Request $request)
    {
        $this->validate($request, [
            'to_user' => 'required|exists:users,id',
            'nominal' => 'required|numeric|min:1000',
//            'password' => 'required',
        ]);
//        $credentials = ['username' => $request->user()->username, 'password' => $request->password];
//        $userLogin = Auth::once($credentials);
        $userLogin = true;
        if ($userLogin) {
            $request->request->add(['ip' => $request->ip()]);
            $requestTransfer = \App\Helpers\Deposit\Deposit::RequestTransfer([
                'fromUser' => $request->user()->id,
                'toUser' => $request->to_user,
                'nominal' => (int) $request->nominal,
                'note' => trim($request->note),
                'ip' => $request->ip(),
                'device' => 'web',
            ])->get();
            return $requestTransfer;
        }
        return [
            'status' => [
                'code' => 401,
                'confirm' => 'failed',
                'message' => 'Password salah !',
            ],
        ];
    }
    public function transferDeposit(Request $request)
    {
        $this->validate($request, [
            'otp' => 'required|exists:request_transfer_deposits,otp',
        ]);
        $transferDeposit = \App\Helpers\Deposit\Deposit::Transfer($request->user()->id, $request->otp)->get();
        return $transferDeposit;
    }
    private function generateNominal()
    {
        $unique = UniqueCodeTicketDeposit::where('is_available', '=', 1)->first();
        $unique->is_available = 0;
        $unique->save();
        return $unique->id;
    }
    private function successMessage($user, $rekening, $nominal, $unique_code, $total)
    {
        $nominal = number_format($nominal);
        $total = number_format($total);
        $rekening = SipBank::find($rekening);
        $message =
            "<table class='table'>
                <tr><td>ID Member</td><td>:</td><td>$user->username</td></tr>
                <tr><td>Rekening Tujuan</td><td>:</td><td>$rekening->bank_name - $rekening->number - $rekening->owner_name</td></tr>
                <tr><td>Nominal</td><td>:</td><td>IDR $nominal</td></tr>
                <tr><td>Tiket Deposit</td><td>:</td><td>$unique_code</td></tr>
                <tr><td>Total Deposit</td><td>:</td><td>IDR $total</td></tr>
            </table><br><p style='color: red'>Tiket deposit hanya berlaku untuk 1 transaksi. Jika Anda ingin melakukan deposit
            kembali dihari yang sama maka Anda harus mengambil tiket deposit baru.</p>";
        return $message;
    }
}
