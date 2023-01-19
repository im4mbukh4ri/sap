<?php

namespace App\Helpers\Airlines;

use App\AirlinesBooking;
use App\AirlinesBookingFailedMessage;
use App\AirlinesBookingTransactionNumber;
use App\AirlinesCommission;
use App\AirlinesItinerary;
use App\Buyer;
use App\DocumentPassenger;
use App\Helpers\Deposit\Deposit;
use App\Helpers\Point\Point;
use App\Helpers\SipAirlines;
use App\Passenger;
use App\PassengerPhone;
use App\User;
use DB;
use Log;

class AirlinesTransaction
{
    protected $request;
    protected $user_id;
    protected $response;
    private $airlinesTransaction;
    private $status;
    private $booking;
    private $bookingReturn;
    private $itineraryDeparture;
    private $itineraryReturn;
    private $user;
    private $percentPusat;
    private $percentBv;
    private $percentMember;
    private $totalAmount;

    public function setRequest($request)
    {
        $this->$request=$request;
    }
    public function getRequest()
    {
        return $this->request;
    }

    public function get()
    {
        return $this->response;
    }
    public function toJson()
    {
        $this->response=json_encode($this->response);
        return $this->response;
    }
    protected function createData()
    {
        $arrRequest=json_decode($this->getRequest(), true);
        //  \Log::info($arrRequest);
        //  \Log::info("Request in transaction : ");
        if (is_array($arrRequest['result'])) {
            $arrResult=$arrRequest['result'];
        } else {
            $arrResult=json_decode($arrRequest['result'], true);
        }
        unset($arrRequest['result']);
        if (Deposit::check($this->user_id, $arrRequest['totalFare']-$arrRequest['pr'])->get()||$arrRequest['action']=='booking') {
            $id=$this->getTransactionId();

            DB::beginTransaction();
            try {
                $buyer= Buyer::create([
                    'name'=>$arrRequest['cpname'],
                    'email'=>$arrRequest['cpmail'],
                    'phone'=>$arrRequest['cptlp'],
                ]);
                if (isset($arrRequest['device'])) {
                    $device=$arrRequest['device'];
                } else {
                    $device='undefined';
                }
                $bookable = 1;
                if($arrRequest['action']=='bookingIssued'){
                    $bookable = 0;
                }
                $buyer->airlinesTransaction()->save(
                    $this->airlinesTransaction = new \App\AirlinesTransaction([
                        'id'=>$id,
                        'user_id'=>$this->user_id,
                        'trip_type_id'=>$arrRequest['flight'],
                        'adt'=>$arrRequest['adt'],
                        'chd'=>$arrRequest['chd'],
                        'inf'=>$arrRequest['inf'],
                        'total_fare'=>$arrRequest['totalFare'],
                        'expired'=>'0000-00-00 00:00:00',
                        'bookable' => $bookable,
                        'device'=>$device
                    ])
                );
                $adt=1;
                $chd=1;
                $inf=1;
                while ($adt <= 7) {
                    if (array_has($arrRequest, 'titadt_'.$adt)) {
                        $this->airlinesTransaction->passengers()->save($passanger = new Passenger([
                            'type'=>'adt',
                            'title'=>$arrRequest['titadt_'.$adt],
                            'first_name'=>$arrRequest['fnadt_'.$adt],
                            'last_name'=>$arrRequest['lnadt_'.$adt],
                            'birth_date'=>'000-00-00',
                            'national'=>'Indonesia'
                        ]));
                        $passanger->phone()->save(new PassengerPhone([
                            'number'=>$arrRequest['hpadt_'.$adt]
                        ]));
                        if (array_has($arrRequest, 'birthadt_'.$adt)) {
                            $passanger->document_passenger()->save(new DocumentPassenger([
                                'type'=>'passport',
                                'number'=>$arrRequest['passnoadt_'.$adt],
                                'expired'=>$arrRequest['passenddateadt_'.$adt],
                                'nationality_id'=>$arrRequest['natadt_'.$adt],
                                'issued_country_id'=>$arrRequest['passnatadt_'.$adt],
                                'birth_date'=>$arrRequest['birthadt_'.$adt]
                            ]));
                        }
                    } else {
                        break;
                    }
                    $adt++;
                }
                while ($chd <= 7) {
                    if (array_has($arrRequest, 'titchd_'.$chd)) {
                        $this->airlinesTransaction->passengers()->save($passChd=new Passenger([
                            'type'=>'chd',
                            'title'=>$arrRequest['titchd_'.$chd],
                            'first_name'=>$arrRequest['fnchd_'.$chd],
                            'last_name'=>$arrRequest['lnchd_'.$chd],
                            'birth_date'=>$arrRequest['birthchd_'.$chd],
                            'national'=>'Indonesia'
                        ]));
                        if (array_has($arrRequest, 'passnochd_'.$chd)) {
                            $passChd->document_passenger()->save(new DocumentPassenger([
                                'type'=>'passport',
                                'number'=>$arrRequest['passnochd_'.$chd],
                                'expired'=>$arrRequest['passenddatechd_'.$chd],
                                'nationality_id'=>$arrRequest['natchd_'.$chd],
                                'issued_country_id'=>$arrRequest['passnatchd_'.$chd],
                                'birth_date'=>$arrRequest['birthchd_'.$chd]
                            ]));
                        }
                    } else {
                        break;
                    }
                    $chd++;
                }
                while ($inf <= 7) {
                    if (array_has($arrRequest, 'titinf_'.$inf)) {
                        $this->airlinesTransaction->passengers()->save($passInf = new Passenger([
                            'type'=>'inf',
                            'title'=>$arrRequest['titinf_'.$inf],
                            'first_name'=>$arrRequest['fninf_'.$inf],
                            'last_name'=>$arrRequest['lninf_'.$inf],
                            'birth_date'=>$arrRequest['birthinf_'.$inf],
                            'national'=>'Indonesia'
                        ]));
                        if (array_has($arrRequest, 'passnoinf_ '.$inf)) {
                            $passInf->document_passenger()->save(new DocumentPassenger([
                                'type'=>'passport',
                                'number'=>$arrRequest['passnoinf_'.$inf],
                                'expired'=>$arrRequest['passenddateinf_'.$inf],
                                'nationality_id'=>$arrRequest['natinf_'.$inf],
                                'issued_country_id'=>$arrRequest['passnatinf_'.$inf],
                                'birth_date'=>$arrRequest['birthinf_'.$inf]
                            ]));
                        }
                    } else {
                        break;
                    }
                    $inf++;
                }
                $this->airlinesTransaction->bookings()->save($this->booking = new AirlinesBooking([
                    'airlines_code'=>$arrRequest['acDep'],
                    'origin'=>$arrRequest['org'],
                    'destination'=>$arrRequest['des'],
                    'paxpaid'=>0,
                    'status'=>'process',
                    'nta'=>0,
                    'nra'=>0,
                    'pr'=>$arrRequest['pr']

                ]));
                if (!isset($arrRequest['cabin'])) {
                    foreach ($arrResult['schedule']['departure'][0]['Flights'] as $key => $value) {
                        $class=function () use ($arrResult,$key) {
                            if (count($arrResult['schedule']['departure'][0]['Fares'])>1) {
                                return $arrResult['schedule']['departure'][0]['Fares'][$key]['SubClass'];
                            }
                            if (isset($arrResult['schedule']['departure'][0]['Fares'][0]['SubClass'])) {
                                $explode=explode(",", $arrResult['schedule']['departure'][0]['Fares'][0]['SubClass']);
                                if (count($explode)==count($arrResult['schedule']['departure'][0]['Flights'])) {
                                    return $explode[$key];
                                }
                                return $explode[0];
                            }
                            $explode[0]='i';
                            return $explode[0];
                        };
                        $stop = 0;
                        if (isset($value['Transit'])) {
                            $stop = (int) $value['Transit'];
                        }
                        $this->booking->itineraries()->save($this->itineraryDeparture[$key] = new AirlinesItinerary([
                          'pnr'=>'######',
                          'depart_return_id'=>'d',
                          'leg'=>$key+1,
                          'flight_number'=>$value['FlightNo'],
                          'class'=>$class(),
                          'std'=>$value['STD'],
                          'sta'=>$value['STA'],
                          'etd'=>$value['ETD'],
                          'eta'=>$value['ETA'],
                          'stop'=>$stop
                      ]));
                    }
                }
                if (!isset($arrRequest['cabin'])&&$arrRequest['flight']=="R") {
                    if ($arrRequest['acDep']==$arrRequest['acRet']) {
                        foreach ($arrResult['schedule']['return'][0]['Flights'] as $key => $value) {
                            $class=function () use ($arrResult,$key) {
                                if (count($arrResult['schedule']['return'][0]['Fares'])>1) {
                                    return $arrResult['schedule']['return'][0]['Fares'][$key]['SubClass'];
                                }
                                if (isset($arrResult['schedule']['return'][0]['Fares'][0]['SubClass'])) {
                                    $explode=explode(",", $arrResult['schedule']['return'][0]['Fares'][0]['SubClass']);
                                    if (count($explode)==count($arrResult['schedule']['return'][0]['Flights'])) {
                                        return $explode[$key];
                                    }
                                    return $explode[0];
                                }
                                $explode[0]='i';
                                return $explode[0];
                            };
                            $stop = 0;
                            if (isset($value['Transit'])) {
                                $stop = (int) $value['Transit'];
                            }
                            $this->booking->itineraries()->save($this->itineraryReturn[$key]=new AirlinesItinerary([
                                'pnr'=>'######',
                                'depart_return_id'=>'r',
                                'leg'=>$key+1,
                                'flight_number'=>$value['FlightNo'],
                                'class'=>$class(),
                                'std'=>$value['STD'],
                                'sta'=>$value['STA'],
                                'etd'=>$value['ETD'],
                                'eta'=>$value['ETA'],
                                'stop' => $stop
                            ]));
                        }
                    } else {
                        $this->airlinesTransaction->bookings()->save($this->bookingReturn = new AirlinesBooking([
                            'airlines_code'=>$arrRequest['acRet'],
                            'origin'=>$arrRequest['des'],
                            'destination'=>$arrRequest['org'],
                            'paxpaid'=>0,
                            'status'=>'process',
                            'nta'=>0,
                            'nra'=>0,

                        ]));
                        foreach ($arrResult['schedule']['return'][0]['Flights'] as $key => $value) {
                            $class=function () use ($arrResult,$key) {
                                if (count($arrResult['schedule']['return'][0]['Fares'])>1) {
                                    return $arrResult['schedule']['return'][0]['Fares'][$key]['SubClass'];
                                }
                                $explode=explode(",", $arrResult['schedule']['return'][0]['Fares'][0]['SubClass']);
                                if (count($explode)==count($arrResult['schedule']['return'][0]['Fares'])) {
                                    return $explode[$key];
                                }
                                return $explode[0];
                            };
                            $stop = 0;
                            if (isset($value['Transit'])) {
                                $stop = (int) $value['Transit'];
                            }
                            $this->bookingReturn->itineraries()->save($this->itineraryReturn[$key] = new AirlinesItinerary([
                                'pnr'=>'######',
                                'depart_return_id'=>'r',
                                'leg'=>$key+1,
                                'flight_number'=>$value['FlightNo'],
                                'class'=>$class(),
                                'std'=>$value['STD'],
                                'sta'=>$value['STA'],
                                'etd'=>$value['ETD'],
                                'eta'=>$value['ETA'],
                                'stop'=> $stop
                            ]));
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error($e);
                DB::rollback();

                $this->response =[
                    'status'=>[
                        'code'=>400,
                        'message'=>$e->getMessage()
                    ]
                ];
            }
            DB::commit();
            $this->totalAmount=$arrRequest['totalFare'];
            unset($arrRequest['totalFare']);

            if ($arrRequest['action']=='bookingIssued'||$arrRequest['action']=='issued') {
                $note = "airlines|".$this->airlinesTransaction->id."|Booking-Issued ".
                    $this->booking->airline->name;
                if(!isset($arrRequest['cabin'])&&$arrRequest['flight']=="R"){
                    if (!($arrRequest['acDep']==$arrRequest['acRet'])) {
                        $note.=" & ".$this->bookingReturn->airline->name;
                    }
                    $note.= " return";
                }
                $note.=" ".$this->booking->origin."-".
                    $this->booking->destination;

                $debit = Deposit::debit($this->user_id, $this->totalAmount-$arrRequest['pr'], $note)->get();
                if ($debit['status']['code']==400) {
                    return $this->response =[
                      'status'=>[
                          'code'=>400,
                          'confirm'=>'failed',
                          'message'=>'Saldo tidak mencukupi.Transaksi anda adalah IDR '.number_format(floatval($arrRequest['totalFare']))
                      ]
                  ];
                }
                if (isset($arrRequest['point'])) {
                    Point::debit($this->user_id, (int)$arrRequest['point'], 'airlines|'.$this->airlinesTransaction->id."|Booking-Issued ".
                        $this->booking->airline->name." ".
                        $this->booking->origin."-".
                        $this->booking->destination)->get();
                }
            }
            if (isset($arrRequest['international'])) {
                $this->airlinesTransaction->international = 1;
                $this->airlinesTransaction->save();
                $result=SipAirlines::GetSchedule(json_encode($arrRequest), true)->get();
            } else {
                $result=SipAirlines::GetSchedule(json_encode($arrRequest), false)->get();
            }

            if ($result['error_code']=="000") {

                // Jika TotalFare berubah maka dilakukan update total fare
                if (floatval($result['TotalAmount'])!=floatval($this->totalAmount)) {
                    $this->airlinesTransaction->total_fare=$result['TotalAmount'];
                    $this->airlinesTransaction->save();
                }

                // Jika action adalah booking, maka akan disimpan timelimit
                if ($arrRequest['action']=='booking') {
                    $this->airlinesTransaction->expired=$result['Timelimit'];
                    $this->airlinesTransaction->save();
                }
                $this->user = User::find($this->user_id);
//                $this->percentPusat=$this->user->type_user->pusat_airlines->commission;
//                $this->percentBv=$this->user->type_user->bv_airlines->commission;
//                $this->percentMember=$this->user->type_user->member_airlines->commission;
//                $nra = intval($result['TotalAmount'])-intval($result['NTA']);
//                $komisi = floor(intval($nra)*intval(config('sip-config')['member_commission'])/100);
//                $free = intval($nra)-intval($komisi);
//                $pusat = intval(($komisi * $this->percentPusat)/100);
//                $bv = intval(($komisi * $this->percentBv)/100);
//                $member= intval(($komisi * $this->percentMember)/100);
//                $upline=0;
                if ($this->user->role!='free') {
                    $this->percentPusat=$this->user->type_user->pusat_airlines->commission;
                    $this->percentBv=$this->user->type_user->bv_airlines->commission;
                    $this->percentMember=$this->user->type_user->member_airlines->commission;
                    $nra = intval($result['TotalAmount'])-intval($result['NTA']);
                    $komisi = floor(intval($nra)*intval(config('sip-config')['member_commission'])/100);
                    $free = intval($nra)-intval($komisi);
                    $pusat = intval(($komisi * $this->percentPusat)/100);
                    $bv = intval(($komisi * $this->percentBv)/100);
                    $member= intval(($komisi * $this->percentMember)/100);
                    $upline=0;
                } else {
                    $this->percentPusat=$this->user->parent->type_user->pusat_airlines->commission;
                    $this->percentBv=$this->user->parent->type_user->bv_airlines->commission;
                    $this->percentMember=$this->user->parent->type_user->member_airlines->commission;
                    $nra = intval($result['TotalAmount'])-intval($result['NTA']);
                    $komisi = floor(intval($nra)*intval(config('sip-config')['member_commission'])/100);
                    $free = intval($nra)-intval($komisi);
                    $pusat = intval(($komisi * $this->percentPusat)/100);
                    $bv = intval(($komisi * $this->percentBv)/100);
                    $member= intval(($komisi * $this->percentMember)/100);
                    $comFree = ($member * $this->user->type_user->member_airlines->commission)/100;
                    $comSIP = ($member * $this->user->type_user->pusat_airlines->commission)/100;
                    $pusat = $pusat + $comSIP;
                    $upline = $member - $comFree - $comSIP;
                    $member = $comFree;
                }

                switch ($arrRequest['action']) {
                    case 'bookingIssued':
                        if ($result['status']=="ISSUED") {
                            $this->status="issued";
                            if ((int) $arrResult['schedule']['departure'][0]['Fares'][0]['TotalFare'] > (int) $result['TotalAmount']) {

                                $credit = (int) $arrResult['schedule']['departure'][0]['Fares'][0]['TotalFare'] - (int) $result['TotalAmount'];
                                $note = "airlines|" . $this->airlinesTransaction->id . "|Kredit selisih harga " .
                                    $this->booking->airline->name." ".
                                    $this->booking->origin."-".
                                    $this->booking->destination;
                                $checkRefund = \App\HistoryDeposit::where('user_id', '=', $this->airlinesTransaction->user_id)->where('credit', '=', $credit)->where('note', '=', $note)->first();

                                if (!$checkRefund) {
                                    Deposit::credit($this->airlinesTransaction->user_id, $credit, $note);
                                }
                            }
                            $note = "airlines|" . $this->airlinesTransaction->id . "|Casback Smart Cash" .
                                $this->booking->airline->name." ".
                                $this->booking->origin."-".
                                $this->booking->destination;
                            if ($this->user->role!='free') {
                                Deposit::credit($this->user->id,$member,$note);
                            } else {
                                $noteUpline = "airlines|".$this->airlinesTransaction->id."|Kredit Smart Cash Referral ( ".$this->user->name." )".
                                $this->booking->airline->name." ".
                                $this->booking->origin."-".
                                $this->booking->destination;
                                Deposit::credit($this->user->id, $member, $note);
                                Deposit::credit($this->user->upline,$upline,$noteUpline);
                            }
                        } else {
                            $this->status='waiting-issued';
                        }
                        break;
                    case 'issued':
                        $this->status="issued";
                        break;
                    case 'booking':
                        $this->status="booking";
                        break;
                }
                $this->booking->paxpaid=$result['TotalAmount'];
                $this->booking->status=$this->status;
                $this->booking->nta=$result['NTA'];
                $this->booking->nra=$result['TotalAmount']-$result['NTA'];
                $this->booking->save();

                $this->booking->transaction_commission()->save(new AirlinesCommission([
                    'nra'=>$nra,
                    'komisi'=>$komisi,
                    'free'=>floor($free),
                    'pusat'=>ceil($pusat),
                    'bv'=>floor($bv),
                    'member'=>floor($member),
                    'upline'=>floor($upline)
                ]));

                $this->booking->transaction_number()->save(new AirlinesBookingTransactionNumber([
                    'transaction_number'=>$result['notrx']
                ]));
                if (!isset($arrRequest['cabin'])) {
                    foreach ($this->itineraryDeparture as $itinerary) {
                        $itinerary->pnr=$result['PNRDep'];
                        $itinerary->save();
                    }
                }
                if (!isset($arrRequest['cabin'])&&$arrRequest['flight']=="R") {
                    if ($arrRequest['acDep']==$arrRequest['acRet']) {
                        foreach ($this->itineraryReturn as $itinerary) {
                            $itinerary->pnr=$result['PNRRet'];
                            $itinerary->save();
                        }
                    } else {
                        if (floatval($result['TotalAmount'])!=floatval($this->totalAmount)) {
                            $oldFare=$this->airlinesTransaction->total_fare=$result['TotalAmount'];
                            $newFare=intval($oldFare)+intval($result['TotalAmountRet']);
                            $this->airlinesTransaction->total_fare=$newFare;
                            $this->airlinesTransaction->save();
                        }
//                        $nraRet = intval($result['TotalAmountRet']-$result['NTARet']);
//                        $komisiRet = (intval($nraRet)*intval(config('sip-config')['member_commission'])/100);
//                        $freeRet = intval($nraRet)-intval($komisiRet);
//                        $pusatRet =intval(($komisiRet * $this->percentPusat)/100);
//                        $bvRet = intval(($komisiRet * $this->percentBv)/100);
//                        $memberRet= intval(($komisiRet * $this->percentMember)/100);
//                        $uplineRet=0;

                        if ($this->user->role!='free') {
                            $nraRet = intval($result['TotalAmountRet'])-intval($result['NTARet']);
                            $komisiRet = floor(intval($nraRet)*intval(config('sip-config')['member_commission'])/100);
                            $freeRet = intval($nraRet)-intval($komisiRet);
                            $pusatRet = intval(($komisiRet * $this->percentPusat)/100);
                            $bvRet = intval(($komisiRet * $this->percentBv)/100);
                            $memberRet = intval(($komisiRet * $this->percentMember)/100);
                            $uplineRet=0;
                        } else {
                            $nraRet = intval($result['TotalAmountRet'])-intval($result['NTARet']);
                            $komisiRet = floor(intval($nraRet)*intval(config('sip-config')['member_commission'])/100);
                            $freeRet = intval($nraRet)-intval($komisiRet);
                            $pusatRet = intval(($komisiRet * $this->percentPusat)/100);
                            $bvRet = intval(($komisiRet * $this->percentBv)/100);
                            $memberRet= intval(($komisiRet * $this->percentMember)/100);
                            $comFreeRet = ($memberRet * $this->user->type_user->member_airlines->commission)/100;
                            $comSIPRet = ($memberRet * $this->user->type_user->pusat_airlines->commission)/100;
                            $pusatRet = $pusatRet + $comSIPRet;
                            $uplineRet = $memberRet - $comFreeRet - $comSIPRet;
                            $memberRet = $comFreeRet;
                        }
                        $this->bookingReturn->paxpaid=$result['TotalAmountRet'];
                        $this->bookingReturn->status=$this->status;
                        $this->bookingReturn->nta=$result['NTARet'];
                        $this->bookingReturn->nra=intval($result['TotalAmountRet'])-intval($result['NTARet']);
                        $this->bookingReturn->save();
                        $this->bookingReturn->transaction_number()->save(new AirlinesBookingTransactionNumber([
                            'transaction_number'=>$result['notrx']
                        ]));
                        $this->bookingReturn->transaction_commission()->save(new AirlinesCommission([
                            'nra'=>$nraRet,
                            'komisi'=>$komisiRet,
                            'free'=>floor($freeRet),
                            'pusat'=>ceil($pusatRet),
                            'bv'=>floor($bvRet),
                            'member'=>floor($memberRet),
                            'upline'=>floor($uplineRet)
                        ]));
                        foreach ($this->itineraryReturn as $itinerary) {
                            $itinerary->pnr=$result['PNRRet'];
                            $itinerary->save();
                        }
                        switch ($arrRequest['action']) {
                            case 'bookingIssued':
                                if ($result['status']=="ISSUED") {
                                    $this->status="issued";
                                    if ((int) $arrResult['schedule']['return'][0]['Fares'][0]['TotalFare'] > (int) $result['TotalAmountRet']) {

                                        $credit = (int) $arrResult['schedule']['return'][0]['Fares'][0]['TotalFare'] - (int) $result['TotalAmountRet'];
                                        $note = "airlines|" . $this->airlinesTransaction->id . "|Kredit selisih harga " .
                                            $this->bookingReturn->airline->name." ".
                                            $this->bookingReturn->origin."-".
                                            $this->bookingReturn->destination;
                                        $checkRefund = \App\HistoryDeposit::where('user_id', '=', $this->airlinesTransaction->user_id)->where('credit', '=', $credit)->where('note', '=', $note)->first();

                                        if (!$checkRefund) {
                                            Deposit::credit($this->airlinesTransaction->user_id, $credit, $note);
                                        }
                                    }
                                    $note = "airlines|" . $this->airlinesTransaction->id . "|Casback Smart Cash " .
                                        $this->bookingReturn->airline->name." ".
                                        $this->bookingReturn->origin."-".
                                        $this->bookingReturn->destination;
                                    if ($this->user->role!='free') {
                                        Deposit::credit($this->user->id,$memberRet,$note);
                                    } else {
                                        $noteUpline = "airlines|".$this->airlinesTransaction->id."|Kredit Smart Cash Referral ( ".$this->user->name." )".
                                            $this->bookingReturn->airline->name." ".
                                            $this->bookingReturn->origin."-".
                                            $this->bookingReturn->destination;
                                        Deposit::credit($this->user->id, $memberRet, $note);
                                        Deposit::credit($this->user->upline,$uplineRet,$noteUpline);
                                    }
                                } else {
                                    $this->status='waiting-issued';
                                }
                                break;
                            case 'issued':
                                $this->status="issued";
                                break;
                            case 'booking':
                                $this->status="booking";
                                break;
                        }
                    }
                }
                //
                if (isset($arrRequest['cabin'])) {
                    $param=[
                    'rqid'=>$arrRequest['rqid'],
                    'mmid'=>$arrRequest['mmid'],
                    'app'=>'information',
                    'action'=>'get_trx_detail',
                    'notrx'=>$result['notrx']
                  ];
                    $getDetail=SipAirlines::GetSchedule(json_encode($param), true)->get();
                    if ($getDetail['error_code']=="000") {
                        foreach ($getDetail['schedule']['departure']['Flights'] as $key => $value) {
                            $stop = 0;
                            if (isset($value['Transit'])) {
                                $stop = (int) $value['Transit'];
                            }
                            $this->booking->itineraries()->save($this->itineraryDeparture[$key] = new AirlinesItinerary([
                              'pnr'=>$value['PNR'],
                              'depart_return_id'=>'d',
                              'leg'=>$key+1,
                              'flight_number'=>$value['FlightNo'],
                              'class'=>$getDetail['cabin'],
                              'std'=>$value['STD'],
                              'sta'=>$value['STA'],
                              'etd'=>$value['ETD'],
                              'eta'=>$value['ETA'],
                              'stop'=> $stop
                            ]));
                        }
                        if ($getDetail['flight']=="R") {
                            foreach ($getDetail['schedule']['return']['Flights'] as $key => $value) {
                                $stop = 0;
                                if (isset($value['Transit'])) {
                                    $stop = (int) $value['Transit'];
                                }
                                $this->booking->itineraries()->save($this->itineraryReturn[$key]=new AirlinesItinerary([
                                  'pnr'=>$value['PNR'],
                                  'depart_return_id'=>'r',
                                  'leg'=>$key+1,
                                  'flight_number'=>$value['FlightNo'],
                                  'class'=>$getDetail['cabin'],
                                  'std'=>$value['STD'],
                                  'sta'=>$value['STA'],
                                  'etd'=>$value['ETD'],
                                  'eta'=>$value['ETA'],
                                  'stop'=>$stop
                                ]));
                            }
                        }
                    }
                }
                $this->response = [
                    'status'=>[
                        'code'=>200,
                        'confirm'=>'success',
                        'message'=>'success input transaction to database'
                    ],
                    'response'=>[
                        'transaction'=>$this->airlinesTransaction,
                        //'deposit'=>$deposit,
                        'booking'=>$this->booking
                    ]
                ];
            } else {
                if ($arrRequest['action']=='bookingIssued'||$arrRequest['action']=='issued') {
                    Deposit::credit($this->user_id, $this->totalAmount-$arrRequest['pr'], 'airlines|'.$this->airlinesTransaction->id.'|Refund')->get();
                    if (isset($arrRequest['point'])) {
                        Point::credit($this->user_id, (int)$arrRequest['point'], 'airlines|'.$this->airlinesTransaction->id."|Refund")->get();
                    }
                }
                $deposit=Deposit::balance($this->user_id)->get();
                $this->booking->status="failed";
                $this->booking->save();
                $this->booking->failed_message()->save(new AirlinesBookingFailedMessage([
                    'message'=>$result['error_msg']
                ]));
                if (!isset($arrRequest['cabin'])&&$arrRequest['flight']=="R"&&$arrRequest['acDep']!=$arrRequest['acRet']) {
                    $this->bookingReturn->status="failed";
                    $this->bookingReturn->save();
                    $this->bookingReturn->failed_message()->save(new AirlinesBookingFailedMessage([
                        'message'=>$result['error_msg']
                    ]));
                }
                $this->response = [
                    'status'=>[
                        'code'=>400,
                        'confirm'=>'failed',
                        'message'=>$result['error_msg']
                    ],
                    'response'=>[
                        'transaction'=>$this->airlinesTransaction,
                        'deposit'=>$deposit,
                        'booking'=>$this->booking
                    ]
                ];
            }
        } else {
            $this->response =[
                'status'=>[
                    'code'=>400,
                    'confirm'=>'failed',
                    'message'=>'Saldo tidak mencukupi.Transaksi anda adalah IDR '.number_format(floatval($arrRequest['totalFare']))
                ]
            ];
        }
    }
    private function getTransactionId()
    {
        $i=1;
        $transactionId=null;
        while (true) {
            $transactionId=$i.substr("".time(), -6);
            if (\App\AirlinesTransaction::find($transactionId)===null) {
                break;
            }
            $i++;
        }
        return $transactionId;
    }
}
