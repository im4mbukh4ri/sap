<?php

namespace App\Http\Controllers\Admin;

use App\AirlinesBooking;
use App\PpobService;
use App\PpobTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use JavaScript;

class StatisticsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    public function airlines(Request $request){
        $request->year='2017';
        $statistics=array();
        $months=['01','02','03','04','05','06','07','08','09','10','11','12'];
        foreach ($months as $month){
            $statistics[]=AirlinesBooking::where('status','issued')->where('created_at','LIKE',$request->year.'-'.$month.'%')->get();
        }
        return view('admin.statistics.airlines',compact('statistics'));
    }
    public function pulsa(Request $request){
        $startDate=date("Y-m-d",time());
        $endDate=date("Y-m-d",time());
        if($request->has('start_date')&&$request->has('end_date')){
            $this->validate($request,[
                'start_date'=>'date',
                'end_date'=>'date'
            ]);
            $startDate=date('Y-m-d',strtotime($request->start_date));
            $endDate=date('Y-m-d',strtotime($request->end_date));
            $totalDay=daysDifference($endDate,$startDate)+1;
            //Log::info($totalDay);
            if($totalDay>31){
                flash()->overlay('Statistik pulsa yang bisa Anda cek maksimal 31 hari.','INFO');
                return redirect()->back();
            }
            $statistics=DB::table('ppob_transactions')->join('ppob_services','ppob_transactions.ppob_service_id','=','ppob_services.id')
                ->select('ppob_services.name',DB::raw(' COUNT(ppob_transactions.id) as total'))
                ->whereBetWeen('ppob_transactions.created_at',[$startDate.' 00:00:00',$endDate.' 23:59:59'])->where('ppob_transactions.service',1)
                ->where('ppob_transactions.status','SUCCESS')->groupBy('ppob_transactions.ppob_service_id')->orderBy('total','desc')->get();
            $request->flash();
            $startDate=date('d-m-Y',strtotime($startDate));
            $endDate=date('d-m-Y',strtotime($endDate));
            JavaScript::put([
                'request'=>[
                    'from'=>$startDate,
                    'until'=>$endDate
                ]
            ]);
            return view('admin.statistics.pulsa',compact('statistics'));
        }
        $request->flash();
        $startDate=date('d-m-Y',strtotime($startDate));
        $endDate=date('d-m-Y',strtotime($endDate));
        JavaScript::put([
            'request'=>[
                'from'=>$startDate,
                'until'=>$endDate
            ]
        ]);
        return view('admin.statistics.pulsa');
    }
    public function pulsaOperator(Request $request){
        $startDate=date("Y-m-d",time());
        $endDate=date("Y-m-d",time());
        $operator_id=$request->operator_id;
        if($request->has('start_date')&&$request->has('end_date')&&$request->has('operator_id')){
            $this->validate($request,[
                'start_date'=>'date',
                'end_date'=>'date',
                'operator_id'=>'exists:ppob_services,id'
            ]);
            $startDate=date('Y-m-d',strtotime($request->start_date));
            $endDate=date('Y-m-d',strtotime($request->end_date));
            $totalDay=daysDifference($endDate,$startDate)+1;
            //Log::info($totalDay);
            if($totalDay>31){
                flash()->overlay('Statistik pulsa yang bisa Anda cek maksimal 31 hari.','INFO');
                return redirect()->back();
            }

            $startTime=Carbon::createFromFormat('Y-m-d H:i:s',$startDate.' 00:00:00');
            $endTime=Carbon::createFromFormat('Y-m-d H:i:s',$startDate.' 23:59:59');
            $operator=PpobService::find($request->operator_id);
            $transactions=array();
            foreach ($operator->childs as $key => $value){
                $transactions[]=$value->transactions()->whereBetWeen('created_at',[$startDate.' 00:00:00',$endDate.' 23:59:59'])->where('status','SUCCESS')->get();
            }
            //$transactions=rsort($transactions);
            $days=array();
            for($i=1;$i<=$totalDay;$i++){
                $transactionByDays=array();
                foreach ($operator->childs as $key => $value){
//                    $totalKomisi90=$value->transactions()->whereBetWeen('created_at',[$startTime,$endTime])->where('status','SUCCESS')->get(['nra'])->sum();
//                    $transactionByDays[]=$value->transactions()->whereBetWeen('created_at',[$startTime,$endTime])->where('status','SUCCESS')->get();
                    //$transactionByDays=PpobTransaction::whereBetWeen('created_at',[$startTime,$endTime])->where('ppob_service_id',$value->id)->where('status','SUCCESS')->get();
                    $transactionByDays[]=DB::table('ppob_transactions')->join('ppob_commissions','ppob_transactions.id','=','ppob_commissions.ppob_transaction_id')
                    ->select(DB::raw(' COUNT(ppob_transactions.id) as total_trx'),DB::raw('SUM(ppob_transactions.paxpaid) as paxpaid'),
                        DB::raw('SUM(ppob_transactions.pr) as point_reward'),
                        DB::raw('SUM(ppob_transactions.nta) as nta'),DB::raw('SUM(ppob_transactions.nra) as nra'),
                        DB::raw('SUM(ppob_commissions.komisi) as komisi'),DB::raw('SUM(ppob_commissions.free) as free'),
                        DB::raw('SUM(ppob_commissions.pusat) as sip'),DB::raw('SUM(ppob_commissions.member) as smart_cash'),DB::raw('SUM(ppob_commissions.bv) as smart_point'))
                    ->whereBetWeen('ppob_transactions.created_at',[$startTime,$endTime])->where('ppob_service_id',$value->id)->where('ppob_transactions.status','SUCCESS')->get();
                    // $transactionByDays[]=DB::table('ppob_transactions')->join('ppob_commissions','ppob_transactions.id','=','ppob_commissions.ppob_transaction_id')
                    // ->select('ppob_transactions.ppob_service_id',DB::raw('SUM(ppob_transactions.paxpaid) as paxpaid'),
                    // DB::raw('SUM(ppob_transactions.nta) as nta'),DB::raw('SUM(ppob_transactions.nra) as nra'),
                    //     DB::raw('SUM(ppob_commissions.komisi) as komisi'),DB::raw('SUM(ppob_commissions.free) as free'),
                    //     DB::raw('SUM(ppob_commissions.pusat) as sip'),DB::raw('SUM(ppob_commissions.member) as smart_cash'),DB::raw('SUM(ppob_commissions.bv) as smart_point'))
                    // ->whereBetWeen('ppob_transactions.created_at',[$startTime,$endTime])->where('ppob_service_id',$value->id)->where('ppob_transactions.status','SUCCESS')->get();
                }
                $days[]=$transactionByDays;
                $startTime->addDay();
                $endTime->addDay();
            }
            $request->flash();
            $startDate=date('d-m-Y',strtotime($startDate));
            $endDate=date('d-m-Y',strtotime($endDate));
            JavaScript::put([
                'request'=>[
                    'from'=>$startDate,
                    'until'=>$endDate
                ]
            ]);
            return view('admin.statistics.pulsa.index',compact('operator_id','transactions','days'));
        };
        $request->flash();
        $startDate=date('d-m-Y',strtotime($startDate));
        $endDate=date('d-m-Y',strtotime($endDate));
        JavaScript::put([
            'request'=>[
                'from'=>$startDate,
                'until'=>$endDate
            ]
        ]);
        return view('admin.statistics.pulsa.index',compact('operator_id'));
    }
    public function ppob(Request $request){
        $request->year='2017';
        $statistics=array();
        $months=['01','02','03','04','05','06','07','08','09','10','11','12'];
        foreach ($months as $month){
            $statistics[]=PpobTransaction::where('service','<>',1)->where('status','SUCCESS')->where('created_at','LIKE',$request->year.'-'.$month.'%')->get();
        }
        return view('admin.statistics.ppob',compact('statistics'));
    }
    public function point(Request $request){
      $startDate=date("Y-m-d",time());
      $endDate=date("Y-m-d",time());
      if($request->has('start_date')&&$request->has('end_date')){
        $this->validate($request,[
            'start_date'=>'date',
            'end_date'=>'date'
        ]);
        $startDate=date('Y-m-d',strtotime($request->start_date));
        $endDate=date('Y-m-d',strtotime($request->end_date));
        $totalDay=daysDifference($endDate,$startDate)+1;
        //Log::info($totalDay);
        if($totalDay>31){
            flash()->overlay('Statistik point reward yang bisa Anda cek maksimal 31 hari.','INFO');
            return redirect()->back();
        }
        $points=array();
        $startTime=Carbon::createFromFormat('Y-m-d H:i:s',$startDate.' 00:00:00');
        $endTime=Carbon::createFromFormat('Y-m-d H:i:s',$startDate.' 23:59:59');
        for($i=1;$i<=$totalDay;$i++){
          $points[]=DB::table('history_points')
            ->select(
              DB::raw('SUM(debit) as debit'),
              DB::raw('SUM(credit) as credit')
              )
            ->whereBetWeen('created_at',[$startTime,$endTime])
            ->where('user_id','!=','5159')
            ->get();
            $startTime->addDay();
            $endTime->addDay();
        }
        $all=DB::table('users')
          ->select(DB::raw('SUM(point) as point'))
          ->where('type_user_id','!=',5)
          ->where('id','!=','5159')
          ->get();
        $request->flash();
        $startDate=date('d-m-Y',strtotime($startDate));
        $endDate=date('d-m-Y',strtotime($endDate));
        JavaScript::put([
            'request'=>[
                'from'=>$startDate,
                'until'=>$endDate
            ]
        ]);
        return view('admin.statistics.point.index',compact('points','all'));
      }
      $request->flash();
      $startDate=date('d-m-Y',strtotime($startDate));
      $endDate=date('d-m-Y',strtotime($endDate));
      JavaScript::put([
          'request'=>[
              'from'=>$startDate,
              'until'=>$endDate
          ]
      ]);
      return view('admin.statistics.point.index');
    }
}
