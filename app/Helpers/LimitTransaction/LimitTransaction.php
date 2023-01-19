<?php

namespace App\Helpers\LimitTransaction;
use DB;
use Log;
class LimitTransaction {
  protected $totalFare;
  protected $userId;
  protected $scope;
  protected $startDate;
  protected $endDate;
  protected $totalAirlines;
  protected $totalPulsa;
  protected $totalPPOB;
  protected $totalTrain;
  protected $totalRailink;
  protected $globalLimit;
  protected $result;

  public function __construct($totalFare,$userId){
    $this->setStartDate(date("Y-m",time()));
    $this->setEndDate(date("Y-m-d",time()));
    $this->setUserId($userId);
    $this->setTotalFare($totalFare);
  }
  public function setStartDate($start){
    $this->startDate=$start."-01 00:00:00";
  }
  public function getStartDate(){
    return $this->startDate;
  }
  public function setEndDate($end){
    $this->endDate=$end." 23:59:59";
  }
  public function getEndDate(){
    return $this->endDate;
  }
  public function setUserId($userId){
    $this->userId=$userId;
  }
  public function getUserId(){
    return $this->userId;
  }
  public function setTotalFare($totalFare){
    $this->totalFare=(int)$totalFare;
  }
  public function getTotalFare(){
    return $this->totalFare;
  }
  public function globalScope(){
    // \Log::info($this->endDate);
    // \Log::info('endDate : ');
    // \Log::info($this->startDate);
    // \Log::info('startDate : ');
    $total=$this->airlines();
    // \Log::info($this->airlines());
    // \Log::info('Total Airlines : ');
    // \Log::info($total);
    // \Log::info('Total setelah airlines masuk : ');
    $total=$total+$this->pulsa();
    // \Log::info($this->pulsa());
    // \Log::info('Total pulsa : ');
    // \Log::info($total);
    // \Log::info('Total setelah pulsa masuk : ');
    $total=$total+$this->ppob();
    // \Log::info($this->ppob());
    // \Log::info('Total Ppob : ');
    // \Log::info($total);
    // \Log::info('Total setelah ppob masuk : ');
    $total=$total+$this->train();
    // \Log::info($this->train());
    // \Log::info('Total Train : ');
    // \Log::info($total);
    // \Log::info('Total setelah train masuk : ');
    $total=$total+$this->railink();
    // \Log::info($this->railink());
    // \Log::info('Total Railink : ');
    // \Log::info($total);
    // \Log::info('Total setelah Railink masuk : ');
    $total=$total+$this->getTotalFare();
    // \Log::info($this->getTotalFare());
    // \Log::info('Total TotalFare : ');
    // \Log::info($total);
    // \Log::info('Total setelah Total Fare masuk : ');
    $this->setGlobalLimit($this->getUserId());
    if ($this->getGlobalLimit()==0){
      $this->result=false;
    }elseif($total<$this->getGlobalLimit()){
      $this->result=false;
    }else{
      $this->result=true;
    }
  }
  public function get(){
    return $this->result;
  }
  public function setGlobalLimit($userId){
    $user = \App\User::find($userId);
    $this->globalLimit = $user->type_user->limit_paxpaid->limit;
  }
  public function getGlobalLimit(){
    return $this->globalLimit;
  }
  public function airlines(){
    // $airlines=DB::table('airlines_transactions')
    //   ->join('airlines_booking','airlines_transactions.id','=','airlines_booking.airlines_transaction_id')
    //   ->select(DB::raw('SUM(airlines_transactions.total_fare) as total_fare'))
    //   ->whereBetween('airlines_booking.updated_at',['2017-07-01 00:00:00','2017-07-07 23:59:59'])
    //   ->where('airlines_transactions.user_id','=',2)
    //   ->where('airlines_booking.status','=','issued')->first();
    $paxpaid=0;
    $airlines=DB::table('airlines_transactions')
      ->join('airlines_booking','airlines_transactions.id','=','airlines_booking.airlines_transaction_id')
      ->select(DB::raw('SUM(airlines_transactions.total_fare) as total_fare'))
      ->whereBetween('airlines_booking.updated_at',[$this->getStartDate(),$this->getEndDate()])
      ->where('airlines_transactions.user_id','=',$this->getUserId())
      ->where('airlines_booking.status','=','issued')->first();
      // \Log::info($airlines->total_fare);
      // \Log::info("Hasil Query Airlines : ");
    $paxpaid+=(int)$airlines->total_fare;
    return $paxpaid;
  }
  public function pulsa(){
    $paxpaid=0;
    $pulsa = DB::table('ppob_transactions')
      ->select(DB::raw('SUM(paxpaid) as paxpaid'))
      ->whereBetween('updated_at',[$this->getStartDate(),$this->getEndDate()])
      ->where('user_id','=',$this->getUserId())
      ->where('service','=',1)
      ->where('status','=','SUCCESS')->first();
      // \Log::info($pulsa->paxpaid);
      // \Log::info("Hasil Query Pulsa : ");
      $paxpaid+=(int)$pulsa->paxpaid;
    return $paxpaid;
  }

  public function ppob(){
    $paxpaid=0;
    $ppob = DB::table('ppob_transactions')
      ->select(DB::raw('SUM(paxpaid) as paxpaid'))
      ->whereBetween('updated_at',[$this->getStartDate(),$this->getEndDate()])
      ->where('user_id','=',$this->getUserId())
      ->where('service','!=',1)
      ->where('status','=','SUCCESS')->first();
      // \Log::info($ppob->paxpaid);
      // \Log::info("Hasil Query PPOB : ");
    $paxpaid+=(int)$ppob->paxpaid;
    return $paxpaid;
  }

  public function train(){
    $paxpaid=0;
    $train = DB::table('train_transactions')
      ->join('train_bookings','train_transactions.id','=','train_bookings.train_transaction_id')
      ->select(DB::raw('SUM(total_fare) as total_fare'))
      ->whereBetween('train_bookings.updated_at',[$this->getStartDate(),$this->getEndDate()])
      ->where('train_transactions.user_id','=',$this->getUserId())
      ->where('train_bookings.status','=','issued')->first();
      // \Log::info($train->total_fare);
      // \Log::info("Hasil Query Train : ");
      $paxpaid+=(int)$train->total_fare;
      return $paxpaid;
  }

  public function railink(){
    $paxpaid=0;
    $train = DB::table('train_transactions')
      ->join('railink_bookings','train_transactions.id','=','railink_bookings.train_transaction_id')
      ->select(DB::raw('SUM(total_fare) as total_fare'))
      ->whereBetween('railink_bookings.updated_at',[$this->getStartDate(),$this->getEndDate()])
      ->where('train_transactions.user_id','=',$this->getUserId())
      ->where('railink_bookings.status','=','issued')->first();
      // \Log::info($train->total_fare);
      // \Log::info("Hasil Query Railink : ");
      $paxpaid+=(int)$train->total_fare;
      return $paxpaid;
  }



}
