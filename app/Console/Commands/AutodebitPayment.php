<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Autodebit;
use App\PpobService;
use App\Helpers\SipPpob;
use Log;
class AutodebitPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:autodebit_payment';
    private $mmid;
    private $rqid;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron for autodebit payment as PLN Pascabayar, TV Cable, Insurance, etc.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->mmid=config('sip-config')['mmid'];
        $this->rqid=config('sip-config')['rqid'];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $messages=array();
        $date=date("j",time());
        $autodebits=Autodebit::where('date',$date)->where('status',1)->get();
        foreach ($autodebits as $key => $value) {
          $inquiry=$this->inquiry($value);
          if($inquiry['error_code']=="000"){
            $messages[]="Success inquiry "." "
            .$value->number_saved->ppob_service->name." "
            .$value->number_saved->name." "
            .$value->number_saved->number;
            $transaction = $this->transaction($value,$inquiry);
            if($transaction['status']['code']==200){
              $messages[]="Success Payment "
              .$value->number_saved->ppob_service->name." "
              .$value->number_saved->name." "
              .$value->number_saved->number;
            }else{
              $messages[]="Failed Payment "
              .$value->number_saved->ppob_service->name." "
              .$value->number_saved->name." "
              .$value->number_saved->number
              ." Error : ".$transaction["status"]["message"][0];
            }
          }else{
            $messages[]="Failed inquiry "." "
            .$value->number_saved->ppob_service->name." "
            .$value->number_saved->name." "
            .$value->number_saved->number." "
            ."Error : ".$inquiry["error_msg"];
          }
        }
        \App\LogCron::create(['log'=>implode(',',$messages)]);
    }
    private function inquiry($value){
      $product=getService($value->number_saved->service);
      switch ($value->number_saved->service) {
          case 2:
              $productCode = PpobService::find($value->number_saved->service)->code;
              break;
          case 3:
              $productCode = PpobService::find($value->number_saved->service)->code;
              break;
          default:
              $productCode = PpobService::find($value->number_saved->ppob_service_id)->code;
              break;
      }
      $param=[
        'rqid'=>$this->rqid,
        'app'=>"information",
        'action'=>"inq_ppob",
        'mmid'=>$this->mmid,
        'product'=>$product,
        'product_code'=>$productCode,
        'noid'=>$value->number_saved->number
      ];
      $inquiry=SipPpob::inquery(json_encode($param))->get();
      if($inquiry['error_code']=="000"){
        $commission=$this->getCommission($value,$inquiry);
        $inquiry['commission']=$commission;
      }
      return $inquiry;
    }
    private function transaction($value,$inquiry){
      $param=[
          'service_id'=>$value->number_saved->service,
          'code'=>$value->number_saved->ppob_service_id,
          'number'=>$value->number_saved->number,
          'pr'=>0,
      ];

      switch ($value->number_saved->service){
          case '2':
              $product=PpobService::find($param['code']);
              $strNominal=substr($product->code,3);
              $strNominal=$strNominal."000";
              $paxpaid=(int)$strNominal+(int)$inquiry['admin'];
              $param['price']=$paxpaid-$inquiry['commission']-$param['pr'];
              $param['paxpaid']=$paxpaid;
              break;
          case '3':
              $param['price']=(int)$inquiry['total']-(int)$inquiry['commission']-$param['pr'];
              $param['paxpaid']=(int)$inquiry['total'];
              break;
          case '9':
              $param['paxpaid']=(int)$inquiry['total'];
              $param['price']=(int)$inquiry['total']-(int)$inquiry['commission']-$param['pr'];
              break;
          default :
              $param['paxpaid']=(int)$inquiry['total'];
              $param['price']=(int)$inquiry['total']-(int)$inquiry['commission']-$param['pr'];
              $param['reff']=$inquiry['reff'];
              break;
      }
      $param['device']="system";
      $transaction = SipPpob::createTransaction($value->user_id,json_encode($param))->get();
      return $transaction;
    }
    private function getCommission($value,$inquiry){
      $commission=0;
      if($value->user->role!='free'){
          if(isset($inquiry['nra'])){
              $nra=$inquiry['nra'];
              $komisi=((int)$nra*(int)config('sip-config')['member_commission'])/100;
              //$free = (int)$nra-(int)$komisi;
              $member= ((int)$komisi * (int)$value->user->type_user->member_ppob->commission)/100;
              $commission=$member;
          }
      }else{
          if(isset($inquiry['nra'])){
              $nra=$inquiry['nra'];
              $komisi=((int)$nra*(int)config('sip-config')['member_commission'])/100;
              //$free = (int)$nra-(int)$komisi;
              $member= ((int)$komisi * (int)$value->user->parent->type_user->member_ppob->commission)/100;
              $free=floor(($member*$value->user->type_user->member_ppob->commission)/100);
              $commission=$free;
          }
      }
      return $commission;
    }
}
