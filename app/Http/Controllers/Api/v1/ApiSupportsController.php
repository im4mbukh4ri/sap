<?php

namespace App\Http\Controllers\Api\v1;

use App\SipContent;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ApiSupportsController extends Controller
{
    //
    private $confirmSuccess='success';
    private $confirmFailed='failed';
    private $codeSuccess=200;
    private $codeFailed=400;
    private $statusMessage;
    public function __construct()
    {
        $this->middleware('oauth');
    }
    public function terms(){
        $terms['aturan_main']=SipContent::find(25);
        $this->setStatusMessage('Berhasil get data ketentuan');
        return Response::json([
            'status'=>[
                'code'=>$this->getCodeSuccess(),
                'confirm'=>$this->getConfirmSuccess(),
                'message'=>$this->getStatusMessage()
            ],
            'details'=>$terms
        ]);
    }
    public function faqs(){
        $faqs=array();
        $faqs['deposit']=SipContent::whereBetween('id',[54,63])
            ->orWhere('id',122)
            ->orWhere('id',123)->get();
        $faqs['airlines']=SipContent::whereBetween('id',[64,76])->orWhere('id',93)->orWhere('id',94)->get();
        $faqs['ppob']=SipContent::whereBetween('id',[137,150])
            ->orWhere('id', 77)
            ->orWhere('id', 78)->get();
        $faqs['login']=SipContent::whereBetween('id',[83,86])->get();
        $faqs['free_trial']=SipContent::whereBetween('id',[113,120])->get();
//        $faqs['credit_card']=SipContent::whereBetween('id',[137,142])->get();
        $this->setStatusMessage('Berhasil get data faq');
        return Response::json([
            'status'=>[
                'code'=>$this->getCodeSuccess(),
                'confirm'=>$this->getConfirmSuccess(),
                'message'=>$this->getStatusMessage()
            ],
            'details'=>$faqs
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
