<?php

namespace App\Helpers\Deposit;

use App\Helpers\SipSms;
use App\User;
use DB;
use Log;

class RequestPayment
{

    private $user;
    private $admin;
    private $nominal;
    private $toUser;
    private $note;
    private $ip;
    private $device;
    public $response;

    public function __construct($request)
    {
        // parent::__construct($request['fromUser']);
        $this->user = User::find($request['fromUser']);
        $this->admin = 0;
        $this->nominal = $request['nominal'];
        $this->toUser = $request['toUser'];
        $this->note = $request['note'];
        $this->ip = $request['ip'];
        $this->device = $request['device'];
        $this->requestTransfer();
    }

    public function get()
    {
        return $this->response;
    }

    public function requestTransfer()
    {

        $checkRequest = \App\RequestTransferDeposit::where('from_user', $this->user->id)
            ->where('status', 0)->get();
        // $message = 'Silahkan cek inbox SMS Anda untuk mengetahui kode OTP.';
        $message = 'Silahkan masukan kode berikut untuk melanjutkan proses payment : ';
        if ($checkRequest) {
            foreach ($checkRequest as $value) {
                $expired = time() - strtotime($value->expired);
                if ($expired <= 0 && $value->to_user == $this->toUser) {
                    return $this->response = [
                        'status' => [
                            'code' => 400,
                            'confirm' => 'failed',
                            'message' => 'Proses gagal. Anda baru saja melakukan request payment sebelumnya ke member yang sama. Silahkan ulangi kembali setelah 5 menit.',
                        ],
                    ];
                }
                $value->status = 3;
                $value->save();
            }
        }
        $this->totalPrice = $this->nominal + $this->admin;
        if (Deposit::check($this->user->id, $this->totalPrice)->get()) {
            DB::beginTransaction();
            try {
                $id = $this->getTransactionId();
                $limit = date("Y-m-d H:i:s", time() + 300);
                $newRequest = new \App\RequestTransferDeposit();
                $newRequest->otp = $id;
                $newRequest->from_user = $this->user->id;
                $newRequest->to_user = $this->toUser;
                $newRequest->nominal = $this->nominal;
                $newRequest->admin = $this->admin;
                $newRequest->expired = $limit;
                $newRequest->ip = $this->ip;
                $newRequest->device = $this->device;
                if (trim($this->note) != '') {
                    $newRequest->note = $this->note;
                }
                $newRequest->save();
                $message .= ' ' . $newRequest->otp;
                // $this->totalPrice = $this->admin;
                // $idRtd = substr("" . time(), -4) . strrev($id) . rand(10, 99);
                // $debit = Deposit::debit($this->user->id, $this->admin, 'rtd|' . $idRtd . '|Biaya Admin Transfer Deposit IDR ' . number_format($this->admin))->get();
                // if ($debit['status']['code'] != 200) {
                // 	Log::info("GAGAL REQUEST DEPOSIT . error: failed debit user_id = " . $this->user->id);
                // 	DB::rollback();
                // 	return $this->response = [
                // 		'status' => [
                // 			'code' => 400,
                // 			'confirm' => 'failed',
                // 			'message' => 'Proses gagal. Silahkan ulangi kembali. ',
                // 		],
                // 	];
                // }
                // $this->debitDeposit('rtd|' . $idRtd . '|Biaya SMS OTP IDR ' . number_format($this->admin));
            } catch (\Exception $e) {
                Log::info("GAGAL REQUEST DEPOSIT . error: " . $e->getMessage());
                DB::rollback();
                return $this->response = [
                    'status' => [
                        'code' => 400,
                        'confirm' => 'failed',
                        'message' => 'Proses gagal. Silahkan ulangi kembali. ',
                    ],
                ];
            }
            DB::commit();
            // Close OTP
            // $toUser = \App\User::find($this->toUser);
            // $param = [
            // 	'rqid' => 'Sm4ajndIdanf2k274hKSNjshfjhqkej1nRT',
            // 	'mmid' => 'mastersip',
            // 	'app' => 'transaction',
            // 	'action' => 'send_sms',
            // 	'nohp' => trim($this->user->address->phone),
            // 	'pesan' => 'OTP transfer deposit ke ' . $toUser->username . ': ' . $id . ' . Berlaku sampai ' . date('Y-m-d H:i', strtotime($limit)) . ' WIB',
            // ];
            // $param = json_encode($param);
            // $sms = SipSms::send($param)->get();
            //$sms['error_code'] = '001';
            // if ($sms['error_code'] == '000') {
            return $this->response = [
                'status' => [
                    'code' => 200,
                    'confirm' => 'success',
                    'message' => $message,
                ],
                'data' => $newRequest
            ];
            // } else {
            // 	Log::info('Failed send SMS to : ' . $this->user->address->phone);
            // 	$credit = Deposit::credit($this->user->id, $this->admin, 'rtd|' . $idRtd . '|Refund Biaya SMS OTP IDR ' . number_format($this->admin))->get();
            // 	// $this->creditDeposit('rtd|' . $idRtd . '|Refund Biaya SMS OTP IDR ' . number_format($this->admin));
            // 	$newRequest->status = 4;
            // 	$newRequest->save();
            // 	return $this->response = [
            // 		'status' => [
            // 			'code' => 400,
            // 			'confirm' => 'failed',
            // 			'message' => 'Proses gagal.',
            // 		],
            // 	];
            // }
        }
        return $this->response = [
            'status' => [
                'code' => 400,
                'confirm' => 'failed',
                'message' => 'Saldo Anda tidak cukup untuk melakukan payment',
            ],
        ];
    }

    private function getTransactionId()
    {
        $i = 1;
        $transactionId = null;
        $date = date('Y-m-d', time());
        while (true) {
            $transactionId = $i . substr("" . time(), -3);
            if (\App\RequestTransferDeposit::where('otp', $transactionId)->where('created_at', 'LIKE', $date . '%')->first() === null) {
                break;
            }
            $i++;
        }
        return $transactionId;
    }

}
