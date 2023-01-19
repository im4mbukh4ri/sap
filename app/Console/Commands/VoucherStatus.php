<?php

namespace App\Console\Commands;

use App\Helpers\Deposit\Deposit;
use App\Helpers\SipPpob;
use App\LogCron;
use App\PpobSerialNumber;
use App\PpobTransaction;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class VoucherStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:voucher_status';

    /**
     * The console command description.
     *
     * @var string
     */
    /**
     * Params for send check status
     * @string rqid
     * @string mmid
     * @string app
     * @string action
     */
    private $rqid;
    private $mmid;
    private $action;
    private $app;

    protected $description = 'Check status voucher game';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->rqid = config('sip-config')['rqid'];
        $this->mmid = config('sip-config')['mmid'];
        $this->action = 'get_status';
        $this->app = 'information';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //{"rqid":"Sm4ajndIdanf2k274hKSNjshfjhqkej1nRT","app":"information","action":"get_status","mmid":"mastersip","notrx":"PUL-170218650803"}
        $messages = array();
        $pulsaTransactions = PpobTransaction::where('service', '=', 18)
            ->where('status', '=', 'PENDING')->where('on_check', '=', 0)
            ->take(100)->get();
        // $pulsaTransactions = PpobTransaction::where('service', 1)->where('status', 'PENDING')->get();
        foreach ($pulsaTransactions as $pulsa) {
            $pulsa->on_check = 1;
            $pulsa->save();
        }
        foreach ($pulsaTransactions as $pulsa) {
            sleep(1);
            $notrx = $pulsa->transaction_number->transaction_number;
            $param = [
                'rqid' => $this->rqid,
                'mmid' => $this->mmid,
                'app' => $this->app,
                'action' => $this->action,
                'notrx' => $notrx,
                'nohp' =>$pulsa->number,
                'paxpaid' =>$pulsa->nta,
                'nta'=>$pulsa->nta,
                'product_code'=>$pulsa->ppob_service->code,
                'tglin'=>date("Y-m-d H:i:s", strtotime($pulsa->created_at))
            ];
            $attributes = json_encode($param);
            $status = SipPpob::checkStatus($attributes)->get();
            if ($status['error_code'] == '000') {
                if ($status['status'] == 'FAILED') {
                    DB::beginTransaction();
                    try {
                        $credit = Deposit::credit($pulsa->user_id, $pulsa->paxpaid - $pulsa->transaction_commission->member , 'ppob|' . $pulsa->id_transaction . '|Refund ' . $pulsa->ppob_service->name . " - " .
                            $pulsa->number . "")->get();
                        if ($credit['status']['code'] == 200) {
                            $pulsa->status = 'FAILED';
                            $pulsa->save();
                            $messages[] = 'Success refund ' . $pulsa->ppob_service->name . " - " . $pulsa->number;
                        } else {
                            $messages[] = 'Failed refund ' . $pulsa->ppob_service->name . " - " . $pulsa->number;
                        }
                    } catch (\Exception $e) {
                        DB::rollback();
                        Log::info("GAGAL REFUND VOUCHER id : " . $pulsa->id);
                    }
                    DB::commit();
                } elseif ($status['status'] == 'SUCCESS') {
                    $pulsa->status = 'SUCCESS';
                    $pulsa->save();
                    $pulsa->serial_number()->save(new PpobSerialNumber(['serial_number' => $status['SN']]));
                    $messages[] = 'Success change status to SUCCESS ' . $pulsa->ppob_service->name . " - " . $pulsa->number;
                    if ($pulsa->transaction_commission->upline > 0) {
                        Deposit::credit($pulsa->user->parent->id, $pulsa->transaction_commission->upline, 'ppob|' . $pulsa->id_transaction . '|Kredit Smart Cash Referral (' . $pulsa->user->name . ') ' . $pulsa->ppob_service->name);
                    }
                } elseif ($status['status'] == 'REFUND') {
                    $pulsa->status = 'FAILED';
                    $pulsa->save();
                    Deposit::credit($pulsa->user_id, $pulsa->paxpaid - $pulsa->transaction_commission->member, 'ppob|' . $pulsa->id_transaction . '|Refund ' . $pulsa->ppob_service->name . " - " .
                        $pulsa->number . "");
                    $messages[] = 'Success refund ' . $pulsa->ppob_service->name . " - " . $pulsa->number;
                } else {
                    $messages[] = 'Didn\'t anything for  ' . $pulsa->ppob_service->name . " - " . $pulsa->number;
                }
            } else {
                $messages[] = 'Voucher with id = ' . $pulsa->id . 'Number : ' . $pulsa->number . ' didn\'t anything. Error : ' . $status['error_msg'];
            }
            $pulsa->on_check = 0;
            $pulsa->save();
        }
        $log = '';
        foreach ($messages as $mess) {
            $log .= $mess . '|';
        }
        LogCron::create(['log' => $log, 'service' => 'voucher']);
        return $messages;
    }
}
