<?php

namespace App\Console\Commands;

use App\Helpers\Deposit\Deposit;
use App\Helpers\SipPpob;
use App\HistoryDeposit;
use App\LogCron;
use App\PpobPlnPra;
use App\PpobTransaction;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PlnPraStatus extends Command
{
    protected $signature = 'cron:pln_pra_status';
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
        $plnPraTransactions = PpobTransaction::where('service', '=', 2)
            ->where('status', '=', 'PENDING')->where('on_check', '=', 0)
            ->take(30)->get();
        foreach ($plnPraTransactions as $pln) {
            $pln->on_check = 1;
            $pln->save();
        }
        foreach ($plnPraTransactions as $pln) {
            sleep(2);
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
                            if ($pln->pln_pra) {
                                $pln->pln_pra->delete();
                            }
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
                        if ($pln->pln_pra) {
                            $pln->pln_pra->customer_name = $status['nama'];
                            $pln->pln_pra->kwh = $status['kwh'];
                            $pln->pln_pra->golongan_daya = $status['kategori'] . '/' . $status['daya'];
                            $pln->pln_pra->token = $status['token'];
                            $pln->pln_pra->reff = $status['reff'];
                            $pln->pln_pra->save();
                        } else {
                            $pln->pln_pra()->save(new PpobPlnPra([
                                'customer_name' => $status['nama'],
                                'kwh' => $status['kwh'],
                                'golongan_daya' => $status['kategori'] . '/' . $status['daya'],
                                'nominal' => str_replace('.', '', explode(" ", $status['voucher'])[2]),
                                'rp_token' => 0,
                                'admin' => 1600,
                                'ppn' => 0,
                                'ppj' => 0,
                                'materai' => 0,
                                'token' => $status['token'],
                                'reff' => $status['reff'],
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
                        $note = 'ppob|' . $pln->id_transaction . '|Refund ' . $pln->ppob_service->name . " - " .
                            $pln->number;
                        $credit = $pln->paxpaid - $pln->transaction_commission->member;

                        $checkRefund = HistoryDeposit::where('user_id', '=', $pln->user_id)->where('credit', '=', $credit)->where('note', '=', $note)->first();

                        if ($checkRefund) {
                            $messages[] = 'Failed refund ' . $pln->ppob_service->name . " - " . $pln->number . 'Has been refunded';
                            continue;
                        }
                        Deposit::credit($pln->user_id, $credit, $note);
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
        LogCron::create(['log' => $log, 'service' => 'pra']);
        return $messages;
    }
}