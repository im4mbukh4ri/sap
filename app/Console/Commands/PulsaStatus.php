<?php

namespace App\Console\Commands;

use App\Helpers\Deposit\Deposit;
use App\Helpers\SipPpob;
use App\LogCron;
use App\PpobSerialNumber;
use App\PpobTransaction;
use DB;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\HistoryDeposit;

class PulsaStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:pulsa_status';

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

    protected $description = 'Check status pulsa';

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
        $pulsaTransactions = PpobTransaction::where('service', '=', 1)
            ->where('status', '=', 'PENDING')->where('on_check', '=', 0)
            ->take(40)->get();
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
                $markup = 0;
                if ($pulsa->user->role == "free") {
                    $product = \App\PpobService::find($pulsa->ppob_service_id);
                    $markup = $product->pulsa_markup->first()->markup;
                }
                if ($status['status'] == 'FAILED') {

                    $note = 'ppob|' . $pulsa->id_transaction . '|Refund ' . $pulsa->ppob_service->name . " - " .
                        $pulsa->number;
                    $credit = $pulsa->paxpaid - $pulsa->transaction_commission->member + $markup;

                    $checkRefund = HistoryDeposit::where('user_id', '=', $pulsa->user_id)->where('credit', '=', $credit)->where('note', '=', $note)->first();

                    if ($checkRefund) {
                        $messages[] = 'Failed refund ' . $pulsa->ppob_service->name . " - " . $pulsa->number. 'Has been refunded';
                        continue;
                    }

                    DB::beginTransaction();
                    try {

                        $credit = Deposit::credit($pulsa->user_id, $credit, $note)->get();
                        if ($credit['status']['code'] == 200) {
                            $pulsa->status = 'FAILED';
                            $pulsa->save();
                            $messages[] = 'Success refund ' . $pulsa->ppob_service->name . " - " . $pulsa->number;
                        } else {
                            $messages[] = 'Failed refund ' . $pulsa->ppob_service->name . " - " . $pulsa->number;
                        }
                    } catch (\Exception $e) {
                        DB::rollback();
                        Log::info("GAGAL REFUND PULSA id : " . $pulsa->id);
                    }
                    DB::commit();
                    if($pulsa->user->phone_number) {
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
                                    "phone_number" => $pulsa->user->phone_number,
                                    "title" => 'Pulsa Transaction '.$pulsa->number. ' '.$pulsa->ppob_service->name. ' Failed',
                                    "description"  => 'Pulsa Transaction '.$pulsa->number. ' '.$pulsa->ppob_service->name. ' Failed',
                                    "url_image"=> "https://smartinpays.com/assets/images/login/services/smart-store.png",
                                    "route"=> "default",
                                    "sound"=> "default",
                                    "silent"=> false,
                                    "badge"=> "default"

                                ]]
                        );
                    }
                } elseif ($status['status'] == 'SUCCESS') {
                    $pulsa->status = 'SUCCESS';
                    $pulsa->save();
                    $pulsa->serial_number()->save(new PpobSerialNumber(['serial_number' => $status['SN']]));
                    $messages[] = 'Success change status to SUCCESS ' . $pulsa->ppob_service->name . " - " . $pulsa->number;
                    if ($pulsa->user->role == 'free') {
                        $note =  'ppob|' . $pulsa->id_transaction . '|Kredit Smart Cash Referral (' . $pulsa->user->name . ') ' . $pulsa->ppob_service->name;
                        $credit = $pulsa->transaction_commission->upline;

                        $checkRefund = HistoryDeposit::where('user_id', '=', $pulsa->user->parent->id)->where('credit', '=', $credit)->where('note', '=', $note)->first();

                        if ($checkRefund) {
                            $messages[] = 'Failed refund ' . $pulsa->ppob_service->name . " - " . $pulsa->number. 'Has been refunded';
                            continue;
                        }
                        Deposit::credit($pulsa->user->parent->id, $credit,$note);
                    }
                    if($pulsa->user->phone_number) {
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
                                    "phone_number" => $pulsa->user->phone_number,
                                    "title" => 'Pulsa Transaction '.$pulsa->number. ' '.$pulsa->ppob_service->name. ' Success',
                                    "description"  => 'Pulsa Transaction '.$pulsa->number. ' '.$pulsa->ppob_service->name. ' Success',
                                    "url_image"=> "https://smartinpays.com/assets/images/login/services/smart-store.png",
                                    "route"=> "default",
                                    "sound"=> "default",
                                    "silent"=> false,
                                    "badge"=> "default"

                                ]]
                        );
                    }
                } elseif ($status['status'] == 'REFUND') {
                    $pulsa->status = 'FAILED';
                    $pulsa->save();
                    Deposit::credit($pulsa->user_id, $pulsa->paxpaid - $pulsa->transaction_commission->member + $markup, 'ppob|' . $pulsa->id_transaction . '|Refund ' . $pulsa->ppob_service->name . " - " .
                        $pulsa->number . "");
                    $messages[] = 'Success refund ' . $pulsa->ppob_service->name . " - " . $pulsa->number;
                    if($pulsa->user->phone_number) {
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
                                    "phone_number" => $pulsa->user->phone_number,
                                    "title" => 'Pulsa Transaction '.$pulsa->number. ' '.$pulsa->ppob_service->name. ' Failed',
                                    "description"  => 'Pulsa Transaction '.$pulsa->number. ' '.$pulsa->ppob_service->name. ' Failed',
                                    "url_image"=> "https://smartinpays.com/assets/images/login/services/smart-store.png",
                                    "route"=> "default",
                                    "sound"=> "default",
                                    "silent"=> false,
                                    "badge"=> "default"

                                ]]
                        );
                    }
                } else {
                    $messages[] = 'Didn\'t anything for  ' . $pulsa->ppob_service->name . " - " . $pulsa->number;
                }
            } else {
                $messages[] = 'Pulsa with id = ' . $pulsa->id . 'Number : ' . $pulsa->number . ' didn\'t anything. Error : ' . $status['error_msg'];
            }
            $pulsa->on_check = 0;
            $pulsa->save();
        }
        $log = '';
        foreach ($messages as $mess) {
            $log .= $mess . '|';
        }
        LogCron::create(['log' => $log, 'service' => 'pulsa']);
        return $messages;
    }
}
