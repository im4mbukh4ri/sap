<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\OauthClientSecret;
use App\OauthAccessToken;
use App\NumberSaved;
use App\PpobService;
use Response;
use Validator;

class ApiNumberSavedsController extends Controller
{
  private $confirmSuccess='success';
  private $confirmFailed='failed';
  private $codeSuccess=200;
  private $codeFailed=400;
  private $statusMessage;
  public function __construct(Request $request)
  {
//      if($request->hasHeader('authorization')){
//          $token=explode(' ',$request->header('authorization'));
//          $newTime=time()+259200;
//          $accessToken=OauthAccessToken::find($token[1]);
//          $accessToken->expire_time=$newTime;
//          $accessToken->save();
//      }
//      if($request->has('access_token')){
//          $newTime=time()+259200;
//          $accessToken=OauthAccessToken::find($request->access_token);
//          $accessToken->expire_time=$newTime;
//          $accessToken->save();
//      }
  }
  public function store(Request $request){
    $validator=Validator::make($request->all(),[
      'service_id'=>'required|exists:ppob_services,code',
      'product_id'=>'required|exists:ppob_services,code',
      'name'=>'required',
      'number'=>'required'
    ]);
    if($validator->fails()){
        $this->setStatusMessage($validator->errors());
        return Response::json([
            'status'=>[
                'code'=>$this->getCodeFailed(),
                'confirm'=>$this->getConfirmFailed(),
                'message'=>$this->getStatusMessage()
            ]
        ]);
    }
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
    $serviceId=PpobService::where('code',$request->service_id)->first()->id;
    $productId=PpobService::where('code',$request->product_id)->first()->id;
    if(NumberSaved::where('user_id',$user->id)->where('service',$serviceId)->count()<10){
      $number = $user->number_saveds()->create([
        'id'=>$this->getNumberId(),
        'service'=>$serviceId,
        'ppob_service_id'=>$productId,
        'name'=>$request->name,
        'number'=>$request->number
      ]);
      $this->setStatusMessage("Berhasil tambah nomor.");
      return Response::json([
          'status'=>[
              'code'=>$this->getCodeSuccess(),
              'confirm'=>$this->getConfirmSuccess(),
              'message'=>$this->getStatusMessage()
          ],
          'details'=>$number
      ]);
    }
    $this->setStatusMessage("Maaf kuota penyimpanan sudah penuh.");
    return Response::json([
        'status'=>[
            'code'=>$this->getCodeFailed(),
            'confirm'=>$this->getConfirmFailed(),
            'message'=>$this->getStatusMessage()
        ],
    ]);
  }
  public function search(Request $request){
    $client=OauthClientSecret::where('client_id',$request->client_id)->first();
    if(!$client){
        $this->setStatusMessage(['Anda tidak terdaftar','clinet_id tidak ditemukan']);
        return Response::json([
            'status'=>[
                'code'=>$this->getCodeFailed(),
                'confirm'=>$this->getConfirmFailed(),
                'message'=>$this->getStatusMessage()
            ]
        ],400);
    }

    $serviceId=PpobService::where('code',$request->service_id)->first()->id;
    if(!$serviceId){
      $this->setStatusMessage("service_id not found");
      return Response::json([
          'status'=>[
              'code'=>$this->getCodeFailed(),
              'confirm'=>$this->getConfirmFailed(),
              'message'=>$this->getStatusMessage()
          ]
      ],400);
    }
    $numberSaveds=NumberSaved::where('user_id',$client->user->id)->where('service',$serviceId)->get();
    $this->setStatusMessage('Data nomor tersimpan');
    return Response::json([
        'status'=>[
            'code'=>$this->getCodeSuccess(),
            'confirm'=>$this->getConfirmSuccess(),
            'message'=>$this->getStatusMessage()
        ],
        'details'=>$numberSaveds
    ]);
  }
  public function destroy(Request $request){
    $validator=Validator::make($request->all(),[
      'id'=>'required|exists:number_saveds,id'
    ]);
    if($validator->fails()){
      $this->setStatusMessage($validator->errors());
      return Response::json([
          'status'=>[
              'code'=>$this->getCodeFailed(),
              'confirm'=>$this->getConfirmFailed(),
              'message'=>$this->getStatusMessage()
          ]
      ],400);
    }
    $numberSaveds=NumberSaved::find($request->id);
    if($numberSaveds){
      if($numberSaveds->autodebit){
        $numberSaveds->autodebit->delete();
      }
      $numberSaveds->delete();
    }else{
      $this->setStatusMessage("Hapus nomor gagal. Terjadi kesalahan.");
      return Response::json([
          'status'=>[
              'code'=>$this->getCodeFailed(),
              'confirm'=>$this->getConfirmFailed(),
              'message'=>$this->getStatusMessage()
          ]
      ],400);
    }
    $this->setStatusMessage('Hapus nomor berhasi.');
    return Response::json([
        'status'=>[
            'code'=>$this->getCodeSuccess(),
            'confirm'=>$this->getConfirmSuccess(),
            'message'=>$this->getStatusMessage()
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
  private function getNumberId(){
      $i=1;
      $numberId=null;
      while (true){
          $numberId=$i.substr("".time(),-4);
          if(\App\NumberSaved::find($numberId)===null){
              break;
          }
          $i++;
      }
      return $numberId;
  }

}
