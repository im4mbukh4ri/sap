<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use JavaScript;
use File;
use App\Helpers\SipTrain;
use App\Helpers\SipRailink;
use Log;
use App\PointValue;
use App\Helpers\Point\Point;
use App\RailinkStation;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LimitPaxpaid;
use DB;

class RailinksController extends Controller
{
  protected $rqid;
  protected $mmid;
  protected $action;
  protected $app;
  public $schedule;
  public function __construct()
  {
      $this->middleware(['auth','active:1','csrf','suspend:0']);
      $this->rqid=config('sip-config')['rqid'];
      $this->mmid=config('sip-config')['mmid'];
      $this->app='information';
  }

  public function getPageSchedule(Request $request){
    //return $request->all();
    $trip=$request->trip_railink;
    $url=route('railinks.get_schedule');
    $path_station = storage_path() . "/json/railink_stations.json";
    if (!File::exists($path_station)) {
        throw new Exception("Invalid File");
    }
    $file_station = File::get($path_station);
    $railink_stations = json_decode($file_station,true);
    JavaScript::put([
        'request'=>$request->all(),
        'url'=>$url
    ]);
    $request->flash();
    return view('railinks.get-schedule',compact('trip','railink_stations'));
  }

  public function getSchedule(Request $request){
    $this->validate($request,[
        'trip_railink'=>'required',
        'origin'=>'required',
        'destination'=>'required',
        'departure_date'=>'required',
        'adt'=>'required|numeric|min:1|max:7',
        'chd'=>'required|numeric|min:0|max:7',
        'inf'=>'required|numeric|min:0|max:7'
    ]);
    $this->action="get_schedule";
    $attributes=$this->getJsonParameters($request);
    $origin=RailinkStation::find($request->origin);
    $destination=RailinkStation::find($request->destination);
    $result=SipRailink::GetSchedule($attributes)->get();

    $result['adt']=$request->adt;
    $result['chd']=$request->chd;
    $result['inf']=$request->inf;
    if($request->trip_railink=="R"){
      $responseDep="";
      $responseRet="";
      $indexDep=0;
      $indexRet=0;
      foreach ($result['schedule']['departure'] as $key => $trains) {
        $responseDep.=view('railinks._departure-get-schedule',compact('result','trains','origin','destination','indexDep'));
        $indexDep++;
      }
      foreach ($result['schedule']['return'] as $key => $trains) {
        $responseRet.=view('railinks._return-get-schedule',compact('result','trains','origin','destination','indexRet'));
        $indexRet++;
      }
      $response = [
          'departure'=>$responseDep,
          'return'=>$responseRet
      ];
    }else{
      $response = view('railinks._all-oneway-get-schedule',compact('result','origin','destination'));
    }
    return $response;
  }
  public function bookingForm(Request $request){
    $request=$request->all();
    return view('railinks._booking-form',compact('request'));
  }
  public function getSeat(Request $request){
    $param=[
      'rqid'=>$this->rqid,
      'mmid'=>$this->mmid,
      'action'=>'get_seat',
      'app'=>$this->app,
      'org'=>$request->org,
      'des'=>$request->des,
      'tgl_dep'=>$request->tgl_dep,
      'adt'=>$request->adt,
      'chd'=>$request->chd,
      'inf'=>$request->inf,
      'selectedIDdep'=>$request->selectedIDdep,
      'trip'=>$request->trip
    ];
    if($request->trip=="R"){
      $param['selectedIDret']=$request->selectedIDret;
      $param['tgl_ret']=$request->tgl_ret;
    }
    $attributes=json_encode($param);
    $seats=SipRailink::GetSeat($attributes)->get();
    unset($param['mmid']);
    unset($param['rqid']);
    unset($param['action']);
    unset($param['app']);
    $result=json_decode($request->result, true);
    $param["password"]="";
    $param["buyName"]=$request->buyName;
    $param["buyEmail"]=$request->buyEmail;
    $param["buyPhone"]=$request->buyPhone;
    $param["departure"]=json_encode($result['schedule']['departure'][$request->indexTrain]);
    $param["adtName"]=$request->adtName;
    $param["adtPhone"]=$request->adtPhone;
    $param["adtId"]=$request->adtId;
    $param["indexFare"]=$request->indexFare;
    $param["adtSeat"]=[];
    if((int)$request->chd>0){
      $param["chdName"]=$request->chdName;
      $param["chdSeat"]=[];
    }
    if($request->trip=="R"){
      $param["indexFareRet"]=$request->indexFareRet;
      $param["return"]=json_encode($result['schedule']['return'][$request->indexTrainRet]);
      $param["adtSeatRet"]=[];
      if((int)$request->chd>0){
        $param["chdSeatRet"]=[];
      }
    }
    JavaScript::put([
        'request'=>$param,
        'url'=>route("railinks.booking_issued")
    ]);
    $user=$request->user();
    $request=$request->all();
    return view('railinks._set-seat',compact('request','seats','user'));
  }
  public function bookingIssued(Request $request){
    $this->validate($request,[
      'org'=>'required',
      'des'=>'required',
      'trip'=>'required',
      'tgl_dep'=>'required',
      'adt'=>'required',
      'chd'=>'required',
      'inf'=>'required',
      'selectedIDdep'=>'required',
      'adtName.*'=>'required',
      'adtPhone.*'=>'required',
      'adtId.*'=>'required',
      'adtSeat.*'=>'required'
    ]);
    $credentials=['username'=>$request->user()->username,'password'=>$request->password];
    $userLogin=Auth::once($credentials);
    if($userLogin){
      $userId=$request->user()->id;
      $prValue=PointValue::find(1)->idr;
      $point=Point::check($userId,(int)$request->pr)->get();
      if(!$point){
        return [
          'status'=>[
            'code'=>400,
            'confirm'=>'failed',
            'message'=>'Proses issued gagal. Periksa kembali point Anda / Refresh halaman ini. Terimakasih.'
          ]
        ];
      }
      $this->action="bookingIssued";
      $this->app="transaction";
      $param=[
          'rqid'=>$this->rqid,
          'app'=>$this->app,
          'action'=>$this->action,
          'mmid'=>$this->mmid,
          'org'=>$request->org,
          'des'=>$request->des,
          'trip'=>$request->trip,
          'tgl_dep'=>$request->tgl_dep,
          'adt'=>$request->adt,
          'chd'=>$request->chd,
          'inf'=>$request->inf,
          'selectedIDdep'=>$request->selectedIDdep,
          'cpname'=>$request->buyName,
          'cpmail'=>$request->buyEmail,
          'cptlp'=>$request->buyPhone,
          'pr'=>0,
          'indexFare'=>$request->indexFare
      ];
      $param['pr']=(int)$request->pr*$prValue;
      if($param['pr']>0){
          $param['point']=$request->pr;
      }
      for ($i=1;$i<=count($request->adtName);$i++){
          $param['nmadt_'.$i]=$request->adtName[$i-1];
          $param['hpadt_'.$i]=$request->adtPhone[$i-1];
          $param['idadt_'.$i]=$request->adtId[$i-1];
          $param['departure']['seatadt_'.$i]=$request->adtSeat[$i-1];
      }
      if($request->has('chdName')){
        for ($i=1;$i<=count($request->chdName);$i++){
            $param['nmchd_'.$i]=$request->chdName[$i-1];
            $param['departure']['seatchd_'.$i]=$request->chdSeat[$i-1];
        }
      }
      $departure=json_decode($request->departure,true);
      $param['totalFare']=(int)$departure['Fares'][$request->indexFare]['TotalFare'];
      $param['device']='web';
      $param['service_id']=4;
      $param['result']=[
        'departure'=>$departure
      ];
        $param['admin']=0;
        $param['adminDep']=0;
      if($request->trip=="R"){
        $param['adminRet']=0;
        $param['indexFareRet']=$request->indexFareRet;
        for ($i=1;$i<=count($request->adtName);$i++){
            $param['nmadt_'.$i]=$request->adtName[$i-1];
            $param['hpadt_'.$i]=$request->adtPhone[$i-1];
            $param['idadt_'.$i]=$request->adtId[$i-1];
            $param['return']['seatadt_'.$i]=$request->adtSeatRet[$i-1];
        }
        if($request->has('chdName')){
          for ($i=1;$i<=count($request->chdName);$i++){
              $param['nmchd_'.$i]=$request->chdName[$i-1];
              $param['return']['seatchd_'.$i]=$request->chdSeatRet[$i-1];
          }
        }

        $return=json_decode($request->return,true);
        $param['result']['return']=$return;
        $param['selectedIDret']=$request->selectedIDret;
        $param['tgl_ret']=$request->tgl_ret;
        $param['totalFareRet']=(int)$return['Fares'][$request->indexFareRet]['TotalFare'];
        if(
          $request->user()->username=="member_silver"||
          $request->user()->username=="member_gold"||
          $request->user()->username=="member_platinum"||
          $request->user()->username=="trialdev"||
          $request->user()->username=="member_free"||
          $request->user()->username=="prouser"||
          $request->user()->username=="basicuser"||
          $request->user()->username=="advanceuser"
        ){
          $limit = LimitPaxpaid::GlobalPaxpaid($param['totalFare']+$param['totalFareRet'],$request->user()->id)->get();
          if($limit){
            return [
                'status'=>[
                    'code'=>400,
                    'confirm'=>'failed',
                    'message'=>'Oops! Anda melebihi limit transaksi bulan ini.'
                ]
            ];
          }
        }
      }else{
        if(
          $request->user()->username=="member_silver"||
          $request->user()->username=="member_gold"||
          $request->user()->username=="member_platinum"||
          $request->user()->username=="trialdev"||
          $request->user()->username=="member_free"||
          $request->user()->username=="prouser"||
          $request->user()->username=="basicuser"||
          $request->user()->username=="advanceuser"
        ){
          $limit = LimitPaxpaid::GlobalPaxpaid($param['totalFare'],$request->user()->id)->get();
          if($limit){
            return [
                'status'=>[
                    'code'=>400,
                    'confirm'=>'failed',
                    'message'=>'Oops! Anda melebihi limit transaksi bulan ini.'
                ]
            ];
          }
        }
      }
      $result=SipTrain::CreateTransaction($request->user()->id,$param)->get();
      return $result;
    }
    return [
      "status"=>[
        "code"=>401,
        "confirm"=>"failed",
        "message"=>"Password salah !"
      ]
    ];
  }
  private function getJsonParameters($request){
      $params=[
          'rqid'=>$this->rqid,
          'mmid'=>$this->mmid,
          'action'=>$this->action,
          'org'=>$request->origin,
          'des'=>$request->destination,
          'trip'=>$request->trip_railink,
          'tgl_dep'=>date('Y-m-d',strtotime($request->departure_date)),
          'app'=>$this->app,
          'adt'=>$request->adt,
          'chd'=>$request->chd,
          'inf'=>$request->inf,
      ];
      if($request->trip_railink=='R'){
          $params['tgl_ret']=date('Y-m-d',strtotime($request->return_date));
      }
      $attributes=json_encode($params);
      return $attributes;
  }

  public function report(Request $request){
    $bookings=array();
     $from=date("Y-m-d",time());
     $until=date("Y-m-d",time());
     $reqStatus = $request->status;
   if($request->has('from')&&$request->has('until')){
         $from=date('Y-m-d',strtotime($request->from));
         $until=date('Y-m-d',strtotime($request->until));
         $transactions = $request->user()->train_transactions()->where('sip_service_id',4)
             ->whereBetween('created_at',[$from.' 00:00:00',$until.' 23:59:59'])->get()->sortByDesc('created_at');
         $request->flash();
   }else{
         $transactions = $request->user()->train_transactions()->where('sip_service_id',4)
             ->whereBetween('created_at',[$from.' 00:00:00',$until.' 23:59:59'])->get()->sortByDesc('created_at');
   }
   $totalAmount = DB::select("SELECT SUM(railink_bookings.paxpaid) as total_marketprice, SUM(railink_commissions.bv) as total_smartpoint, SUM(railink_commissions.member) as total_smarcash FROM railink_bookings
         INNER JOIN railink_commissions ON railink_bookings.id = railink_commissions.railink_booking_id
         INNER JOIN train_transactions ON railink_bookings.train_transaction_id = train_transactions.id
         WHERE railink_bookings.created_at BETWEEN '{$from} 00:00:00' AND '{$until} 23:59:59' AND train_transactions.user_id = '{$request->user()->id}' AND train_transactions.sip_service_id = '4' AND railink_bookings.status <> 'failed' AND railink_bookings.status LIKE '%{$reqStatus}%'");
   $from=date('d-m-Y',strtotime($from));
     $until=date('d-m-Y',strtotime($until));
     JavaScript::put([
         'request'=>[
             'from'=>$from,
             'until'=>$until
         ]
     ]);
     return view('railinks.reports.index',compact('transactions','request','bookings','totalAmount','reqStatus'));
  }

  public function showReport(Request $request,$id){
    $transaction=$request->user()->train_transactions->find($id);
    if($transaction){
        return view('railinks.reports.show',compact('transaction'));
    }
    return response('not found',401);
  }
}
