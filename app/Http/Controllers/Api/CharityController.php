<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use \App\Charity;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Helpers\Deposit\Deposit;
use DB;



use App\Http\Requests;
use App\Http\Controllers\Controller;

class CharityController extends Controller
{
    private $confirmSuccess = 'success';
    private $confirmFailed = 'failed';
    private $codeSuccess = 200;
    private $codeFailed = 400;
    private $statusMessage;

    public function index() {
        $charities = Charity::where('status', '=', 1)->get(['id','title','content','url_image']);
        return $charities;
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'charity_id' => 'required|exists:charities,id',
            'nominal' => 'required|numeric|min:10000',
            'username' => 'required|exists:users,username'
        ]);
        if ($validator->fails()) {
            $this->setStatusMessage($validator->errors()->first());
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ], 400);
        }
        $user = User::where('username', '=', $request->username)->first();
        $charity = Charity::find($request->charity_id);
        $nominal = (int) $request->nominal;
        $minCharity = 5000;
        if ((int) $nominal % $minCharity != 0) {
            $this->setStatusMessage('Minimal transfer charity adalah IDR 10.000 dan kelipatan IDR ' . number_format($minCharity));
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ], 400);
        }
        DB::beginTransaction();
        try {
            $transaction = \App\CharityTransaction::create([
                'charity_id' => $request->charity_id,
                'user_id' => $user->id,
                'nominal' => $nominal,
            ]);
            $credit = Deposit::credit(1, $nominal, 'charity|' . $transaction->id . '|Transfer dari sistem jaringan username  : ' . $user->username . ' charity program : '
                . $charity->title . ' IDR ' . number_format($nominal))->get();
            if ($credit['status']['code'] != 200) {
                $transaction->status = 'FAILED';
                $transaction->save();
                \App\UserLog::create([
                    'user_id' => $user->id,
                    'log' => 'Failed credit transfer charity from network system to mastersip, Charity :' .
                        $charity->title . '. Nominal . ' . $nominal
                ]);
                DB::rollback();
                $this->setStatusMessage('Gagal transfer charity. Silahkan ulangi kembali.');
                return Response::json([
                    'status' => [
                        'code' => $this->getCodeFailed(),
                        'confirm' => $this->getConfirmFailed(),
                        'message' => $this->getStatusMessage(),
                    ],
                ], 400);
            }
            $transaction->status = 'SUCCESS';
            $transaction->save();
        } catch (\Exception $e) {
            DB::rollback();
            \App\UserLog::create([
                'user_id' => $user->id,
                'log' => 'Failed do transfer charity from network system , Charity :' .
                    $charity->title . '. Nominal . ' . $nominal.'. Error : '.$e->getMessage()
            ]);
            DB::commit();
            $this->setStatusMessage('Gagal transfer charity.'. $e->getMessage());
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ], 400);
        }
        \App\UserLog::create([
            'user_id' => $user->id,
            'log' => 'Success transfer charity from network system, Charity :' .
                $charity->title . '. Nominal . ' . $nominal
        ]);
        DB::commit();
        $this->setStatusMessage('Transfer berhasil. Terimakasih telah mengikuti program charity kami.');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
        ], 200);
    }
    private function getCodeSuccess() {
        return $this->codeSuccess;
    }
    private function getCodeFailed() {
        return $this->codeFailed;
    }
    private function getConfirmSuccess() {
        return $this->confirmSuccess;
    }
    private function getConfirmFailed() {
        return $this->confirmFailed;
    }
    private function setStatusMessage($message) {
        (is_array($message) ? $this->statusMessage = $message : $this->statusMessage = array($message));
    }
    private function getStatusMessage() {
        return $this->statusMessage;
    }
}
