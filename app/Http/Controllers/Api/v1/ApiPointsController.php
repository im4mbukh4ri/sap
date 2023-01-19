<?php

namespace App\Http\Controllers\Api\v1;

use App\OauthAccessToken;
use App\OauthClientSecret;
use App\PointMax;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ApiPointsController extends Controller
{
    private $confirmSuccess='success';
    private $confirmFailed='failed';
    private $codeSuccess=200;
    private $codeFailed=400;
    private $statusMessage;
    public function __construct(Request $request)
    {
        $this->middleware('oauth');
//        if($request->hasHeader('authorization')){
//            $token=explode(' ',$request->header('authorization'));
//            $newTime=time()+259200;
//            $accessToken=OauthAccessToken::find($token[1]);
//            $accessToken->expire_time=$newTime;
//            $accessToken->save();
//        }
//        if($request->has('access_token')){
//            $newTime=time()+259200;
//            $accessToken=OauthAccessToken::find($request->access_token);
//            $accessToken->expire_time=$newTime;
//            $accessToken->save();
//        }
    }
    public function balance(Request $request){
        $client = OauthClientSecret::where('client_id',$request->client_id)->first();
        if (!$client){
            $this->setStatusMessage(['Anda tidak terdaftar','clinet_id tidak ditemukan']);
            return Response::json([
                'status'=>[
                    'code'=>$this->getCodeFailed(),
                    'confirm'=>$this->getConfirmFailed(),
                    'message'=>$this->getStatusMessage()
                ],
            ]);
        }
        $point=$client->user->point;
        $maxPoint=PointMax::find(1)->point;
        $this->setStatusMessage('Berhasil cek point');
        return Response::json([
            'status'=>[
                'code'=>$this->getCodeSuccess(),
                'confirm'=>$this->getConfirmSuccess(),
                'message'=>$this->getStatusMessage()
            ],
            'details'=>[
                'user_point'=>$point,
                'max_point'=>$maxPoint
            ]
        ]);
    }
    public function pointMax(){
        $maxPoint=PointMax::find(1)->point;
        $this->setStatusMessage('Berhasil cek maksimal point yang bisa di gunakan.');
        return Response::json([
            'status'=>[
                'code'=>$this->getCodeSuccess(),
                'confirm'=>$this->getConfirmSuccess(),
                'message'=>$this->getStatusMessage()
            ],
            'details'=>[
                'max_point'=>$maxPoint
            ]
        ]);
    }
    public function pointHistories(Request $request){
        $client = OauthClientSecret::where('client_id',$request->client_id)->first();
        if (!$client){
            $this->setStatusMessage(['Anda tidak terdaftar','clinet_id tidak ditemukan']);
            return Response::json([
                'status'=>[
                    'code'=>$this->getCodeFailed(),
                    'confirm'=>$this->getConfirmFailed(),
                    'message'=>$this->getStatusMessage()
                ],
            ]);
        }
        $user=$client->user;
        if($request->has('start_date')&&$request->has('end_date')){
            $from=date('Y-m-d',strtotime($request->start_date));
            $until=date('Y-m-d',strtotime($request->end_date));
            if(daysDifference($until,$from)>31){
                $this->setStatusMessage('History point yang bisa Anda cek maksimal 31 hari.');
                return Response::json([
                    'status'=>[
                        'code'=>$this->getCodeFailed(),
                        'confirm'=>$this->getConfirmFailed(),
                        'message'=>$this->getStatusMessage()
                    ]
                ]);

            }
            $this->setStatusMessage('Berhasil cek history point.');
            $histories = $user->history_points()
                ->whereBetween('created_at',[$from.' 00:00:00',$until.' 23:59:59'])->get();
            //	return $transactions;
        }else{
            $this->setStatusMessage('periksa tanggal awal dan tanggal akhir (start_date & end_date');
            return Response::json([
                'status'=>[
                    'code'=>$this->getCodeFailed(),
                    'confirm'=>$this->getConfirmFailed(),
                    'message'=>$this->getStatusMessage()
                ]
            ]);
        }
        return Response::json([
            'status'=>[
                'code'=>$this->getCodeSuccess(),
                'confirm'=>$this->getConfirmSuccess(),
                'message'=>$this->getStatusMessage()
            ],
            'details'=>[
                'point_histories'=>$histories
            ]
        ]);
    }
    private function getCodeSuccess(){
        return $this->codeSuccess;
    }
    private function getCodeFailed(){
        return $this->codeFailed;
    }
    private function getConfirmSuccess(){
        return $this->confirmSuccess;
    }
    private function getConfirmFailed(){
        return $this->confirmFailed;
    }
    private function setStatusMessage($message){
        (is_array($message)?$this->statusMessage=$message:$this->statusMessage=array($message));
    }
    private function getStatusMessage(){
        return $this->statusMessage;
    }
}
