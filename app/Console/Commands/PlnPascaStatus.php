<?php

namespace App\Console\Commands;

use App\Helpers\Deposit\Deposit;
use App\Helpers\SipPpob;
use App\HistoryDeposit;
use App\LogCron;
use App\PpobPlnPasca;
use App\PpobTransaction;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PlnPascaStatus extends Command
{
    protected $signature = 'cron:pln_pasca_status';
    private $rqid;
    private $mmid;
    private $action;
    private $app;

    public function __construct()
    {
        parent::__construct();
        $this->rqid = config('sip-config')['rqid'];
        $this->mmid = config('sip-config')['mmid'];
        $this->action = 'get_status';
        $this->app = 'information';
    }

    public function handle()
    {
        $messages = array();
        $plnPascaTransactions = PpobTransaction::where('service', '=', 3)
            ->where('status', '=', 'PENDING')->where('on_check', '=', 0)
            ->take(60)->get();
        foreach ($plnPascaTransactions as $pln) {
            $pln->on_check = 1;
            $pln->save();
        }
        foreach ($plnPascaTransactions as $pln) {
            sleep(1);
            $notrx = $pln->transaction_number->transaction_number;
            $param = [
                'rqid' => $this->rqid,
                'mmid' => $this->mmid,
                'app' => $this->app,
                'action' => $this->action,
                'notrx' => $notrx,
            ];
            $attributes = json_encode($param);
            $status = SipPpob::checkStatus($attributes)->get();
            if ($status['error_code'] == '000') {
                if ($status['status'] == 'FAILED') {

                    DB::beginTransaction();
                    try {
                        $note = 'ppob|' . $pln->id_transaction . '|Refund ' . $pln->ppob_service->name . " - " .
                            $pln->number;
                        $credit = $pln->paxpaid - $pln->transaction_commission->member;

                        $checkRefund = HistoryDeposit::where('user_id', '=', $pln->user_id)->where('credit', '=', $credit)->where('note', '=', $note)->first();

                        if ($checkRefund) {
                            $messages[] = 'Failed refund ' . $pln->ppob_service->name . " - " . $pln->number . 'Has been refunded';
                            continue;
                        }
                        $credit = Deposit::credit($pln->user_id, $credit, $note)->get();
                        if ($credit['status']['code'] == 200) {
                            $pln->status = 'FAILED';
                            $pln->save();
                            $pln->pln_pasca->delete();
                            $messages[] = 'Success refund ' . $pln->ppob_service->name . " - " . $pln->number;
                        } else {
                            $messages[] = 'Failed refund ' . $pln->ppob_service->name . " - " . $pln->number;
                        }
                    } catch (\Exception $e) {
                        DB::rollback();
                        Log::info("GAGAL REFUND PULSA id : " . $pln->id);
                    }
                    DB::commit();
                } elseif ($status['status'] == 'SUCCESS') {
                    DB::beginTransaction();
                    try {
                        $pln->status = 'SUCCESS';
                        $pln->save();
                        if ($pln->pln_pasca) {
                            $pln->pln_pasca->customer_name = $status['nama'];
                            $pln->pln_pasca->golongan_daya = $status['kategori'] . '/' . $status['daya'];
                            $pln->pln_pasca->stand_meter = $status['stand_meter'];
                            $pln->pln_pasca->save();
                        } else {
                            $pln->pln_pasca()->save(new PpobPlnPasca([
                                'customer_name' => $status['nama'],
                                'golongan_daya' => $status['kategori'] . '/' . $status['daya'],
                                'nominal' => $status['paxpaid'] - 1600,
                                'admin' => 1600,
                                'stand_meter' => $status['stand_meter'],
                                'period' => $status['periode']
                            ]));
                        }

                    } catch (\Exception $e) {
                        DB::rollback();
                        Log::info("GAGAL change PLN PRA id : " . $pln->id);
                    }
                    DB::commit();
                } elseif ($status['status'] == 'REFUND') {
                    DB::beginTransaction();
                    try {
                        $pln->status = 'FAILED';
                        $pln->save();
                        Deposit::credit($pln->user_id, $pln->paxpaid - $pln->transaction_commission->member, 'ppob|' . $pln->id_transaction . '|Refund ' . $pln->ppob_service->name . " - " .
                            $pln->number . "");
                    } catch (\Exception $e) {
                        DB::rollback();
                        Log::info("GAGAL change PLN PRA id : " . $pln->id);
                    }
                    $messages[] = 'Success refund ' . $pln->ppob_service->name . " - " . $pln->number;
                } else {
                    $messages[] = 'Didn\'t anything for  ' . $pln->ppob_service->name . " - " . $pln->number;
                }
            } else {
                $messages[] = 'PLN Pra with id = ' . $pln->id . 'Number : ' . $pln->number . ' didn\'t anything. Error : ' . $status['error_msg'];
            }
            $pln->on_check = 0;
            $pln->save();
        }
        $log = '';
        foreach ($messages as $mess) {
            $log .= $mess . '|';
        }
        LogCron::create(['log' => $log, 'service' => 'pasca']);
        return $messages;
    }
}
