<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\OauthAccessToken;
use App\OauthClientSecret;
use App\NumberSaved;
use App\Autodebit;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Response;

class ApiAutodebitsController extends Controller
{
    //
    private $confirmSuccess='success';
    private $confirmFailed='failed';
    private $codeSuccess=200;
    private $codeFailed=400;
    private $statusMessage;

    public function __construct(Request $request){
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

    public function lists(Request $request){
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
      $this->setStatusMessage("Berhasil mendapatkan list autodebet.");
      return Response::json([
          'status'=>[
              'code'=>$this->getCodeSuccess(),
              'confirm'=>$this->getConfirmSuccess(),
              'message'=>$this->getStatusMessage()
          ],
          'details'=>$client->user->autodebits
      ]);

    }
    public function store(Request $request){
      $validator=Validator::make($request->all(),[
        'id'=>'required',
        'date'=>'required|numeric'
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
      $numberSaved=NumberSaved::find($request->id);
      if(!$numberSaved){
        $this->setStatusMessage('ID nomor tidak ditemukan.');
        return Response::json([
            'status'=>[
                'code'=>$this->getCodeFailed(),
                'confirm'=>$this->getConfirmFailed(),
                'message'=>$this->getStatusMessage()
            ],
        ]);
      }
      if($numberSaved->autodebit){
        $this->setStatusMessage('Nomor yang Anda pilih sudah terdaftar di Autodebet');
        return Response::json([
            'status'=>[
                'code'=>$this->getCodeFailed(),
                'confirm'=>$this->getConfirmFailed(),
                'message'=>$this->getStatusMessage()
            ],
        ]);
      }
      try{
        $numberSaved->autodebit()->create([
          'id'=>$this->getNumberId(),
          'user_id'=>$numberSaved->user_id,
          'date'=>$request->date
        ]);
      }catch(\Exception $e){
        $this->setStatusMessage($e->getMessage());
        return Response::json([
            'status'=>[
                'code'=>$this->getCodeFailed(),
                'confirm'=>$this->getConfirmFailed(),
                'message'=>$this->getStatusMessage()
            ],
        ]);
      }
      $this->setStatusMessage("Berhasil menambahkan nomor ke Autodebet.");
      return Response::json([
          'status'=>[
              'code'=>$this->getCodeSuccess(),
              'confirm'=>$this->getConfirmSuccess(),
              'message'=>$this->getStatusMessage()
          ],
          'details'=>$numberSaved
      ]);
    }
    public function destroy(Request $request){
      $autodebit=Autodebit::find($request->id);
      if(!$autodebit){
        $this->setStatusMessage("ID tidak ditemukan.");
        return Response::json([
            'status'=>[
                'code'=>$this->getCodeFailed(),
                'confirm'=>$this->getConfirmFailed(),
                'message'=>$this->getStatusMessage()
            ],
        ]);
      }
      $autodebit->delete();
      $this->setStatusMessage("Berhasil hapus Autodebet.");
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
            if(Autodebit::find($numberId)===null){
                break;
            }
            $i++;
        }
        return $numberId;
    }
}
