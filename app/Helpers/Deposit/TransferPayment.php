<?php

namespace App\Helpers\Deposit;

use GuzzleHttp\Client;
use Log;
use DB;

class TransferPayment extends DepositService {

  private $otp;
  private $requestTransfer;
  private $receiver;
  private $sender;

  public function __construct($userId,$otp)
  {
      parent::__construct($userId);
      $this->otp=$otp;
      $this->doTransfer();

  }
  public function doTransfer(){
    $now = time();
    $date = date('Y-m-d',$now);
    $this->requestTransfer = \App\RequestTransferDeposit::where('otp',$this->otp)->where('from_user',$this->user->id)->where('created_at','LIKE',$date.'%')->first();
    $expired = strtotime($this->requestTransfer->expired);
    if($now-$expired > 300){
      $this->requestTransfer->status=2;
      $this->requestTransfer->save();
      return $this->response= [
        'status'=>[
          'code'=>400,
          'confirm'=>'failed',
          'message'=>'OTP Anda sudah kadaluarsa.'
        ]
      ];
    }
    if($this->requestTransfer->status==1){
      return $this->response= [
        'status'=>[
          'code'=>400,
          'confirm'=>'failed',
          'message'=>'Maaf transaksi Anda sudah berhasil sebelumnya.'
        ]
      ];
    }elseif($this->requestTransfer->status==2||$this->requestTransfer->status==3){
      return $this->response= [
        'status'=>[
          'code'=>400,
          'confirm'=>'failed',
          'message'=>'OTP Anda sudah kadaluarsa!'
        ]
      ];
    }
    $this->totalPrice=$this->requestTransfer->nominal+$this->requestTransfer->admin+$this->requestTransfer->penalty;
    $this->check();
    if($this->get()){
      $this->receiver=\App\User::find($this->requestTransfer->to_user);
      $this->sender = \App\User::find($this->requestTransfer->from_user);
      DB::beginTransaction();
        try{
            $debit = \App\Deposit::create([
                'user_id'=>$this->requestTransfer->from_user,
                'user_deposit'=> $this->balance(),
                'debit'=>$this->requestTransfer->nominal,
                'credit'=>0,
                'note'=>'Payment  to merchant '.$this->receiver->username.' IDR '.number_format($this->requestTransfer->nominal),
                'created_by'=>$this->requestTransfer->from_user
            ]);
            $this->totalPrice=$this->requestTransfer->nominal;
            $this->debitDeposit('debit|'.$debit->id.'|Payment  to merchant  '.$this->receiver->username.' IDR '.number_format($this->requestTransfer->nominal));
            // $this->totalPrice=$this->requestTransfer->admin;

            // if($this->requestTransfer->penalty>0){
            //   $this->totalPrice=$this->requestTransfer->penalty;
            //   $this->debitDeposit('debit|'.$debit->id.'|Biaya penalty Transfer deposit ke member '.$this->receiver->username.' IDR '.number_format($this->requestTransfer->penalty));
            // }
            $credit = \App\Deposit::create([
                'user_id'=>$this->receiver->id,
                'user_deposit'=>$this->receiver->deposit,
                'debit'=>0,
                'credit'=>$this->requestTransfer->nominal,
                'note'=>'Payment from '.$this->user->username.' IDR '.number_format($this->requestTransfer->nominal),
                'created_by'=>$this->requestTransfer->from_user
            ]);
            $this->user=\App\User::find($this->requestTransfer->to_user);
            $this->totalPrice=$this->requestTransfer->nominal;
            $this->creditDeposit('credit|'.$credit->id.'|Payment from '.$this->sender->username.' IDR '.number_format($this->requestTransfer->nominal));
            $this->requestTransfer->confirmed=1;
            $this->requestTransfer->status=1;
            $this->requestTransfer->save();
        }catch (\Exception $e){
            DB::rollback();
            Log::info('failed process transfer deposit, error : '.$e->getMessage());
            return $this->response = [
              'status'=>[
                'code'=>400,
                'confirm'=>'failed',
                'message'=>'Proses transfer deposit gagal. Silahkan ulangi kembali.'
              ]
            ];
        }
        DB::commit();
        if($this->sender->phone_number) {
            if($this->sender->name != '') {
                $title = 'Payment Success to merchant '.$this->receiver->name.' IDR '.number_format($this->requestTransfer->nominal);
            } else {
                $title = 'Payment Success to merchant '.$this->receiver->phone_number.' IDR '.number_format($this->requestTransfer->nominal);
            }
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
                        "phone_number" => $this->sender->phone_number,
                        "title" => $title,
                        "description"  => $title,
                        "url_image"=> "https://smartinpays.com/assets/images/login/services/smart-store.png",
                        "route"=> "default",
                        "sound"=> "default",
                        "silent"=> false,
                        "badge"=> "default"

                    ]]
            );
        }
        if($this->receiver->phone_number) {
            if ($this->sender->name != '') {
                $title = 'Payment Success from '.$this->sender->name.' IDR '.number_format($this->requestTransfer->nominal);
            } else {
                $title = 'Payment Success from '.$this->sender->phone_number.' IDR '.number_format($this->requestTransfer->nominal);
            }
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
                        "phone_number" => $this->receiver->phone_number,
                        "title" => $title,
                        "description"  => $title,
                        "url_image"=> "https://smartinpays.com/assets/images/login/services/smart-store.png",
                        "route"=> "default",
                        "sound"=> "default",
                        "silent"=> false,
                        "badge"=> "default"

                    ]]
            );
        }
        // $checkRequest=\App\RequestTransferDeposit::where('from_user',$this->sender->id)
        //   ->where('confirmed','=',0)->get();
        //   Log::info($checkRequest);
        //   Log::info("Check Request : ");
        //   if($checkRequest){
        //     Log::info('Masuk ke count > 0');
        //     foreach ($checkRequest as $key => $value) {
        //       $value->confirmed=1;
        //       $value->save();
        //     }
        //   }
        return $this->response = [
          'status'=>[
            'code'=>200,
            'confirm'=>'success',
            'message'=>'Proses transfer deposit berhasil.'
          ]
        ];
    }
    return $this->response = [
      'status'=>[
        'code'=>400,
        'confirm'=>'failed',
        'message'=>'Saldo Anda tidak cukup untuk melakukan transfer deposit'
      ]
    ];

  }

}
